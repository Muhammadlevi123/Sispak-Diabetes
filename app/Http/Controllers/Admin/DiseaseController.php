<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penyakit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DiseaseController extends Controller
{
    public function index()
    {
        $penyakit = Penyakit::orderBy('kode_penyakit')->get();

        $diseases = $penyakit->map(function ($item) {
            return [
                'id' => $item->id,
                'code' => $item->kode_penyakit,
                'name' => $item->nama_penyakit,
                'description' => $item->deskripsi,
                'solution' => $item->solusi,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });

        return Inertia::render('Admin/Disease', [
            'diseases' => $diseases,
            'currentUser' => auth()->user()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:penyakit,kode_penyakit',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'solution' => 'nullable|string',
        ]);

        Penyakit::create([
            'kode_penyakit' => $validated['code'],
            'nama_penyakit' => $validated['name'],
            'deskripsi' => $validated['description'],
            'solusi' => $validated['solution'],
        ]);

        return redirect()->route('admin.diseases.index')->with('message', 'Penyakit berhasil ditambahkan.');
    }

    public function update(Request $request, $disease)
    {
        $penyakit = Penyakit::findOrFail($disease);

        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:penyakit,kode_penyakit,' . $penyakit->id,
            'name' => 'required|string',
            'description' => 'nullable|string',
            'solution' => 'nullable|string',
        ]);

        $penyakit->update([
            'kode_penyakit' => $validated['code'],
            'nama_penyakit' => $validated['name'],
            'deskripsi' => $validated['description'],
            'solusi' => $validated['solution'],
        ]);

        return redirect()->back()->with('message', 'Penyakit berhasil diperbarui.');
    }

    public function destroy(Penyakit $disease)
    {
        $disease->delete();

        return redirect()->back()->with('message', 'Penyakit berhasil dihapus.');
    }

    public function export()
    {
        $penyakit = Penyakit::select('id', 'kode_penyakit', 'nama_penyakit', 'deskripsi', 'solusi', 'created_at')->get();

        $filename = 'penyakit_export_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($penyakit) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Kode Penyakit', 'Nama Penyakit', 'Deskripsi', 'Solusi', 'Created At']);

            foreach ($penyakit as $p) {
                fputcsv($file, [
                    $p->id,
                    $p->kode_penyakit,
                    $p->nama_penyakit,
                    $p->deskripsi,
                    $p->solusi,
                    $p->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $results = Penyakit::where('nama_penyakit', 'LIKE', "%{$query}%")
            ->orWhere('kode_penyakit', 'LIKE', "%{$query}%")
            ->select('id', 'kode_penyakit', 'nama_penyakit')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'code' => $item->kode_penyakit,
                    'name' => $item->nama_penyakit,
                ];
            });

        return response()->json($results);
    }
}
