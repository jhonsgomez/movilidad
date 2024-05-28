<?php

use App\Http\Controllers\ConvenioIntController;
use App\Http\Controllers\ConvenioNacController;
use App\Http\Controllers\InstEntIntController;
use App\Http\Controllers\InstEntNacController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MovilidadIntEntController;
use App\Http\Controllers\MovilidadIntSalController;
use App\Http\Controllers\MovilidadNacEntController;
use App\Http\Controllers\MovilidadNacSalController;
use App\Http\Controllers\UserController;
use App\Models\InstitucionEntidadInt;

use App\Http\Controllers\MovilidadNacController;
use App\Http\Controllers\MovilidadIntController;
use App\Http\Controllers\ActividadesController;

// Login Routes
Route::get('/', [LoginController::class, 'show'])->name('login.index');
Route::post('/', [LoginController::class, 'consult'])->name('login.consult');
Route::get('/logout', [LoginController::class, 'destroy'])->name('login.destroy');
Route::get('/activities', [LoginController::class, 'activity_view'])->middleware('auth')->name('login.activites');

// Usuarios
Route::resource('users', UserController::class)->middleware(['auth', 'super']);
Route::get('user/password/{id}/edit', [UserController::class, 'editpass'])->name('password.edit')->middleware(['auth', 'super']);
Route::put('user/password/{id}/update', [UserController::class, 'updatepass'])->name('password.update')->middleware(['auth', 'super']);

// Create
// Instituciones
Route::get('/activities/registro_instituciones_int', [InstEntIntController::class, 'create'])
    ->name('institucionesInt.create')->middleware('auth');

Route::get('/activities/registro_instituciones_nac', [InstEntNacController::class, 'create'])
    ->name('institucionesNac.create')->middleware('auth');

Route::post('/store_instituciones_nac', [InstEntNacController::class, 'store'])
    ->name('instituciones.store_nac')->middleware(['auth']);

Route::post('/store_instituciones_int', [InstEntIntController::class, 'store'])
    ->name('instituciones.store_int')->middleware(['auth']);

// Convenios 
Route::get('/activities/registro_convenios_nac', [ConvenioNacController::class, 'create'])
    ->name('conveniosInt.create')->middleware('auth');

Route::get('/activities/registro_convenios_int', [ConvenioIntController::class, 'create'])
    ->name('conveniosNac.create')->middleware('auth');

Route::post('/store_convenios_nac', [ConvenioNacController::class, 'store'])
    ->name('convenios.store_nac')->middleware(['auth']);

Route::post('/store_convenios_int', [ConvenioIntController::class, 'store'])
    ->name('convenios.store_int')->middleware(['auth']);

// Movilidades
// Nacional
// Entrante
Route::get('/activities/registro_movilidad_nac/entrante', [MovilidadNacEntController::class, 'create'])
    ->name('movilidadNacEnt.create');

Route::post('/store_movilidad_nac_ent', [MovilidadNacEntController::class, 'store'])
    ->name('movilidadNacEnt.store')->middleware(['auth']);

// Saliente
Route::get('/activities/registro_movilidad_nac/saliente', [MovilidadNacSalController::class, 'create'])
    ->name('movilidadNacSal.create');

Route::post('/store_movilidad_nac_sal', [MovilidadNacSalController::class, 'store'])
    ->name('movilidadNacSal.store')->middleware(['auth']);

// Internacional
// Entrante
Route::get('/activities/registro_movilidad_int/entrante', [MovilidadIntEntController::class, 'create'])
    ->name('movilidadIntEnt.create');

Route::post('/store_movilidad_int_ent', [MovilidadIntEntController::class, 'store'])
    ->name('movilidadIntEnt.store')->middleware(['auth']);

// Saliente
Route::get('/activities/registro_movilidad_int/saliente', [MovilidadIntSalController::class, 'create'])
    ->name('movilidadIntSal.create');

Route::post('/store_movilidad_int_sal', [MovilidadIntSalController::class, 'store'])
    ->name('movilidadIntSal.store')->middleware(['auth']);

// Read
// Instituciones
Route::get('/activities/cons_instituciones_int', [InstEntIntController::class, 'index'])
    ->name('instituciones.show_int')->middleware('auth');

Route::get('/activities/cons_instituciones_nac', [InstEntNacController::class, 'index'])
    ->name('instituciones.show_nac')->middleware('auth');

// Convenios
Route::get('/activities/cons_convenios_int', [ConvenioIntController::class, 'index'])
    ->name('convenios.show_int')->middleware('auth');

Route::get('/activities/cons_convenios_nac', [ConvenioNacController::class, 'index'])
    ->name('convenios.show_nac')->middleware('auth');





// Movilidades
Route::get('/activities/create_movilidad_nac', [MovilidadNacController::class, 'create'])
    ->name('movilidades_nac.create')->middleware('auth');

Route::post('/activities/create_movilidad_nac', [MovilidadNacController::class, 'store'])
    ->name('movilidades_nac.store')->middleware('auth');

