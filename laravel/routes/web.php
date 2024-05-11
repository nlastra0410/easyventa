<?php

use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

// Autenticación
Auth::routes(['register' => false]);

// Página de inicio
Route::get('/', 'App\Http\Livewire\Sale\SaleCreat')->name('home')->middleware(['auth']);

// Página de inicio de sesión personalizada
Route::get('/login', function () {
    return view('login');
});

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Rutas accesibles solo para vendedores
    Route::middleware(['vendedor'])->group(function () {
        Route::get('/clientes', 'App\Http\Livewire\Client\ClientComponent')->name('clients');
        Route::get('/clientes/{client}', 'App\Http\Livewire\Client\ClientShow')->name('clients.show');
        Route::get('/categorias', 'App\Http\Livewire\Category\CategoryComponent')->name('category');
        Route::get('/categorias/{category}', 'App\Http\Livewire\Category\CategoryShow')->name('categories.show');
        Route::get('/enfermedad', 'App\Http\Livewire\Enfermedad\EnfermedadComponent')->name('enfermedad');
        Route::get('/enfermedad/{category}', 'App\Http\Livewire\Enfermedad\EnfermedadShow')->name('enfermedad.show');
        Route::get('/principio', 'App\Http\Livewire\Principio\PrincipioComponent')->name('principio');
        Route::get('/principio/{category}', 'App\Http\Livewire\Principio\PrincipioShow')->name('principio.show');
        Route::get('/productos', 'App\Http\Livewire\Product\ProductComponent')->name('products');
        Route::get('/cierre', 'App\Http\Livewire\Cierre\ReporteCierre')->name('cierre');
        Route::get('/cierre/{cierre}', 'App\Http\Livewire\Cierre\VerReporte')->name('cierre.show');
        Route::get('/datos', 'App\Http\Livewire\Tienda\DatosTienda')->name('datos');
        Route::get('/usuarios', 'App\Http\Livewire\User\UserComponent')->name('users');
        Route::get('/sucursal', 'App\Http\Livewire\Sucursal\SucursalComponent')->name('sucursal');
        Route::get('/sucursal/{category}', 'App\Http\Livewire\Sucursal\SucursalShow')->name('sucursal.show');
        Route::get('/suscripcion', 'App\Http\Livewire\Suscribs\SuscribsComponent')->name('suscrib');
        Route::get('/suscripcion/{suscrib}', 'App\Http\Livewire\Suscribs\SuscribsShow')->name('suscrib.show');
        Route::get('/suscriptor', 'App\Http\Livewire\Suscrip\SuscripComponent')->name('suscrip');
    });

    // Rutas generales
    Route::get('/productos/{product}', 'App\Http\Livewire\Product\ProductShow')->name('products.show');
    Route::get('/usuarios/{user}', 'App\Http\Livewire\User\UserShow')->name('users.show');
    Route::get('/show-pdf/{id}', 'App\Http\Livewire\Sale\SaleCreat@showPdf');
    Route::get('/ventas/crear', 'App\Http\Livewire\Sale\SaleCreat')->name('sales.create');
    Route::get('/pos', 'App\Http\Livewire\Pos\Componente')->name('pos');
    Route::get('/sales/{sale}', 'App\Http\Livewire\Sale\SaleShow')->name('sales.show');
    Route::get('/reporte', 'App\Http\Livewire\Reporte\Lista')->name('reporte');
    Route::get('/sales/invoice/{sale}', [PdfController::class, 'invoice'])->name('sales.invoice');
    Route::get('/inventario', 'App\Http\Livewire\Inventario\InventarioComponent')->name('inventario');
    Route::get('/ajuste', 'App\Http\Livewire\Inventario\AjusteComponent')->name('ajuste');
    Route::get('/movimiento', 'App\Http\Livewire\Inventario\MovimientoComponent')->name('movimiento');
    Route::get('/proveedor', 'App\Http\Livewire\Provedor\ProvedorComponent')->name('proveedor');
    Route::get('/proveedor/{proveedor}', 'App\Http\Livewire\Provedor\ProvedorShow')->name('proveedor.show');
    Route::get('/factura/{proveedor}', 'App\Http\Livewire\Provedor\ProvedorFactura')->name('proveedor.factura');
    Route::get('/reporteIn', 'App\Http\Livewire\Inventario\ReporteComponent')->name('reporteIn');
    Route::get('/kardex', 'App\Http\Livewire\Inventario\KardexComponent')->name('kardex');
    Route::get('/cierre/salida', 'App\Http\Livewire\Corte\CorteCaja@abreCierre')->name('cierre.salida');
    Route::post('/actualizar-tipo-pago/{venta}', 'App\Http\Livewire\Sale\SaleCreat@actualizarTipoPago')->name('ventas.actualizar_tipo_pago');
    Route::get('/impresora', 'App\Http\Livewire\Impresoras\VerImpresora')->name('impresora');
    Route::get('sales/print/{sale}', 'App\Http\Livewire\Sale\SaleCreat@print')->name('sales.print');
});
