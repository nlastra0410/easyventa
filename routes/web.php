<?php


use App\Http\Controllers\PdfController;
use App\Livewire\Category\CategoryComponent;
use App\Livewire\Category\CategoryShow;
use App\Livewire\Cierre\ReporteCierre;
use App\Livewire\Cierre\VerReporte;
use App\Livewire\Client\ClientComponent;
use App\Livewire\Client\ClientShow;
use App\Livewire\Corte\CorteCaja;
use App\Livewire\Enfermedad\EnfermedadComponent;
use App\Livewire\Enfermedad\EnfermedadShow;
use App\Livewire\Impresoras\VerImpresora;
use App\Livewire\Inventario\AjusteComponent;
use App\Livewire\Inventario\InventarioComponent;
use App\Livewire\Inventario\KardexComponent;
use App\Livewire\Inventario\MovimientoComponent;
use App\Livewire\Inventario\ReporteComponent;
use App\Livewire\Pos\Componente;
use App\Livewire\Principio\PrincipioComponent;
use App\Livewire\Principio\PrincipioShow;
use App\Livewire\Product\ProductComponent;
use App\Livewire\Product\ProductShow;
use App\Livewire\Provedor\ProvedorComponent;
use App\Livewire\Provedor\ProvedorFactura;
use App\Livewire\Provedor\ProvedorShow;
use App\Livewire\Reporte\Lista;
use App\Livewire\Sale\SaleCreat;
use App\Livewire\Sale\SaleCreate;
use App\Livewire\Sale\SaleList;
use App\Livewire\Sale\SaleShow;
use App\Livewire\Sale\VentaCreate;
use App\Livewire\Shop\ShopComponent;
use App\Livewire\Sucursal\SucursalComponent;
use App\Livewire\Sucursal\SucursalShow;
use App\Livewire\Suscribs\SuscribsComponent;
use App\Livewire\Suscribs\SuscribsShow;
use App\Livewire\Suscrip\SuscripComponent;
use App\Livewire\Tienda\DatosTienda;
use App\Livewire\User\UserComponent;
use App\Livewire\User\UserShow;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home\Inicio;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes(['register' => false]);
Route::get('/login', function(){
    return view('login');
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', SaleCreat::class)->name('home')->middleware(['auth']);

// Route::get('/categorias',CategoryComponent::class)->name('category')->middleware(['auth']);

// Route::get('/categorias/{category}',CategoryShow::class)->name('categories.show')->middleware(['auth']);
// Route::get('/enfermedad', EnfermedadComponent::class)->name('enfermedad')->middleware(['auth']);
// Route::get('/enfermedad/{category}', EnfermedadShow::class)->name('enfermedad.show')->middleware(['auth']);
// Route::get('principio', PrincipioComponent::class)->name('principio')->middleware(['auth']);
// Route::get('/principio/{category}', PrincipioShow::class)->name('principio.show')->middleware(['auth']);
// Route::get('/productos', ProductComponent::class)->name('products')->middleware(['auth']);
Route::get('/corte', CorteCaja::class)->name('corte')->middleware(['auth']);
Route::get('/productos/{product}', ProductShow::class)->name('products.show')->middleware(['auth']);
// Route::get('/usuarios', UserComponent::class)->name('users')->middleware(['auth']);
// Route::get('/sucursal', SucursalComponent::class)->name('sucursal')->middleware(['auth']);
// Route::get('/sucursal/{category}', SucursalShow::class)->name('sucursal.show')->middleware(['auth']);
Route::get('/usuarios/{user}', UserShow::class)->name('users.show')->middleware(['auth']);
Route::get('/show-pdf/{id}', 'app\Livewire\Sale\SaleCreat@showPdf');

// Route::get('/clientes', ClientComponent::class)->name('clients')->middleware(['auth']);
// Route::get('/clientes/{client}', ClientShow::class)->name('clients.show')->middleware(['auth']);
// Route::get('/suscripcion', SuscribsComponent::class)->name('suscrib')->middleware(['auth']);
// Route::get('/suscripcion/{suscrib}', SuscribsShow::class)->name('suscrib.show')->middleware(['auth']);
// Route::get('/suscriptor', SuscripComponent::class)->name('suscrip')->middleware(['auth']);
Route::get('/ventas/crear', SaleCreat::class)->name('sales.create')->middleware(['auth']);
Route::get('/pos', Componente::class)->name('pos')->middleware(['auth']);
Route::get('/sales/{sale}', SaleShow::class)->name('sales.show')->middleware(['auth']);

Route::get('/reporte', Lista::class)->name('reporte')->middleware(['auth']);

Route::get('/sales/invoice/{sale}', [PdfController::class, 'invoice'])->name('sales.invoice')->middleware(['auth']);

Route::get('/inventario', InventarioComponent::class)->name('inventario')->middleware(['auth']);
Route::get('/ajuste', AjusteComponent::class)->name('ajuste')->middleware(['auth']);
Route::get('/movimiento', MovimientoComponent::class)->name('movimiento')->middleware(['auth']);
Route::get('/proveedor', ProvedorComponent::class)->name('proveedor')->middleware(['auth']);
Route::get('/proveedor/{proveedor}', ProvedorShow::class)->name('proveedor.show')->middleware(['auth']);
Route::get('/factura/{proveedor}', ProvedorFactura::class)->name('proveedor.factura')->middleware(['auth']);
Route::get('/reporteIn', ReporteComponent::class)->name('reporteIn')->middleware(['auth']);
Route::get('/kardex', KardexComponent::class)->name('kardex')->middleware(['auth']);
Route::get('sales/print/{sale}', [SaleCreat::class, 'print'])->name('sales.print')->middleware(['auth']);
Route::get('/cierre/salida', [CorteCaja::class, 'abreCierre'])->name('cierre.salida')->middleware(['auth']);
Route::post('/actualizar-tipo-pago/{venta}',[SaleCreat::class, 'actualizarTipoPago'])->name('ventas.actualizar_tipo_pago')->middleware(['auth']);
Route::get('/impresora', VerImpresora::class)->name('impresora')->middleware(['auth']);



Route::middleware('vendedor')->group(function () {
    // Aquí colocas las rutas que deseas restringir para los vendedores
    Route::get('/clientes', ClientComponent::class)->name('clients')->middleware(['auth']);
    Route::get('/clientes/{client}', ClientShow::class)->name('clients.show')->middleware(['auth']);
    Route::get('/categorias', CategoryComponent::class)->name('category')->middleware(['auth']);
    Route::get('/categorias/{category}', CategoryShow::class)->name('categories.show')->middleware(['auth']);
    Route::get('/enfermedad', EnfermedadComponent::class)->name('enfermedad')->middleware(['auth']);
    Route::get('/enfermedad/{category}', EnfermedadShow::class)->name('enfermedad.show')->middleware(['auth']);
    Route::get('principio', PrincipioComponent::class)->name('principio')->middleware(['auth']);
    Route::get('/principio/{category}', PrincipioShow::class)->name('principio.show')->middleware(['auth']);
    Route::get('/productos', ProductComponent::class)->name('products')->middleware(['auth']);
    Route::get('/cierre', ReporteCierre::class)->name('cierre')->middleware(['auth']);
    Route::get('/cierre/{cierre}', VerReporte::class)->name('cierre.show')->middleware(['auth']);
    Route::get('/datos', DatosTienda::class)->name('datos')->middleware(['auth']);

    
    Route::get('/usuarios', UserComponent::class)->name('users')->middleware(['auth']);
    Route::get('/sucursal', SucursalComponent::class)->name('sucursal')->middleware(['auth']);
    Route::get('/sucursal/{category}', SucursalShow::class)->name('sucursal.show')->middleware(['auth']);
    
    Route::get('/suscripcion', SuscribsComponent::class)->name('suscrib')->middleware(['auth']);
    Route::get('/suscripcion/{suscrib}', SuscribsShow::class)->name('suscrib.show')->middleware(['auth']);
    Route::get('/suscriptor', SuscripComponent::class)->name('suscrip')->middleware(['auth']);
});