Route::get('/activities/cons_movilidad_nac', [MovilidadNacController::class, 'index'])
    ->name('movilidades_nac.index')->middleware('auth');

Route::get('/activities/edit_movilidad_nac/{mov_id}', [MovilidadNacController::class, 'edit'])
    ->name('movilidades_nac.edit')->middleware('auth');

Route::put('/activities/edit_movilidad_nac/{mov_id}', [MovilidadNacController::class, 'update'])
    ->name('movilidades_nac.update')->middleware('auth');

Route::post('/activities/delete_movilidad_nac/{mov_id}', [MovilidadNacController::class, 'destroy'])
    ->name('movilidades_nac.destroy')->middleware('auth');

Route::get('/download_movilidad_nac/{file}', [MovilidadNacController::class, 'download']);

Route::get('/reporte/movilidad_nac', [MovilidadNacController::class, 'exporting'])
    ->name('movilidad_nac.export')->middleware('auth');


Route::get('/activities/create_movilidad_int', [MovilidadIntController::class, 'create'])
    ->name('movilidades_int.create')->middleware('auth');

Route::post('/activities/create_movilidad_int', [MovilidadIntController::class, 'store'])
    ->name('movilidades_int.store')->middleware('auth');

Route::get('/activities/cons_movilidad_int', [MovilidadIntController::class, 'index'])
    ->name('movilidades_int.index')->middleware('auth');

Route::get('/activities/edit_movilidad_int/{mov_id}', [MovilidadIntController::class, 'edit'])
    ->name('movilidades_int.edit')->middleware('auth');

Route::put('/activities/edit_movilidad_int/{mov_id}', [MovilidadIntController::class, 'update'])
    ->name('movilidades_int.update')->middleware('auth');

Route::post('/activities/delete_movilidad_int/{mov_id}', [MovilidadIntController::class, 'destroy'])
    ->name('movilidades_int.destroy')->middleware('auth');

Route::get('/download_movilidad_int/{file}', [MovilidadIntController::class, 'download']);

Route::get('/reporte/movilidad_int', [MovilidadNacController::class, 'exporting'])
    ->name('movilidad_int.export')->middleware('auth');



Route::get('/activities/create_actividad/{mov_id}', [ActividadesController::class, 'create'])
    ->name('actividades.create')->middleware('auth');

Route::post('/activities/create_actividad/{mov_id}', [ActividadesController::class, 'store'])
    ->name('actividades.store')->middleware('auth');

Route::get('/activities/details_actividad/{act_id}', [ActividadesController::class, 'details'])
    ->name('actividades.details')->middleware('auth');

Route::get('/activities/edit_actividad/{act_id}', [ActividadesController::class, 'edit'])
    ->name('actividades.edit')->middleware('auth');

Route::put('/activities/edit_actividad/{act_id}', [ActividadesController::class, 'update'])
    ->name('actividades.update')->middleware('auth');

Route::post('/activities/delete_actividad/{act_id}', [ActividadesController::class, 'destroy'])
    ->name('actividades.destroy')->middleware('auth');

Route::get('/download_actividad/{file}', [ActividadesController::class, 'download']);




// Entrante
Route::get('/activities/cons_movilidad_int/entrante', [MovilidadIntEntController::class, 'index'])
    ->name('movilidades_ent_int.index')->middleware('auth');

Route::get('/activities/cons_movilidad_nac/entrante', [MovilidadNacEntController::class, 'index'])
    ->name('movilidades_ent_nac.index')->middleware('auth');

// Saliente

Route::get('/activities/cons_movilidad_int/saliente', [MovilidadIntSalController::class, 'index'])
    ->name('movilidades_sal_int.index')->middleware('auth');

Route::get('/activities/cons_movilidad_nac/saliente', [MovilidadNacSalController::class, 'index'])
    ->name('movilidades_sal_nac.index')->middleware('auth');


//Update
//Instituciones
Route::get('/activities/institucion_int/{inst_id}/edit', [InstEntIntController::class, 'edit'])
    ->name('institucion_int.edit')->middleware('auth');

Route::put('/activities/institucion_int/{inst_id}', [InstEntIntController::class, 'update'])
    ->name('institucion_int.update')->middleware('auth');

Route::get('/activities/institucion_nac/{inst_id}/edit', [InstEntNacController::class, 'edit'])
    ->name('institucion_nac.edit')->middleware('auth');

Route::put('/activities/institucion_nac/{inst_id}', [InstEntNacController::class, 'update'])
    ->name('institucion_nac.update')->middleware('auth');


//Convenios
Route::get('/activities/convenio_int/{conv_id}/edit', [ConvenioIntController::class, 'edit'])
    ->name('convenios_int.edit')->middleware('auth');

Route::put('/activities/convenio_int/{conv_id}', [ConvenioIntController::class, 'update'])
    ->name('convenios_int.update')->middleware('auth');

Route::get('/activities/convenio_nac/{conv_id}/edit', [ConvenioNacController::class, 'edit'])
    ->name('convenios_nac.edit')->middleware('auth');

