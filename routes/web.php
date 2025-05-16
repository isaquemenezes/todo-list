<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\PasswordResetController;

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\TarefaUsuarioController;
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
Route::post('auth/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Painel do admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{usuario}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{usuario}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{usuario}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Painel do usuário comum
Route::middleware(['auth'])->group(function () {
    Route::get('/usuario', [UsuarioController::class, 'index'])->name('usuario.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/tarefas', [TarefaController::class, 'index'])->name('tarefas.index');
    Route::get('/tarefas/create', [TarefaController::class, 'create'])->name('tarefas.create');
    Route::post('/tarefas', [TarefaController::class, 'store'])->name('tarefas.store');
    Route::get('/tarefas/{tarefa}/edit', [TarefaController::class, 'edit'])->name('tarefas.edit');
    Route::put('/tarefas/{tarefa}', [TarefaController::class, 'update'])->name('tarefas.update');
    Route::delete('/tarefas/{tarefa}', [TarefaController::class, 'destroy'])->name('tarefas.destroy');

    Route::put('/tarefas/{tarefa}/concluir', [TarefaController::class, 'concluir'])
    ->name('tarefas.concluir');

    // Route::resource('tarefas', TarefaController::class)->except(['show']);

});

Route::middleware(['auth'])->group(function () {
    Route::get('tarefas/{tarefa}/gerenciar-usuarios', [TarefaUsuarioController::class, 'edit'])->name('tarefas.gerenciar-usuarios.edit');
    Route::put('tarefas/{tarefa}/gerenciar-usuarios', [TarefaUsuarioController::class, 'update'])->name('tarefas.gerenciar-usuarios.update');
});

// Formulário de atualização da senha para usuário deslogado
Route::get('/recuperar-senha', [PasswordResetController::class, 'formEmail'])->name('senha.email.form');
Route::post('/recuperar-senha', [PasswordResetController::class, 'verificarEmail'])->name('senha.email.verificar');

Route::get('/nova-senha/{user}', [PasswordResetController::class, 'formNovaSenha'])->name('senha.nova.form');
Route::post('/nova-senha/{user}', [PasswordResetController::class, 'salvarNovaSenha'])->name('senha.nova.salvar');

// Formulário de atualização da senha para usuário logado
Route::get('/perfil/senha', [PasswordResetController::class, 'formSenhaUsuarioLogado'])
    ->name('perfil.senha.form')
    ->middleware('auth');

// Enviar nova senha
Route::post('/perfil/senha', [PasswordResetController::class, 'salvarSenhaUsuarioLogado'])
    ->name('perfil.senha.salvar')
    ->middleware('auth');

