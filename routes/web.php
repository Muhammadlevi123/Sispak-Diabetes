<?php

use App\Http\Controllers\Auth\RegisteredUserController;

use App\Http\Controllers\User\DiagnosaController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SymptomController;
use App\Http\Controllers\Admin\DiseaseController;
use App\Http\Controllers\Admin\RuleController;
use App\Http\Controllers\Admin\DiagnosisController;

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login');
})->name('login');


Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');


Route::get('/user/dashboard', function () {
    return Inertia::render('User/Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

    // Route untuk halaman utama diagnosis
    Route::get('user/diagnosa', [DiagnosaController::class, 'index'])->name('user.diagnosa.index');

    // Route untuk memproses diagnosis (AJAX)
    Route::post('user/diagnosa/process', [DiagnosaController::class, 'process'])->name('user.diagnosa.process');

    // Route untuk melihat riwayat diagnosis (perlu login)
    Route::middleware(['auth'])->group(function () {
    Route::get('user/diagnosa/history', [DiagnosaController::class, 'history'])->name('user.diagnosa.history');
    Route::get('user/diagnosa/{diagnosa}', [DiagnosaController::class, 'show'])->name('user.diagnosa.show');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

    // Users Management
    Route::get('admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('admin/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
    Route::get('admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Symptoms Management
    Route::get('admin/symptoms', [SymptomController::class, 'index'])->name('admin.symptoms.index');
    Route::get('admin/symptoms/create', [SymptomController::class, 'create'])->name('admin.symptoms.create');
    Route::post('admin/symptoms', [SymptomController::class, 'store'])->name('admin.symptoms.store');
    Route::get('admin/symptoms/{symptom}', [SymptomController::class, 'show'])->name('admin.symptoms.show');
    Route::get('admin/symptoms/{symptom}/edit', [SymptomController::class, 'edit'])->name('admin.symptoms.edit');
    Route::put('admin/symptoms/{symptom}', [SymptomController::class, 'update'])->name('admin.symptoms.update');
    Route::delete('admin/symptoms/{symptom}', [SymptomController::class, 'destroy'])->name('admin.symptoms.destroy');

    // Diseases Management
    Route::get('admin/diseases', [DiseaseController::class, 'index'])->name('admin.diseases.index');
    Route::get('admin/diseases/create', [DiseaseController::class, 'create'])->name('admin.diseases.create');
    Route::post('admin/diseases', [DiseaseController::class, 'store'])->name('admin.diseases.store');
    Route::get('admin/diseases/{disease}', [DiseaseController::class, 'show'])->name('admin.diseases.show');
    Route::get('admin/diseases/{disease}/edit', [DiseaseController::class, 'edit'])->name('admin.diseases.edit');
    Route::put('admin/diseases/{disease}', [DiseaseController::class, 'update'])->name('admin.diseases.update');
    Route::delete('admin/diseases/{disease}', [DiseaseController::class, 'destroy'])->name('admin.diseases.destroy');

    // Rules Management
    Route::get('admin/rules', [RuleController::class, 'index'])->name('admin.rules.index');
    Route::get('admin/rules/create', [RuleController::class, 'create'])->name('admin.rules.create');
    Route::post('admin/rules', [RuleController::class, 'store'])->name('admin.rules.store');
    Route::get('admin/rules/{rule}', [RuleController::class, 'show'])->name('admin.rules.show');
    Route::get('admin/rules/{rule}/edit', [RuleController::class, 'edit'])->name('admin.rules.edit');
    Route::put('admin/rules/{rule}', [RuleController::class, 'update'])->name('admin.rules.update');
    Route::delete('admin/rules/{rule}', [RuleController::class, 'destroy'])->name('admin.rules.destroy');

    // Diagnosis History
    Route::get('admin/diagnosis', [DiagnosisController::class, 'index'])->name('admin.diagnosis.index');
    // Route::post('admin/diagnosis', [DiagnosisController::class, 'store'])->name('admin.diagnosis.store');
    Route::get('admin/diagnosis/{diagnosis}', [DiagnosisController::class, 'show'])->name('admin.diagnosis.show');
    Route::delete('admin/diagnosis/{diagnosis}', [DiagnosisController::class, 'destroy'])->name('admin.diagnosis.destroy');

//     // Settings
//     Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
//     Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
