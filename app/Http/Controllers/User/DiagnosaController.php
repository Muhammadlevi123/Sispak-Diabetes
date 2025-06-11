<?php

namespace App\Http\Controllers\User;

use App\Models\Diagnosa;
use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\Rule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class DiagnosaController extends Controller
{
     public function index()
    {
        // Ambil semua gejala untuk membangun decision tree
        $gejalas = Gejala::all();
        $penyakits = Penyakit::with('rules.gejala')->get();

        // Build diagnosis tree dari gejala
        $diagnosisTree = $this->buildDiagnosisTree($gejalas);

        // Ambil gejala pertama untuk mulai diagnosis
        $firstGejala = $gejalas->first();

        return Inertia::render('User/Diagnosa', [
            'diagnosisTree' => $diagnosisTree,
            'gejalas' => $gejalas,
            'penyakits' => $penyakits,
            'firstNode' => $firstGejala ? $firstGejala->kode_gejala : null
        ]);
    }

    public function process(Request $request)
    {
        $request->validate([
            'currentNode' => 'required|string',
            'answer' => 'required|in:yes,no',
            'answers' => 'array'
        ]);

        $currentNode = $request->currentNode;
        $answer = $request->answer;
        $answers = $request->answers ?? [];

        // Tambahkan jawaban saat ini ke riwayat
        $gejala = Gejala::where('kode_gejala', $currentNode)->first();
        if ($gejala) {
            $answers[] = [
                'kode_gejala' => $currentNode,
                'question' => $gejala->nama_gejala,
                'answer' => $answer
            ];
        }

        // Cek apakah diagnosis sudah bisa ditentukan
        $diagnosisResult = $this->checkDiagnosis($answers);

        if ($diagnosisResult) {
            // Simpan hasil diagnosis ke database jika user login
            if (Auth::check()) {
                $this->saveDiagnosis($answers, $diagnosisResult);
            }

            return response()->json([
                'isComplete' => true,
                'result' => $diagnosisResult,
                'answers' => $answers,
                'progress' => 100
            ]);
        }

        // Tentukan pertanyaan selanjutnya
        $nextNode = $this->getNextQuestion($answers);

        if (!$nextNode) {
            // Jika tidak ada pertanyaan lagi, berikan diagnosis default
            $defaultResult = $this->getDefaultDiagnosis($answers);

            if (Auth::check()) {
                $this->saveDiagnosis($answers, $defaultResult);
            }

            return response()->json([
                'isComplete' => true,
                'result' => $defaultResult,
                'answers' => $answers,
                'progress' => 100
            ]);
        }

        // Hitung progress
        $totalQuestions = Gejala::count();
        $progress = (count($answers) / $totalQuestions) * 100;

        return response()->json([
            'isComplete' => false,
            'nextNode' => $nextNode,
            'answers' => $answers,
            'progress' => min($progress, 95) // Max 95% sampai diagnosis selesai
        ]);
    }

    private function buildDiagnosisTree($gejalas)
    {
        $tree = [];

        foreach ($gejalas as $gejala) {
            $tree[$gejala->kode_gejala] = [
                'question' => $gejala->nama_gejala,
                'description' => 'Apakah Anda mengalami gejala ini?'
            ];
        }

        return $tree;
    }

    private function checkDiagnosis($answers)
    {
        if (empty($answers)) {
            return null;
        }

        // Ambil semua rule dengan gejala yang terkait
        $rules = Rule::with(['penyakit', 'gejala'])->get();

        $bestMatch = null;
        $highestScore = 0;

        foreach ($rules as $rule) {
            $score = $this->calculateRuleScore($rule, $answers);

            if ($score > $highestScore) {
                $highestScore = $score;
                $bestMatch = $rule;
            }
        }

        // Jika ada match dengan confidence > 70%
        if ($bestMatch && $highestScore > 0.7) {
            return $this->formatDiagnosisResult($bestMatch, $highestScore);
        }

        return null;
    }

    private function calculateRuleScore($rule, $answers)
    {
        $requiredGejala = $rule->gejala->pluck('kode_gejala')->toArray();
        $answeredGejala = collect($answers)->pluck('kode_gejala')->toArray();
        $positiveAnswers = collect($answers)
            ->where('answer', 'yes')
            ->pluck('kode_gejala')
            ->toArray();

        if (empty($requiredGejala)) {
            return 0;
        }

        // Hitung berapa banyak gejala yang sesuai
        $matchingSymptoms = array_intersect($requiredGejala, $positiveAnswers);
        $score = count($matchingSymptoms) / count($requiredGejala);

        // Bonus jika semua gejala required sudah dijawab
        $answeredRequiredSymptoms = array_intersect($requiredGejala, $answeredGejala);
        if (count($answeredRequiredSymptoms) === count($requiredGejala)) {
            $score += 0.1; // Bonus 10%
        }

        return min($score, 1.0);
    }

    private function formatDiagnosisResult($rule, $confidence)
    {
        $penyakit = $rule->penyakit;

        // Tentukan risk level berdasarkan confidence
        if ($confidence >= 0.9) {
            $riskLevel = 'Tinggi';
            $color = 'red';
        } elseif ($confidence >= 0.8) {
            $riskLevel = 'Sedang-Tinggi';
            $color = 'orange';
        } elseif ($confidence >= 0.7) {
            $riskLevel = 'Sedang';
            $color = 'yellow';
        } else {
            $riskLevel = 'Rendah';
            $color = 'green';
        }

        // Parse solusi menjadi array recommendations
        $recommendations = $penyakit->solusi ?
            explode('|', $penyakit->solusi) :
            ['Konsultasi dengan dokter untuk pemeriksaan lanjutan'];

        return [
            'type' => $penyakit->nama_penyakit,
            'risk_level' => $riskLevel,
            'description' => $penyakit->deskripsi ?: 'Berdasarkan gejala yang Anda alami, kemungkinan Anda mengalami kondisi ini.',
            'recommendations' => $recommendations,
            'confidence' => round($confidence * 100, 1),
            'color' => $color,
            'penyakit_id' => $penyakit->id
        ];
    }

    private function getNextQuestion($answers)
    {
        $answeredCodes = collect($answers)->pluck('kode_gejala')->toArray();

        // Ambil gejala yang belum dijawab
        $nextGejala = Gejala::whereNotIn('kode_gejala', $answeredCodes)
            ->orderBy('kode_gejala')
            ->first();

        return $nextGejala ? $nextGejala->kode_gejala : null;
    }

    private function getDefaultDiagnosis($answers)
    {
        // Jika tidak ada diagnosis yang cocok, berikan hasil default
        $positiveAnswers = collect($answers)->where('answer', 'yes')->count();
        $totalAnswers = count($answers);

        if ($positiveAnswers === 0) {
            return [
                'type' => 'Kondisi Normal',
                'risk_level' => 'Rendah',
                'description' => 'Berdasarkan jawaban Anda, tidak ditemukan indikasi diabetes melitus. Namun, tetap jaga pola hidup sehat.',
                'recommendations' => [
                    'Pertahankan pola makan sehat dengan gizi seimbang',
                    'Rutin berolahraga minimal 30 menit per hari',
                    'Kontrol berat badan ideal',
                    'Pemeriksaan kesehatan rutin setiap 6 bulan'
                ],
                'confidence' => 75.0,
                'color' => 'green',
                'penyakit_id' => null
            ];
        } else {
            return [
                'type' => 'Perlu Pemeriksaan Lanjutan',
                'risk_level' => 'Sedang',
                'description' => 'Berdasarkan gejala yang Anda alami, disarankan untuk melakukan pemeriksaan lebih lanjut.',
                'recommendations' => [
                    'Segera konsultasi dengan dokter',
                    'Lakukan pemeriksaan gula darah',
                    'Catat gejala yang dialami',
                    'Jaga pola makan dan hindari makanan tinggi gula'
                ],
                'confidence' => 60.0,
                'color' => 'yellow',
                'penyakit_id' => null
            ];
        }
    }

    private function saveDiagnosis($answers, $result)
    {
        try {
            DB::beginTransaction();

            // Simpan diagnosis
            $diagnosis = Diagnosa::create([
                'user_id' => Auth::id(),
                'penyakit_id' => $result['penyakit_id'],
                'tanggal' => now('Asia/Jakarta')
            ]);

            // Simpan gejala yang dijawab 'yes'
            $positiveSymptoms = collect($answers)
                ->where('answer', 'yes')
                ->pluck('kode_gejala')
                ->toArray();

            if (!empty($positiveSymptoms)) {
                $gejalaIds = Gejala::whereIn('kode_gejala', $positiveSymptoms)
                    ->pluck('id')
                    ->toArray();

                $diagnosis->gejalas()->attach($gejalaIds);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saving diagnosis: ' . $e->getMessage());
        }
    }

    public function history()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $diagnoses = Diagnosa::with(['penyakit', 'gejalas'])
            ->where('user_id', Auth::id())
            ->orderByDesc('tanggal')
            ->paginate(10);

        return Inertia::render('User/Diagnosa/History', [
            'diagnoses' => $diagnoses
        ]);
    }

    public function show(Diagnosa $diagnosis)
    {
        if (!Auth::check() || $diagnosis->user_id !== Auth::id()) {
            abort(403);
        }

        $diagnosis->load(['penyakit', 'gejalas']);

        return Inertia::render('User/Diagnosa/Show', [
            'diagnosis' => $diagnosis
        ]);
    }
}
