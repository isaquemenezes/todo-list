<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\TarefaUsuarioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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

Route::get('/', function () {

    if (Auth::user()->is_admin ?? false) {
        return redirect()->route('admin.index');
    }

    return redirect()->route('usuario.index');
})->middleware('auth')->name('home');



Route::get('auth/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('auth/login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Painel do admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    Route::resource('users', UserController::class)->except(['show'])->names('users');
});

// Painel do usuário comum
Route::middleware(['auth'])->group(function () {
    Route::get('/usuario', [UserController::class, 'perfil'])->name('usuario.perfil');
});


Route::middleware(['auth'])->group(function () {
    Route::resource('tarefas', TarefaController::class)->except(['show']);

    Route::put('tarefas/{tarefa}/concluir', [TarefaController::class, 'concluir'])
        ->name('tarefas.concluir');

    Route::get('tarefas/{tarefa}/gerenciar-usuarios', [TarefaUsuarioController::class, 'edit'])
        ->name('tarefas.gerenciar-usuarios.edit');

    Route::put('tarefas/{tarefa}/gerenciar-usuarios', [TarefaUsuarioController::class, 'update'])
        ->name('tarefas.gerenciar-usuarios.update');

});

// Route::middleware(['auth'])->group(function () {
//     Route::get('tarefas/{tarefa}/gerenciar-usuarios', [TarefaUsuarioController::class, 'edit'])
//         ->name('tarefas.gerenciar-usuarios.edit');
//     Route::put('tarefas/{tarefa}/gerenciar-usuarios', [TarefaUsuarioController::class, 'update'])
//         ->name('tarefas.gerenciar-usuarios.update');
// });

// Formulário de atualização da senha para usuário deslogado
Route::get('/recuperar-senha', [PasswordResetController::class, 'formEmail'])
    ->name('senha.email.form');
Route::post('/recuperar-senha', [PasswordResetController::class, 'verificarEmail'])
    ->name('senha.email.verificar');

Route::get('/nova-senha/{user}', [PasswordResetController::class, 'formNovaSenha'])
    ->name('senha.nova.form');
Route::post('/nova-senha/{user}', [PasswordResetController::class, 'salvarNovaSenha'])
    ->name('senha.nova.salvar');

// Formulário de atualização da senha para usuário logado
Route::middleware('auth')->prefix('perfil/senha')->name('perfil.senha.')->group(function () {
    // Formulário de atualização da senha
    Route::get('/', [PasswordResetController::class, 'formSenhaUsuarioLogado'])->name('form');
    // Enviar nova senha
    Route::post('/', [PasswordResetController::class, 'salvarSenhaUsuarioLogado'])->name('salvar');
});
// Route::get('/perfil/senha', [PasswordResetController::class, 'formSenhaUsuarioLogado'])
//     ->name('perfil.senha.form')
//     ->middleware('auth');

// // Enviar nova senha
// Route::post('/perfil/senha', [PasswordResetController::class, 'salvarSenhaUsuarioLogado'])
//     ->name('perfil.senha.salvar')
//     ->middleware('auth');

