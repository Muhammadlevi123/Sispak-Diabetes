<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diagnosa;
use App\Models\Penyakit;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DiagnosisController extends Controller
{
     public function index()
{
    $diagnosas = Diagnosa::with(['user', 'penyakit'])
        ->orderByDesc('tanggal')
        ->get();

    $data = $diagnosas->map(function ($item) {
        return [
            'id' => $item->id,
            'user' => [
                'id' => $item->user->id,
                'name' => $item->user->name,
                'email' => $item->user->email,
            ],
            'disease' => $item->penyakit ? [
                'id' => $item->penyakit->id,
                'code' => $item->penyakit->kode_penyakit,
                'name' => $item->penyakit->nama_penyakit,
            ] : null,
            // Menggunakan accessor dari model
            'diagnosed_at' => $item->tanggal_wib->format('Y-m-d H:i:s'),
            'diagnosed_at_readable' => $item->tanggal_formatted, // Format yang sudah readable
        ];
    });

    return Inertia::render('Admin/Diagnosis', [
        'diagnoses' => $data,
        'diseases' => Penyakit::select('id', 'kode_penyakit', 'nama_penyakit')->get(),
        'users' => User::where('role', 'user')->select('id', 'name')->get(),
        'currentUser' => auth()->user(),
    ]);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'penyakit_id' => 'nullable|exists:penyakit,id',
    ]);

    $user = User::where('id', $validated['user_id'])->where('role', 'user')->first();

    if (!$user) {
        return redirect()->back()->withErrors(['user_id' => 'User tidak valid atau bukan pasien.']);
    }

    // Model akan otomatis mengatur timezone melalui boot method
    Diagnosa::create([
        'user_id' => $validated['user_id'],
        'penyakit_id' => $validated['penyakit_id'],
        // tanggal akan otomatis diset oleh boot method jika tidak diisi
    ]);

    return redirect()->route('admin.diagnosis.index')->with('message', 'Riwayat diagnosa berhasil ditambahkan.');
}


    public function destroy($id)
{
    $diagnosa = Diagnosa::find($id);

    if (!$diagnosa) {
        return redirect()->back()->withErrors(['error' => 'Data tidak ditemukan.']);
    }

    $diagnosa->delete();
    return redirect()->back()->with('message', 'Riwayat diagnosa berhasil dihapus.');
}

    public function export()
    {
        $diagnoses = Diagnosa::with(['user', 'penyakit'])->get();

        $filename = 'diagnosis_export_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($diagnoses) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Nama User', 'Email', 'Penyakit', 'Tanggal Diagnosa']);

            foreach ($diagnoses as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->user->name,
                    $item->user->email,
                    $item->penyakit->nama_penyakit ?? '-',
                    $item->tanggal->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
