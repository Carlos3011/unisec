<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\CursoController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\PonentesController;
use App\Http\Controllers\Admin\TemaController;
use App\Http\Controllers\Admin\TallerController;

use App\Http\Controllers\Admin\SeccionNoticiaController;
use App\Http\Controllers\Admin\NoticiaController;
use App\Http\Controllers\Admin\PagoPreRegistroController;

/*----
| Controladores para la gestión de de concursos
----*/
use App\Http\Controllers\Admin\Concurso\ConcursoController;
use App\Http\Controllers\Admin\Concurso\ConvocatoriaConcursoController;
use App\Http\Controllers\Admin\Concurso\PreRegistroConcursoController;
use App\Http\Controllers\Admin\AdminPagoTerceroController;

use App\Http\Controllers\User\Concurso\ConcursoUserController;
use App\Http\Controllers\User\Concurso\ConvocatoriaUserController;
use App\Http\Controllers\User\Concurso\PreRegistroUserController;
use App\Http\Controllers\User\Concurso\PagoTerceroController;

/*----
| Controladores para la gestión de de congresos
----*/
use App\Http\Controllers\Admin\Congreso\CongresoController;
use App\Http\Controllers\Admin\Congreso\ConvocatoriaCongresoController;
use App\Http\Controllers\Admin\Congreso\InscripcionCongresoController;
use App\Http\Controllers\Admin\PagoInscripcionCongresoController;

use App\Http\Controllers\User\Congreso\CongresoUserController;
use App\Http\Controllers\User\Congreso\ConvocatoriaCongresoUserController;
use App\Http\Controllers\User\Congreso\InscripcionCongresoUserController;

use App\Http\Controllers\PayPalController;
use App\Http\Controllers\PayPalInscripcionController;
use App\Http\Controllers\WebPayController;

use App\Models\ConvocatoriaConcurso;
use App\Models\ConvocatoriaCongreso;

use App\Http\Middleware\RoleMiddleware;

Route::middleware(['auth'])->group(function () {
    Route::prefix('user/concursos/pagos')->group(function () {
        // Vista del formulario de pago
        Route::get('pre-registro/{convocatoria}', function(ConvocatoriaConcurso $convocatoria) {
            return view('user.concursos.pagos.pre-registro', compact('convocatoria'));
        })->name('user.concursos.pagos.pre-registro');

        // Endpoints para PayPal
        Route::post('create-order', [PayPalController::class, 'createOrder']);
        Route::match(['get', 'post'], 'capture-order', [PayPalController::class, 'captureOrder']);
    });

    Route::prefix('user/congresos/pagos')->group(function () {
        // Vista del formulario de pago
        Route::get('inscripcion/{convocatoria}', function(ConvocatoriaCongreso $convocatoria) {
            return view('user.congresos.pagos.inscripcion', compact('convocatoria'));
        })->name('user.congresos.pagos.inscripcion');

        // Endpoints para PayPal
        Route::post('create-order', [PayPalInscripcionController::class, 'createOrder'])->name('user.congresos.pagos.create-order');
        Route::post('capture-order', [PayPalInscripcionController::class, 'captureOrder'])->name('user.congresos.pagos.capture-order');
    });
});

Route::controller(PublicController::class)->group(function () {
    Route::get('/', 'inicio')->name('inicio');
    Route::get('/acerca', 'acerca')->name('acerca');
    Route::get('/espacio', 'espacio')->name('espacio');

    Route::get('/convocatorias-publicas', 'convocatorias')->name('convocatorias.index');
    Route::get('/convocatorias-publicas/concurso/{convocatoria}', 'show')->name('convocatorias.show');
    Route::get('/convocatorias-publicas/congreso/{convocatoria}', 'showConvocatoriaCongreso')->name('convocatorias.congreso.show');
    

    Route::get('/miembros', 'miembros')->name('miembros');

    Route::get('/blog', 'blog')->name('blog');
    Route::get('/noticias/{noticia}', 'showNoticia')->name('noticias.show');

    Route::get('/contacto', 'contacto')->name('contacto');
});

