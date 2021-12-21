<?php

use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\NotificacionesController;
use App\Http\Controllers\VacanteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes(['verify' => true]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas protegidas

Route::group(['middleware' =>['auth','verified']], function(){
    // Rutas de vacantes
    Route::get('/vacantes',[VacanteController::class,'index'])->name('vacantes.index');
    Route::get('/vacantes/create',[VacanteController::class,'create'])->name('vacantes.create');
    Route::post('/vacantes',[VacanteController::class,'store'])->name('vacantes.store');
    Route::delete('/vacantes/{vacante}',[VacanteController::class,'destroy'])->name('vacantes.destroy');
    Route::get('/vacantes/{vacante}/edit',[VacanteController::class,'edit'])->name('vacantes.edit');
    Route::put('/vacantes/{vacante}',[VacanteController::class,'update'])->name('vacantes.update');

    //Subir Imagenes
    Route::post('/vacantes/imagen',[VacanteController::class,'imagen'])->name('vacantes.imagen');
    Route::post('/vacantes/borrarimagen',[VacanteController::class,'borrarimagen'])->name('vacantes.borrar');

    //Cambiar estado de la vacante
    Route::post('/vacantes/{vacante}',[VacanteController::class,'estado'])->name('vacantes.estado');
    //Notificaciones
    Route::get('/notificaciones',NotificacionesController::class)->name('notificaciones');

});

// Pagina de inicio
Route::get('/',InicioController::class)->name('inicio');

// Categorias

Route::get('/categorias/{categoria}',[CategoriaController::class,'show'])->name('categorias.show');

// Enviar datos para una vacante
Route::get('/candidatos/{id}',[CandidatoController::class,'index'])->name('candidatos.index');
Route::post('/candidatos/store',[CandidatoController::class,'store'])->name('candidatos.store');


// Nota tambien importa el orden en que lo pongas en este ejemplo se muestra ( colocar los comodines al final: comodines son estos vacante/{"aca es el comodin"})
Route::get('/busqueda/buscar', [VacanteController::class,'resultados'])->name('vacantes.resultados');
Route::post('/busqueda/buscar', [VacanteController::class,'buscar'])->name('vacantes.buscar');


// Muestra los trabajos en el front end sin la autentificacion
Route::get('/vacantes/{vacante}',[VacanteController::class,'show'])->name('vacantes.show');