Route::put('/activities/convenio_nac/{conv_id}', [ConvenioNacController::class, 'update'])
    ->name('convenios_nac.update')->middleware('auth');

//movilidades
//entrantes
Route::get('/activities/movilidad_int/entrante/{mov_id}/edit', [MovilidadIntEntController::class, 'edit'])
    ->name('movilidadIntEnt.edit')->middleware('auth');

Route::put('/activities/movilidad_int/entrante/{mov_id}', [MovilidadIntEntController::class, 'update'])
    ->name('movilidadIntEnt.update');



Route::get('/activities/movilidad_int/saliente/{mov_id}/edit', [MovilidadIntSalController::class, 'edit'])
    ->name('movilidadIntSal.edit')->middleware('auth');

Route::put('/activities/movilidad_int/saliente/{mov_id}', [MovilidadIntSalController::class, 'update'])
    ->name('movilidadIntSal.update')->middleware('auth');

Route::get('/activities/movilidad_nac/entrante{mov_id}/edit', [MovilidadNacEntController::class, 'edit'])
    ->name('movilidadNacEnt.edit')->middleware('auth');

Route::put('/activities/movilidad_nac/entrante/{mov_id}', [MovilidadNacEntController::class, 'update'])
    ->name('movilidadNacEnt.update')->middleware('auth');



Route::get('/activities/movilidad_nac/saliente{mov_id}/edit', [MovilidadNacSalController::class, 'edit'])
    ->name('movilidadNacSal.edit')->middleware('auth');

Route::put('/activities/movilidad_nac/saliente/{mov_id}', [MovilidadNacSalController::class, 'update'])
    ->name('movilidadNacSal.update')->middleware('auth');




//delete movilidades
Route::post('/delete_mov_int/entrante/{mov_id}', [MovilidadIntEntController::class, 'destroy'])
    ->name('movilidadIntEnt.destroy')->middleware('auth');

Route::post('/delete_mov_int/saliente/{mov_id}', [MovilidadIntSalController::class, 'destroy'])
    ->name('movilidadIntSal.destroy')->middleware('auth');

Route::post('/delete_mov_nac/entrante/{mov_id}', [MovilidadNacEntController::class, 'destroy'])
    ->name('movilidadNacEnt.destroy')->middleware('auth');

Route::post('/delete_mov_nac/saliente/{mov_id}', [MovilidadNacSalController::class, 'destroy'])
    ->name('movilidadNacSal.destroy')->middleware('auth');

// Delete
// Instituciones
Route::post('/delete_inst_int/{inst_id}', [InstEntIntController::class, 'destroy'])
    ->name('institucion_int.destroy')->middleware('auth');

Route::post('/delete_inst_nac/{inst_id}', [InstEntNacController::class, 'destroy'])
    ->name('institucion_nac.destroy')->middleware('auth');

// Convenios
Route::post('/delete_conv_int/{conv_id}', [ConvenioIntController::class, 'destroy'])
    ->name('convenio_int.destroy')->middleware('auth');

Route::post('/delete_conv_nac/{id}', [ConvenioNacController::class, 'destroy'])
    ->name('convenio_nac.destroy')->middleware('auth');


//Donwload files
Route::get('/download_ints_nac/{file}', [InstEntNacController::class, 'download']);
Route::get('/download_conv_nac/{file}', [ConvenioNacController::class, 'download']);
Route::get('/download_conv_int/{file}', [ConvenioIntController::class, 'download']);

// Making reports
// Movilidades
Route::get('/reporte/movilidad_int_ent', [MovilidadIntEntController::class, 'exporting'])
    ->name('movIntEnt.export')->middleware('auth');

Route::get('/reporte/movilidad_int_sal', [MovilidadIntSalController::class, 'exporting'])
    ->name('movIntSal.export')->middleware('auth');

Route::get('/reporte/movilidad_nac_ent', [MovilidadNacEntController::class, 'exporting'])
    ->name('movNacEnt.export')->middleware('auth');

Route::get('/reporte/movilidad_nac_sal', [MovilidadNacSalController::class, 'exporting'])
    ->name('movNacSal.export')->middleware('auth');

// Instituciones-Entidades
Route::get('/reporte/institucion_entidad_nac', [InstEntNacController::class, 'exporting'])
    ->name('instEntNac.export')->middleware('auth');

Route::get('/reporte/institucion_entidad_int', [InstEntIntController::class, 'exporting'])
    ->name('instEntInt.export')->middleware('auth');


// Convenios

Route::get('/reporte/convenio_nac', [ConvenioNacController::class, 'exporting'])
    ->name('convNac.export')->middleware('auth');

Route::get('/reporte/convenio_int', [ConvenioIntController::class, 'exporting'])
    ->name('convInt.export')->middleware('auth');

// Guests

Route::get('/activities_guest', [LoginController::class, 'show_guest'])
    ->name('activites.guest');

Route::post('/activities_guest/convenios', [LoginController::class, 'activity_guest'])
    ->name('convGuest.index');
