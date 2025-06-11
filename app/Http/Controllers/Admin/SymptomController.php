<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class SymptomController extends Controller
{
    public function index()
    {
        $gejala = Gejala::orderBy('kode_gejala')->get();

        // Transform data to match Vue component expectations
        $symptoms = $gejala->map(function ($item) {
            return [
                'id' => $item->id,
                'code' => $item->kode_gejala,
                'name' => $item->nama_gejala,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });

        return Inertia::render('Admin/Symptom', [
            'symptoms' => $symptoms, // Change key to 'symptoms'
            'currentUser' => auth()->user()
        ]);
    }

    public function store(Request $request)
    {
    $validated = $request->validate([
        'code' => 'required|string|max:10|unique:gejala,kode_gejala',
        'name' => 'required|string',
    ]);

    Gejala::create([
        'kode_gejala' => $validated['code'],
        'nama_gejala' => $validated['name'],
    ]);

    return redirect()->route('admin.symptoms.index')->with('message', 'Gejala berhasil ditambahkan.');
    }


    public function update(Request $request, $symptom)
    {
    // Manual model binding
    $gejala = Gejala::findOrFail($symptom);

    $validated = $request->validate([
        'code' => 'required|string|max:10|unique:gejala,kode_gejala,' . $gejala->id,
        'name' => 'required|string',
    ]);

    $gejala->update([
        'kode_gejala' => $validated['code'],
        'nama_gejala' => $validated['name'],
    ]);

    return redirect()->back()->with('message', 'Gejala berhasil diperbarui.');
    }

    public function destroy(Gejala $symptom)
        {
        $symptom->delete();

        return redirect()->back()->with('message', 'Gejala berhasil dihapus.');
    }

    public function export()
    {
        $gejala = Gejala::select('id', 'kode_gejala', 'nama_gejala', 'created_at')->get();

        $filename = 'gejala_export_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($gejala) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Kode Gejala', 'Nama Gejala', 'Created At']);

            foreach ($gejala as $g) {
                fputcsv($file, [
                    $g->id,
                    $g->kode_gejala,
                    $g->nama_gejala,
                    $g->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $results = Gejala::where('nama_gejala', 'LIKE', "%{$query}%")
            ->orWhere('kode_gejala', 'LIKE', "%{$query}%")
            ->select('id', 'kode_gejala', 'nama_gejala')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'code' => $item->kode_gejala,
                    'name' => $item->nama_gejala,
                ];
            });

        return response()->json($results);
    }
}
