    <?php

    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\EnderecoController;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\PessoaController;
    use Illuminate\Support\Facades\Route;

    /*
    |---------------------------------------------------------------------- 
    | Web Routes
    |---------------------------------------------------------------------- 
    | Here is where you can register web routes for your application.
    | These routes are loaded by the RouteServiceProvider within a group
    | which contains the "web" middleware group. Now create something great!
    |
    */

    // Página inicial
    Route::match(['get', 'post'], '/', [HomeController::class, 'filtrar'])
        ->name('home');

    // Grupo de rotas para Cadastro de Pessoa e Endereço
    Route::prefix('cadastro')->group(function () {
        Route::match(['get', 'post'], '/pessoa', [PessoaController::class, 'cadastro'])
            ->name('cadastro.pessoa');

        Route::prefix('endereco')->group(function () {
            Route::get('/', [EnderecoController::class, 'formEndereco'])
                ->name('cadastro.endereco.form');
            Route::post('/', [EnderecoController::class, 'cadastrarEndereco'])
                ->name('cadastro.endereco');
        });
    });

    // Grupo de rotas para Admin
    Route::prefix('admin')->group(function () {
        // Rota para listar as pessoas (GET puro)
        Route::get('/listar', [AdminController::class, 'listar'])
            ->name('admin.listar');

        // Rota para edit
        Route::get('/edit/{id}', [AdminController::class, 'edit'])
            ->name('admin.edit');

        // Rota para update
        Route::put('/update/{id}', [AdminController::class, 'update'])
            ->name('admin.update');

        // Rota para delete
        Route::delete('/destroy/{id}', [AdminController::class, 'destroy'])
            ->name('admin.destroy');

        // Rota para restore
        Route::get('/restore', [AdminController::class, 'restore'])->name('admin.restore');
        Route::post('/restore/{id}', [AdminController::class, 'restore'])->name('admin.restore.single');

        // Rota para deletar permanentemente os dados
        Route::delete('/admin/force-delete/{id}', [AdminController::class, 'forceDelete'])->name('admin.forceDelete');
    });
