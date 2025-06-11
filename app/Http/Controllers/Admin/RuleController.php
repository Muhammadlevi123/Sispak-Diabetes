<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use App\Models\Penyakit;
use App\Models\Gejala;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RuleController extends Controller
{
    public function index()
    {
        $rules = Rule::with(['penyakit', 'gejala'])->orderBy('kode_rule')->get();

        $data = $rules->map(function ($item) {
            return [
                'id' => $item->id,
                'code' => $item->kode_rule,
                'disease' => [
                    'id' => $item->penyakit->id,
                    'code' => $item->penyakit->kode_penyakit,
                    'name' => $item->penyakit->nama_penyakit,
                ],
                'symptoms' => $item->gejala->map(function ($gejala) {
                    return [
                        'id' => $gejala->id,
                        'name' => $gejala->nama_gejala,
                    ];
                }),
                'description' => $item->keterangan,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });

        return Inertia::render('Admin/Rule', [
            'rules' => $data,
            'diseases' => Penyakit::select('id','kode_penyakit', 'nama_penyakit')->get(),
            'symptoms' => Gejala::select('id', 'nama_gejala')->get(),
            'currentUser' => auth()->user(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:rules,kode_rule',
            'disease_id' => 'required|exists:penyakit,id',
            'symptom_ids' => 'required|array|min:1',
            'symptom_ids.*' => 'exists:gejala,id',
            'description' => 'nullable|string',
        ]);

        $rule = Rule::create([
            'kode_rule' => $validated['code'],
            'penyakit_id' => $validated['disease_id'],
            'keterangan' => $validated['description'],
        ]);

        $rule->gejala()->sync($validated['symptom_ids']);

        return redirect()->route('admin.rules.index')->with('message', 'Rule berhasil ditambahkan.');
    }

    public function update(Request $request, $ruleId)
    {
        $rule = Rule::findOrFail($ruleId);

        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:rules,kode_rule,' . $rule->id,
            'disease_id' => 'required|exists:penyakit,id',
            'symptom_ids' => 'required|array|min:1',
            'symptom_ids.*' => 'exists:gejala,id',
            'description' => 'nullable|string',
        ]);

        $rule->update([
            'kode_rule' => $validated['code'],
            'penyakit_id' => $validated['disease_id'],
            'keterangan' => $validated['description'],
        ]);

        $rule->gejala()->sync($validated['symptom_ids']);

        return redirect()->back()->with('message', 'Rule berhasil diperbarui.');
    }

    public function destroy(Rule $rule)
    {
        $rule->gejala()->detach();
        $rule->delete();

        return redirect()->back()->with('message', 'Rule berhasil dihapus.');
    }

    public function export()
    {
        $rules = Rule::with(['penyakit', 'gejala'])->get();

        $filename = 'rules_export_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($rules) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Kode Rule', 'Penyakit', 'Gejala (IDs)', 'Keterangan', 'Created At']);

            foreach ($rules as $rule) {
                fputcsv($file, [
                    $rule->id,
                    $rule->kode_rule,
                    $rule->penyakit->nama_penyakit ?? '-',
                    $rule->gejala->pluck('id')->implode(','),
                    $rule->keterangan,
                    $rule->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $results = Rule::with('penyakit')
            ->where('kode_rule', 'LIKE', "%{$query}%")
            ->orWhereHas('penyakit', function ($q) use ($query) {
                $q->where('nama_penyakit', 'LIKE', "%{$query}%");
            })
            ->select('id', 'kode_rule', 'penyakit_id')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'code' => $item->kode_rule,
                    'disease' => $item->penyakit->nama_penyakit ?? '-',
                ];
            });

        return response()->json($results);
    }
}