// Redirigir al dashboard correcto según el rol del usuario autenticado
Route::get('/dashboard', function () {
    if (Auth::user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('user.inicio');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupo de rutas para Administradores
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Rutas para la gestión de todo lo relaciona con concursos
    Route::get('/admin/concursos', [ConcursoController::class, 'index'])->name('admin.concursos.index');
    Route::get('/admin/concursos/create', [ConcursoController::class, 'create'])->name('admin.concursos.create');
    Route::post('/admin/concursos', [ConcursoController::class, 'store'])->name('admin.concursos.store');
    Route::get('/admin/concursos/{concurso}/edit', [ConcursoController::class, 'edit'])->name('admin.concursos.edit');
    Route::put('/admin/concursos/{concurso}', [ConcursoController::class, 'update'])->name('admin.concursos.update');
    Route::delete('/admin/concursos/{concurso}', [ConcursoController::class, 'destroy'])->name('admin.concursos.destroy');

    Route::get('/admin/convocatorias', [ConvocatoriaConcursoController::class, 'index'])->name('admin.concursos.convocatorias.index');
    Route::get('/admin/convocatorias/create', [ConvocatoriaConcursoController::class, 'create'])->name('admin.concursos.convocatorias.create');
    Route::post('/admin/convocatorias', [ConvocatoriaConcursoController::class, 'store'])->name('admin.concursos.convocatorias.store');
    Route::get('/admin/convocatorias/{convocatoria}', [ConvocatoriaConcursoController::class, 'show'])->name('admin.concursos.convocatorias.show');
    Route::get('/admin/convocatorias/{convocatoria}/edit', [ConvocatoriaConcursoController::class, 'edit'])->name('admin.concursos.convocatorias.edit');
    Route::put('/admin/convocatorias/{convocatoria}', [ConvocatoriaConcursoController::class, 'update'])->name('admin.concursos.convocatorias.update');
    Route::delete('/admin/convocatorias/{convocatoria}', [ConvocatoriaConcursoController::class, 'destroy'])->name('admin.concursos.convocatorias.destroy');

    Route::get('/admin/pre-registros', [PreRegistroConcursoController::class, 'index'])->name('admin.concursos.pre-registros.index');
    Route::get('/admin/pre-registros/{preRegistro}', [PreRegistroConcursoController::class, 'show'])->name('admin.concursos.pre-registros.show');
    Route::get('/admin/pre-registros/{preRegistro}/edit', [PreRegistroConcursoController::class, 'edit'])->name('admin.concursos.pre-registros.edit');
    Route::put('/admin/pre-registros/{preRegistro}', [PreRegistroConcursoController::class, 'update'])->name('admin.concursos.pre-registros.update');
    Route::delete('/admin/pre-registros/{preRegistro}', [PreRegistroConcursoController::class, 'destroy'])->name('admin.concursos.pre-registros.destroy');
    Route::put('/admin/pre-registros/{preRegistro}/estado', [PreRegistroConcursoController::class, 'updateEstado'])->name('admin.concursos.pre-registros.update-estado');
    Route::get('/admin/pre-registros/{preRegistro}/download-pdr', [PreRegistroConcursoController::class, 'downloadPdr'])->name('admin.concursos.pre-registros.download-pdr');


    // Rutas para la gestión de usuarios
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    // Rutas para la gestión de categorías
    Route::get('/admin/categorias', [CategoriaController::class, 'index'])->name('admin.categorias.index');
    Route::post('/admin/categorias', [CategoriaController::class, 'store'])->name('admin.categorias.store');
    Route::put('/admin/categorias/{categoria}', [CategoriaController::class, 'update'])->name('admin.categorias.update');
    Route::delete('/admin/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('admin.categorias.destroy');

    // Rutas para la gestión de cursos
    Route::get('/admin/cursos', [CursoController::class, 'index'])->name('admin.cursos.index');
    Route::get('/admin/cursos/create', [CursoController::class, 'create'])->name('admin.cursos.create');
    Route::post('/admin/cursos', [CursoController::class, 'store'])->name('admin.cursos.store');
    Route::get('/admin/cursos/{curso}/edit', [CursoController::class, 'edit'])->name('admin.cursos.edit');
    Route::put('/admin/cursos/{curso}', [CursoController::class, 'update'])->name('admin.cursos.update');
    Route::delete('/admin/cursos/{curso}', [CursoController::class, 'destroy'])->name('admin.cursos.destroy');

    // Rutas para la gestión de ponentes
    Route::get('/admin/ponentes', [PonentesController::class, 'index'])->name('admin.ponentes.index');
    Route::get('/admin/ponentes/create', [PonentesController::class, 'create'])->name('admin.ponentes.create');
    Route::post('/admin/ponentes', [PonentesController::class, 'store'])->name('admin.ponentes.store');
    Route::get('/admin/ponentes/{ponente}/edit', [PonentesController::class, 'edit'])->name('admin.ponentes.edit');
    Route::put('/admin/ponentes/{ponente}', [PonentesController::class, 'update'])->name('admin.ponentes.update');
    Route::delete('/admin/ponentes/{ponente}', [PonentesController::class, 'destroy'])->name('admin.ponentes.destroy');

    // Rutas para la gestión de talleres
    Route::get('/admin/talleres', [TallerController::class, 'index'])->name('admin.talleres.index');
    Route::get('/admin/talleres/create', [TallerController::class, 'create'])->name('admin.talleres.create');
    Route::post('/admin/talleres', [TallerController::class, 'store'])->name('admin.talleres.store');
    Route::get('/admin/talleres/{taller}/edit', [TallerController::class, 'edit'])->name('admin.talleres.edit');
    Route::put('/admin/talleres/{taller}', [TallerController::class, 'update'])->name('admin.talleres.update');
    Route::delete('/admin/talleres/{taller}', [TallerController::class, 'destroy'])->name('admin.talleres.destroy');



    Route::get('/admin/congresos-eventos', [AdminController::class, 'congresosEventos'])->name('admin.congresos-eventos');
    Route::get('/admin/becas', [AdminController::class, 'becas'])->name('admin.becas');
    Route::get('/admin/pagos-facturacion', [AdminController::class, 'pagosFacturacion'])->name('admin.pagos-facturacion');
    Route::get('/admin/reportes-estadisticas', [AdminController::class, 'reportesEstadisticas'])->name('admin.reportes-estadisticas');

    // Rutas para la gestión de pagos de terceros
    Route::get('/admin/pagos-terceros', [AdminPagoTerceroController::class, 'index'])->name('admin.pagos-terceros.index');
    Route::get('/admin/pagos-terceros/{pago}', [AdminPagoTerceroController::class, 'show'])->name('admin.pagos-terceros.show');
    Route::put('/admin/pagos-terceros/{pago}/estado', [AdminPagoTerceroController::class, 'updateEstado'])->name('admin.pagos-terceros.update-estado');

    // Rutas para la gestión de pagos de pre-registro
    Route::get('/admin/pagos', [PagoPreRegistroController::class, 'index'])->name('admin.pagos.index');
    Route::get('/admin/pagos/{pago}', [PagoPreRegistroController::class, 'show'])->name('admin.pagos.show');
    Route::get('/admin/pagos/{pago}/factura', [PagoPreRegistroController::class, 'generarFactura'])->name('admin.pagos.factura');
    Route::get('/admin/pagos/exportar', [PagoPreRegistroController::class, 'exportarPagos'])->name('admin.pagos.exportar');

    // Rutas para la gestión de secciones de noticias
    Route::get('/admin/secciones', [SeccionNoticiaController::class, 'index'])->name('admin.noticias.secciones.index');
    Route::get('/admin/secciones/create', [SeccionNoticiaController::class, 'create'])->name('admin.noticias.secciones.create');
    Route::post('/admin/secciones', [SeccionNoticiaController::class, 'store'])->name('admin.noticias.secciones.store');
    Route::get('/admin/secciones/{seccion}/edit', [SeccionNoticiaController::class, 'edit'])->name('admin.noticias.secciones.edit');
    Route::put('/admin/secciones/{seccion}', [SeccionNoticiaController::class, 'update'])->name('admin.noticias.secciones.update');
    Route::delete('/admin/secciones/{seccion}', [SeccionNoticiaController::class, 'destroy'])->name('admin.noticias.secciones.destroy');
    Route::post('/admin/secciones/{id}/restore', [SeccionNoticiaController::class, 'restore'])->name('admin.noticias.secciones.restore');

    // Rutas para la gestión de noticias
    Route::get('/admin/noticias', [NoticiaController::class, 'index'])->name('admin.noticias.noticia.index');
    Route::get('/admin/noticias/create', [NoticiaController::class, 'create'])->name('admin.noticias.noticia.create');
    Route::post('/admin/noticias', [NoticiaController::class, 'store'])->name('admin.noticias.noticia.store');
    Route::get('/admin/noticias/{noticia}/edit', [NoticiaController::class, 'edit'])->name('admin.noticias.noticia.edit');
    Route::put('/admin/noticias/{noticia}', [NoticiaController::class, 'update'])->name('admin.noticias.noticia.update');
    Route::delete('/admin/noticias/{noticia}', [NoticiaController::class, 'destroy'])->name('admin.noticias.noticia.destroy');

    // Rutas para la gestion de congresos
    Route::get('/admin/congresos', [CongresoController::class, 'index'])->name('admin.congresos.index');
    Route::get('/admin/congresos/create', [CongresoController::class, 'create'])->name('admin.congresos.create');
    Route::post('/admin/congresos', [CongresoController::class, 'store'])->name('admin.congresos.store');
    Route::get('/admin/congresos/{congreso}', [CongresoController::class, 'show'])->name('admin.congresos.show');
    Route::get('/admin/congresos/{congreso}/edit', [CongresoController::class, 'edit'])->name('admin.congresos.edit');
    Route::put('/admin/congresos/{congreso}', [CongresoController::class, 'update'])->name('admin.congresos.update');
    Route::delete('/admin/congresos/{congreso}', [CongresoController::class, 'destroy'])->name('admin.congresos.destroy');

    // Rutas para la gestion de convocatorias de congresos
    Route::get('/admin/congresos-convocatorias', [ConvocatoriaCongresoController::class, 'index'])->name('admin.congresos.convocatorias.index');
    Route::get('/admin/congresos-convocatorias/create', [ConvocatoriaCongresoController::class, 'create'])->name('admin.congresos.convocatorias.create');
    Route::post('/admin/congresos-convocatorias', [ConvocatoriaCongresoController::class, 'store'])->name('admin.congresos.convocatorias.store');
    Route::get('/admin/congresos-convocatorias/{convocatoria}', [ConvocatoriaCongresoController::class, 'show'])->name('admin.congresos.convocatorias.show');
    Route::get('/admin/congresos-convocatorias/{convocatoria}/edit', [ConvocatoriaCongresoController::class, 'edit'])->name('admin.congresos.convocatorias.edit');
    Route::put('/admin/congresos-convocatorias/{convocatoria}', [ConvocatoriaCongresoController::class, 'update'])->name('admin.congresos.convocatorias.update');
    Route::delete('/admin/congresos-convocatorias/{convocatoria}', [ConvocatoriaCongresoController::class, 'destroy'])->name('admin.congresos.convocatorias.destroy');

    // Rutas para la gestión de inscripciones de congresos
    Route::get('/admin/congresos-inscripciones', [InscripcionCongresoController::class, 'index'])->name('admin.congresos.inscripciones.index');
    Route::get('/admin/congresos-inscripciones/{inscripcion}', [InscripcionCongresoController::class, 'show'])->name('admin.congresos.inscripciones.show');
    Route::post('/admin/congresos-inscripciones/{inscripcion}/evaluar-articulo', [InscripcionCongresoController::class, 'evaluarArticulo'])->name('admin.congresos.inscripciones.evaluar-articulo');
    Route::post('/admin/congresos-inscripciones/{inscripcion}/evaluar-extenso', [InscripcionCongresoController::class, 'evaluarExtenso'])->name('admin.congresos.inscripciones.evaluar-extenso');
    Route::post('/admin/congresos-inscripciones/{inscripcion}/actualizar-pago', [InscripcionCongresoController::class, 'actualizarEstadoPago'])->name('admin.congresos.inscripciones.actualizar-pago');
    Route::delete('/admin/congresos-inscripciones/{inscripcion}', [InscripcionCongresoController::class, 'destroy'])->name('admin.congresos.inscripciones.destroy');

    // Rutas para la gestión de pagos de inscripciones de congresos
    Route::get('/admin/congresos-pagos', [PagoInscripcionCongresoController::class, 'index'])->name('admin.congresos.pagos.index');
    Route::get('/admin/congresos-pagos/{pago}', [PagoInscripcionCongresoController::class, 'show'])->name('admin.congresos.pagos.show');
    Route::get('/admin/congresos-pagos/{pago}/factura', [PagoInscripcionCongresoController::class, 'generarFactura'])->name('admin.congresos.pagos.factura');
    Route::get('/admin/congresos-pagos/exportar', [PagoInscripcionCongresoController::class, 'exportarPagos'])->name('admin.congresos.pagos.exportar');

    // Rutas para descarga de artículos
    Route::get('/admin/congresos/articulos/{articulo}/download', [App\Http\Controllers\Admin\Congreso\InscripcionCongresoController::class, 'downloadArticulo'])
        ->name('admin.congresos.articulos.download')
        ->middleware(['auth', 'admin']);

    Route::get('/admin/congresos/articulos/{articulo}/download-extenso', [App\Http\Controllers\Admin\Congreso\InscripcionCongresoController::class, 'downloadExtenso'])
        ->name('admin.congresos.articulos.download-extenso')
        ->middleware(['auth', 'admin']);
}); 

// Grupo de rutas para Usuarios
Route::middleware(['auth', 'role:usuario'])->group(function () {
    Route::get('/user/inicio', [UserController::class, 'index'])->name('user.inicio');

    //Ruta para la pagina del sistema solar
    Route::get('/user/espacio', [UserController::class, 'espacio'])->name('user.espacio');

    //Ruta para la pagina de noticias
    Route::get('/user/noticias', [UserController::class, 'noticia'])->name('user.noticias');
    Route::get('/user/noticias/{noticia}', [UserController::class, 'showNoticia'])->name('user.noticias.show');

    Route::get('/user/cursos', [UserController::class, 'cursos'])->name('user.cursos');
    Route::get('/user/talleres', [UserController::class, 'talleres'])->name('user.talleres');
    Route::get('/user/ponencias', [UserController::class, 'ponencias'])->name('user.ponencias');

    // Rutas para la gestión de concursos del usuario
    Route::get('/user/concursos', [ConcursoUserController::class, 'index'])->name('user.concursos.index');
    Route::get('/user/concursos/{concurso}', [ConcursoUserController::class, 'show'])->name('user.concursos.show');
    
    // Rutas para la gestión de convocatorias del usuario
    Route::get('/user/convocatorias', [ConvocatoriaUserController::class, 'index'])->name('user.concursos.convocatorias.index');
    Route::get('/user/convocatorias/{convocatoria}', [ConvocatoriaUserController::class, 'show'])->name('user.concursos.convocatorias.show');

    // Rutas para la gestión de congresos del usuario
    Route::get('/user/congresos', [CongresoUserController::class, 'index'])->name('user.congresos.index');
    Route::get('/user/congresos/{congreso}/convocatoria', [CongresoUserController::class, 'showConvocatoria'])->name('user.congresos.convocatoria');
    Route::get('/user/congresos/filter/tematica', [CongresoUserController::class, 'filterByTematica'])->name('user.congresos.filter.tematica');

    // Rutas para la gestión de convocatorias de congresos
    Route::get('/user/congresos/convocatorias/{convocatoria}', [ConvocatoriaCongresoUserController::class, 'show'])->name('user.congresos.convocatorias.show');
    Route::get('/user/congresos/convocatorias/{convocatoria}/download', [ConvocatoriaCongresoUserController::class, 'downloadConvocatoria'])->name('user.congresos.convocatorias.download');
    Route::get('/user/congresos/convocatorias/{convocatoria}/download/articulo', [ConvocatoriaCongresoUserController::class, 'downloadArticulo'])->name('user.congresos.convocatorias.download.articulo');
    Route::get('/user/congresos/convocatorias/{convocatoria}/download/formato-extenso', [ConvocatoriaCongresoUserController::class, 'downloadFormatoExtenso'])->name('user.congresos.convocatorias.download.formato-extenso');

    // Rutas para la gestión de inscripciones a congresos
    Route::get('/user/congresos/inscripciones', [InscripcionCongresoUserController::class, 'index'])->name('user.congresos.inscripciones.index');
    Route::get('/user/congresos/inscripciones/create/{convocatoria}', [InscripcionCongresoUserController::class, 'create'])->name('user.congresos.inscripciones.create');
    Route::post('/user/congresos/inscripciones', [InscripcionCongresoUserController::class, 'store'])->name('user.congresos.inscripciones.store');
    Route::get('/user/congresos/inscripciones/{inscripcion}', [InscripcionCongresoUserController::class, 'show'])->name('user.congresos.inscripciones.show');
    Route::get('/user/congresos/inscripciones/{inscripcion}/edit', [InscripcionCongresoUserController::class, 'edit'])->name('user.congresos.inscripciones.edit');
    Route::put('/user/congresos/inscripciones/{inscripcion}', [InscripcionCongresoUserController::class, 'update'])->name('user.congresos.inscripciones.update');
    Route::get('/user/congresos/inscripciones/{inscripcion}/factura', [InscripcionCongresoUserController::class, 'factura'])->name('user.congresos.inscripciones.factura');
    Route::get('/user/congresos/inscripciones/{inscripcion}/comprobante', [InscripcionCongresoUserController::class, 'downloadComprobante'])->name('user.congresos.inscripciones.comprobante');

    // Rutas para la gestión de artículos
    Route::post('/user/congresos/articulos/{articulo}/extenso', [InscripcionCongresoUserController::class, 'subirExtenso'])->name('user.congresos.articulos.subir-extenso');
    Route::get('/user/congresos/articulos/{articulo}/download', [InscripcionCongresoUserController::class, 'downloadArticulo'])->name('user.congresos.articulos.download');
    Route::get('/user/congresos/articulos/{articulo}/download-extenso', [InscripcionCongresoUserController::class, 'downloadExtenso'])->name('user.congresos.articulos.download-extenso');

    // Rutas para la gestión de pre-registros del usuario
    Route::get('/user/pre-registros', [PreRegistroUserController::class, 'index'])->name('user.concursos.pre-registros.index');
    Route::get('/user/pre-registros/create/{convocatoria}', [PreRegistroUserController::class, 'create'])->name('user.concursos.pre-registros.create');
    Route::post('/user/pre-registros', [PreRegistroUserController::class, 'store'])->name('user.concursos.pre-registros.store');
    Route::get('/user/pre-registros/{preRegistro}', [PreRegistroUserController::class, 'show'])->name('user.concursos.pre-registros.show');
    Route::get('/user/pre-registros/{preRegistro}/edit', [PreRegistroUserController::class, 'edit'])->name('user.concursos.pre-registros.edit');
    Route::get('/user/pre-registros/{preRegistro}/download-pdr', [PreRegistroUserController::class, 'downloadPdr'])->name('user.concursos.pre-registros.download-pdr');
    Route::put('/user/pre-registros/{preRegistro}', [PreRegistroUserController::class, 'update'])->name('user.concursos.pre-registros.update');
    Route::delete('/user/pre-registros/{preRegistro}', [PreRegistroUserController::class, 'destroy'])->name('user.concursos.pre-registros.destroy');
    Route::get('/pre-registros/{preRegistro}/factura', [PreRegistroUserController::class, 'factura'])
    ->name('user.concursos.pre-registros.factura');

    // Rutas para la gestión de pagos por terceros
    Route::get('/user/pagos-terceros/validar', [PagoTerceroController::class, 'validar'])->name('user.concursos.pagos-terceros.validar');
    Route::get('/user/pagos-terceros', [PagoTerceroController::class, 'index'])->name('user.concursos.pagos-terceros.index');
    Route::get('/user/pagos-terceros/create', [PagoTerceroController::class, 'create'])->name('user.concursos.pagos-terceros.create');
    Route::post('/user/pagos-terceros', [PagoTerceroController::class, 'store'])->name('user.concursos.pagos-terceros.store');
    Route::get('/user/pagos-terceros/{pago}', [PagoTerceroController::class, 'show'])->name('user.concursos.pagos-terceros.show');

    Route::post('/user/pagos-terceros/validar-codigo', [PagoTerceroController::class, 'validarCodigo'])->name('user.concursos.pagos-terceros.validar-codigo');
    Route::post('/user/pagos-terceros/usar-codigo-pre-registro/{preRegistro}', [PagoTerceroController::class, 'usarCodigoEnPreRegistro'])->name('user.concursos.pagos-terceros.usar-codigo-pre-registro');
    Route::post('/user/pagos-terceros/usar-codigo-inscripcion/{inscripcion}', [PagoTerceroController::class, 'usarCodigoEnInscripcion'])->name('user.concursos.pagos-terceros.usar-codigo-inscripcion');

    Route::get('/user/inscripciones', [UserController::class, 'inscripciones'])->name('user.inscripciones');
    Route::get('/user/certificados', [UserController::class, 'certificados'])->name('user.certificados');
    Route::get('/user/pagos', [UserController::class, 'pagos'])->name('user.pagos');
    Route::get('/user/resenas', [UserController::class, 'resenas'])->name('user.resenas');
    Route::get('/user/eventos', [UserController::class, 'eventos'])->name('user.eventos');
    Route::get('/user/soporte', [UserController::class, 'soporte'])->name('user.soporte');
});


// Perfil de usuario
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de WebPay sin middleware de autenticación para permitir notificaciones externas
Route::post('/webpay/notify', [WebPayController::class, 'notify'])->name('webpay.notify'); // URL POST para MIT
Route::get('/webpay/result', [WebPayController::class, 'result'])->name('webpay.result');   // URL para el usuario

require __DIR__ . '/auth.php';

