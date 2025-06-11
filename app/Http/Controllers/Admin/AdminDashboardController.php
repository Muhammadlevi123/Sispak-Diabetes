<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Penyakit;
use App\Models\Gejala;
use App\Models\Rule;
use App\Models\Diagnosa;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistik total
        $totalUsers = User::count();
        $totalPenyakit = Penyakit::count();
        $totalGejala = Gejala::count();
        $totalRules = Rule::count();
        $totalDiagnosa = Diagnosa::count();

        // Ambil semua user
        $users = User::latest()->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'created_at' => $user->created_at,
            ];
        });

        // Semua penyakit dengan jumlah diagnosa
        $penyakitData = Penyakit::withCount('diagnosas')
            ->orderBy('diagnosas_count', 'desc')
            ->get()
            ->map(function ($penyakit) {
                return [
                    'id' => $penyakit->id,
                    'code' => $penyakit->kode_penyakit,
                    'name' => $penyakit->nama_penyakit,
                    'diagnosa_count' => $penyakit->diagnosas_count,
                ];
            });

        // Semua gejala dengan jumlah diagnosa
        $gejalaData = Gejala::withCount('diagnosas')
            ->orderBy('diagnosas_count', 'desc')
            ->get()
            ->map(function ($gejala) {
                return [
                    'id' => $gejala->id,
                    'code' => $gejala->kode_gejala,
                    'name' => $gejala->nama_gejala,
                    'diagnosa_count' => $gejala->diagnosas_count,
                ];
            });

        // Semua diagnosa terbaru
        $diagnosaData = Diagnosa::with(['user', 'penyakit'])
            ->latest()
            ->get()
            ->map(function ($diagnosa) {
                return [
                    'id' => $diagnosa->id,
                    'user' => [
                        'id' => $diagnosa->user->id,
                        'name' => $diagnosa->user->name,
                    ],
                    'penyakit' => $diagnosa->penyakit ? [
                        'id' => $diagnosa->penyakit->id,
                        'code' => $diagnosa->penyakit->kode_penyakit,
                        'name' => $diagnosa->penyakit->nama_penyakit,
                    ] : null,
                    'created_at' => $diagnosa->created_at,
                ];
            });

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'total_users' => $totalUsers,
                'total_penyakit' => $totalPenyakit,
                'total_gejala' => $totalGejala,
                'total_rules' => $totalRules,
                'total_diagnosa' => $totalDiagnosa,
            ],
            'users' => $users,
            'penyakit_populer' => $penyakitData,
            'gejala_populer' => $gejalaData,
            'all_diagnosa' => $diagnosaData,
            'currentUser' => auth()->user(),
        ]);
    }
}
