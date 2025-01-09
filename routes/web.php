<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\FuncionarioVariavelController;
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




Route::get('/create/funcionario', [FuncionarioController::class, 'create'])->name('funcionario.create');
Route::post('/store/funcionario', [FuncionarioController::class, 'store'])->name('funcionario.store');

Route::get('/create/variavel', [VariavelController::class, 'create'])->name('variavel.create');
Route::post('/store/variavel', [VariavelController::class, 'store'])->name('variavel.store');


Route::get('/', [FuncionarioVariavelController::class, 'index'])->name('/');
Route::post('/employee-variables', [FuncionarioVariavelController::class, 'store'])->name('employee-variables.store');

Route::get('/employee-variables/export', [FuncionarioVariavelController::class, 'export'])->name('employee-variables.export');


Route::get('/api/search-employees', [ApiController::class, 'searchEmployees']);
Route::get('/api/search-variables', [ApiController::class, 'searchVariables']);
Route::get('/api/employee-variables/{employeeId}', [ApiController::class, 'getEmployeeVariables']);
Route::post('/employee-variables', [FuncionarioVariavelController::class, 'store'])->name('employee-variables.store');
Route::delete('/employee-variables/{id}', [FuncionarioVariavelController::class, 'destroy'])->name('employee-variables.destroy');
