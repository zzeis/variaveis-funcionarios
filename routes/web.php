<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\FuncionarioVariavelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VariavelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





Route::middleware(['auth','active'])->group(function () {


    Route::get('/dashboard', [VariavelController::class, 'index'])->name('dashboard');


    //funcionarios
    Route::get('/create/funcionario', [FuncionarioController::class, 'create'])->name('funcionario.create');
    Route::post('/store/funcionario', [FuncionarioController::class, 'store'])->name('funcionario.store');
    Route::get('/funcionarios', [FuncionarioController::class, 'index'])->name('funcionarios.index');
    Route::get('/funcionarios/{id}/edit', [FuncionarioController::class, 'edit'])->name('funcionarios.edit');
    Route::put('/funcionarios/{id}', [FuncionarioController::class, 'update'])->name('funcionarios.update');


    //variavel
    Route::get('/variaveis/list', [VariavelController::class, 'list'])->name('variaveis.list');
    Route::get('/variavel/{id}/edit', [VariavelController::class, 'edit'])->name('variavel.edit');
    Route::put('/variavel/{id}', [VariavelController::class, 'update'])->name('variavel.update');
    Route::get('/create/variavel', [VariavelController::class, 'create'])->name('variavel.create');
    Route::post('/store/variavel', [VariavelController::class, 'store'])->name('variavel.store');

    Route::get('/', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('/employee-variables', [FuncionarioVariavelController::class, 'store'])->name('employee-variables.store');

    Route::get('/employee-variables/export', [FuncionarioVariavelController::class, 'export'])->name('employee-variables.export');


    Route::get('/api/search-employees', [ApiController::class, 'searchEmployees']);
    Route::get('/api/search-variables', [ApiController::class, 'searchVariables']);
    Route::get('/api/employee-variables/{employeeId}', [ApiController::class, 'getEmployeeVariables']);
    Route::post('/employee-variables', [FuncionarioVariavelController::class, 'store'])->name('employee-variables.store');
    Route::delete('/employee-variables/{id}', [FuncionarioVariavelController::class, 'destroy'])->name('employee-variables.destroy');


    Route::get('/variaveis', [FuncionarioVariavelController::class, 'index'])->name('variaveis');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
