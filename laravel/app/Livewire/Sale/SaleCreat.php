<?php

namespace App\Livewire\Sale;

use App\Models\ajuste;
use App\Models\Cart;
use App\Models\compras_cliente_producto;
use App\Models\corte_caja;
use App\Models\suscripciones;
use App\Models\Client;
use App\Models\Item;
use App\Models\Product;
use App\Models\Sale;
use App\Models\shop;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Client as Cliente;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;
use Request;
use TCPDF;

use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\UsbPrintConnector;

class SaleCreat extends Component
{
    use WithPagination;

    // #[Reactive]
    // public $total;

    public $opcionSeleccionada = 'efectivo';
    public $selectedProductId;
    public Product $product;
    public $stock;
    public $stockLabel;


    public $SKU;
    public $prueba;
    public $valores = [];

    public $search = '';
    public $cant = 100;
    public $totalRegistros = 0;
    public $selectedIndex;
    public $showModal = true;


    // Propiedades para el pago
    public $pago = 0.0;
    public $devuelve = 0;
    public $updating = 0;

    public $client = 1;

    // propiedades para el pago mixto 
    public $pagoEfectivo = 0;
    public $pagoTarjeta = 0;

    public $ventaCreada = false;
    public $ultimaVenta;
    public $ultimaVentaUsuario;

    protected $pdfPath;

    public $rut;
    public $precioExclusivo;
    public $cliente = '';
    public $nameClient;
    public $Id;
    public $name;
    public $telefono;
    public $email;
    public $password;
    public $re_password;
    public $monto;

    public $tipo_pago = '';
    public $searchTerm = '';
    public $detalle = '';
    public $numeroVentasUsuario;
    public $tieneCorteCajaAbierto;



    protected $listeners = ['show-pdf' => 'showPdf', 'refreshPage' => '$refresh', 'user-logged-out' => 'resetNumeroVentas','actualizarPrecio' => 'verificarSuscripcion'];

    // public function selectProduct($productId){
    //     $this->selectedProductId = $productId;
    //     $this->selectedIndex = $this->products->search(function ($product) use ($productId){
    //         return $product->id === $productId;
    //     });
    // }

    public function resetNumeroVentas()
    {
        $this->numeroVentasUsuario = 0;
    }

    protected function getListeners()
    {
        return [
            "decrementStock.{$this->product->id}" => "decrementStock",
            "incrementStock.{$this->product->id}" => "incrementStock",
            "refreshProducts" => "mount",
            "devolver.{$this->product->id}" => "devolver",
        ];
    }

    public function render()
    {
        $this->stockLabel = $this->stockLabel();

        $clients = Cliente::where('rut', 'like', '%' . $this->search . '%')
            ->orWhere('name', 'like', '%' . $this->search . '%')
            ->get();

        if ($this->search != '') {
            $this->resetPage();
        }

        $this->totalRegistros = Product::count();

        if ($this->updating == 0) {
            if ($this->tieneSuscripcion) {
                $this->pago = $this->calcularTotalConSuscripcion();
            } else {
                $this->pago = Cart::getTotal();
            }

            if ($this->tieneSuscripcion) {
                $this->devuelve = $this->pago - $this->calcularTotalConSuscripcion();
            } else {
                $this->devuelve = $this->pago - Cart::getTotal();
            }

        }

        // $this->ultimaVenta = Sale::latest()->first();

        $this->ultimaVentaUsuario = Sale::where('user_id', userID())->latest()->first();

        // Inicialmente, sin productos
        $products = new Collection; // Inicializa una nueva colección vacía

        if (!empty($this->searchTerm)) {
            $products = Product::where('name', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('sku', 'like', '%' . $this->searchTerm . '%')
                ->get();
        }




        return view('livewire.sale.sale-creat', [
            'products' => $products,
            'cart' => Cart::getCart(),
            'total' => Cart::getTotal(),
            'totalQy' => Cart::totalArticulos(),
            'ultimaVentaUsuario' => $this->ultimaVentaUsuario,
            'clients' => Cliente::all(),
            'cliente' => $clients,
        ]);
    }


    // Crear venta
    public function createSale()
    {
        $cart = Cart::getCart();

        if (count($cart) == 0) {
            $this->dispatch('scan-notfound', 'No hay productos registrados para realizar la venta');
            return;
            // dump(count($cart));
        } else {
            $this->dispatch('open-modal', 'modalPago');
        }

    }

    public function setEfectivo()
    {
        $this->tipo_pago = 'Efectivo';
    }

    public function setTransferencia()
    {
        $this->tipo_pago = 'Transferencia';
    }

    public function setTarjeta()
    {
        $this->tipo_pago = 'Tarjeta';
    }

    public function setMixto()
    {
        $this->tipo_pago = 'Mixto';
    }


    public function newCorte()
    {
        $usuario = auth::user();
        $corteCajaAbierto = $usuario->corteCajaActual();

        if (!$corteCajaAbierto) {
            $this->dispatch('open-modal', 'modalCaja');
        } else {
            $this->dispatch('scan-notfound', 'Ya hay un corte de caja abierto, no puede tener dos abiertos');
        }
    }

    public function createVenta()
    {

        // Verificar si ya se ha creado la venta
        if ($this->ventaCreada) {
            return;
        }

        $cart = Cart::getCart();

        if ($this->pago < Cart::getTotal()) {
            $this->pago = Cart::getTotal();
            $this->devuelve = 0;
        }

        if ($this->tieneSuscripcion) {
            $this->totalConSuscripcion = $this->calcularTotalConSuscripcion();
        }

        if ($this->tieneSuscripcion) {
            $this->precioSuscripcion = $this->precioSuscripcion();

        }

        $usuario = auth::user();
        $corteCajaAbierto = $usuario->corteCajaActual();

        if (!$corteCajaAbierto) {
            $this->dispatch('open-modal', 'modalCaja');
            $this->dispatch('close-modal', 'modalPago');


        } else {
            DB::transaction(function () {
                $sale = new Sale();

                $sale->total = Cart::getTotal();
                $sale->pago = $this->pago;
                $sale->user_id = userID();
                $sale->client_id = $this->client;
                $sale->fecha = date('Y-m-d');
                $sale->type = $this->tipo_pago;
                $sale->detalle = $this->detalle;
                $sale->save();

                // global $cart;
                foreach (\Cart::session(userID())->getContent() as $product) {
                    $item = new Item();
                    $item->name = $product->name;
                    $item->SKU = $product->associatedModel->SKU;
                    // Verificar el precio según la suscripción para cada producto
                    $item->price = $product->price;
                    $item->qty = $product->quantity;
                    $item->image = $product->associatedModel->imagen;
                    $item->product_id = $product->id;
                    $item->fecha = date('Y-m-d');
                    $item->save();

                    $sale->items()->attach($item->id, ['qty' => $product->quantity, 'fecha' => date('Y-m-d')]);

                    Product::find($product->id)->decrement('stock', $product->quantity);
                    $this->incrementarComprasClienteProducto($this->client, $product->id, $product->quantity);

                    $ajuste = new ajuste();
                    $ajuste->motivo = 'VENTA';
                    $ajuste->product_id = $product->id;
                    $ajuste->user_id = userID();
                    $ajuste->stockV = $product->associatedModel->stock;
                    $ajuste->stockA = $product->associatedModel->stock - $product->quantity;
                    $ajuste->type = 'Salida';
                    $ajuste->cantidad = $product->quantity;
                    $ajuste->save();

                }


                // Generar el PDF
                $pdf = $this->generarPDF($sale);

                // Enviar el PDF directamente a la impresora
                $this->imprimirPDF($pdf);

                // Guardar el PDF en la carpeta 'pdfs'
                // $pdfPath = public_path('pdfs/venta_' . $sale->id . '.pdf');
                // $pdf->save($pdfPath);

                Cart::clear();
                $this->reset(['pago', 'devuelve', 'client', 'rut']);
                $this->dispatch('close-modal', 'modalPago');
                $this->generarPDF($sale);
                $this->dispatch('msg', 'Venta realizada con exito');
                $this->ventaCreada = true;
                $this->dispatch('refreshPage');
                $this->reset(['detalle']);
                $this->tieneSuscripcion = false;
                $this->dispatch('ventaRealizada');
                $this->updateNumeroVentasUsuario();
                return redirect()->route('sales.create');
                // Devolver el path del PDF para mostrarlo al usuario
                // return redirect()->to('/show-pdf/' . $sale->id);


            });
        }



    }

    public function print(Sale $sale)
    {
        try {
            // Conectar con la impresora (reemplaza "/dev/usb/lp0" con el dispositivo USB correcto)
            $connector = new FilePrintConnector("POS-80");

            // Crear un objeto Printer
            $printer = new Printer($connector);

            // Imprimir un texto de prueba
            $printer->text("Este es un texto de prueba para la impresora.");

            // Cortar el papel
            $printer->cut();

            // Cerrar la conexión con la impresora
            $printer->close();
            return "Impresión exitosa.";

        } catch (\Exception $e) {
            return "Error al imprimir: " . $e->getMessage();
        } finally {
            // Hacer el redireccionamiento después de 3 segundos
            echo '<script>';
            echo 'setTimeout(function() { window.location.href = "' . route('sales.create') . '"; },  600);'; // Cambia "nombre.de.tu.ruta" por la ruta correcta
            echo '</script>';
        }
    }

    public function registro()
    {
        //dump('Crear Categoria');
        $rules = [
            'monto' => 'required|numeric|min:0'
        ];

        $messages = [
            'monto.required' => 'Debe de ingresar el monto inicial',
            'monto.numeric' => 'El monto inicial debe de ser un número',
            'monto.min' => 'El monto inicial debe de ser mayor o igual a cero'
        ];
        $this->validate($rules, $messages);



        $corteCaja = new corte_caja();
        $corteCaja->user_id = userID();
        $corteCaja->monto_inicial = $this->monto;
        $corteCaja->fecha_apertura = Carbon::now();
        $corteCaja->save();

        $this->dispatch('close-modal', 'modalCaja');
        $this->dispatch('msg', 'Se inicio el corte de caja, continue con la venta');


        $this->reset(['monto']);


    }

    public function incrementarComprasClienteProducto($clienteId, $productoId, $cantidad)
    {

        // Buscar el registro en la tabla
        $compraClienteProducto = compras_cliente_producto::where('cliente_id', $clienteId)
            ->where('producto_id', $productoId)
            ->first();

        // Si no hay registro, se crea uno nuevo
        if (!$compraClienteProducto) {
            $compraClienteProducto = new compras_cliente_producto();
            $compraClienteProducto->cliente_id = $clienteId;
            $compraClienteProducto->producto_id = $productoId;
            $compraClienteProducto->cantidad_comprada = $cantidad;
        } else {
            // si hay un registro, se incrementa la cantidad comprada
            $compraClienteProducto->cantidad_comprada += $cantidad;
        }

        // Se guardan los cambios en la base de dato
        $compraClienteProducto->save();
    }



    public function showPdf($id)
    {
        $pdfPath = public_path('pdfs/venta_' . $id . '.pdf');
        // Verificar si el PDF existe
        if (!file_exists($pdfPath)) {
            abort(404);
        }

        // Devolver el PDF al navegador
        return Response::file($pdfPath, ['Content-Type' => 'application/pdf']);
    }

    private function updateNumeroVentasUsuario()
    {
        $this->numeroVentasUsuario = Sale::where('user_id', userID())->count();
    }

    private function calcularTotalConSuscripcion()
    {
        $totalConSuscripcion = 0;

        foreach (\Cart::session(userID())->getContent() as $product) {
            // Obtener el precio de suscripción del producto y convertirlo a tipo numérico
            $precioSuscripcion = floatval($product->associatedModel->precio_farmaPL);

            // Sumar al total con suscripción
            $totalConSuscripcion += $precioSuscripcion * $product->quantity;
        }

        return $totalConSuscripcion;
    }


    private function precioSuscripcion()
    {
        $precioSuscripcion = 0;

        foreach (\Cart::session(userID())->getContent() as $product) {
            // Obtener el precio de suscripción del producto
            $precioSuscripcion = $product->associatedModel->precio_farmaPL;
        }

        return $precioSuscripcion;
    }

    private function imprimirTexto($texto)
    {
        // Escapar el texto para evitar problemas de seguridad
        $textoEscapado = escapeshellarg($texto);

        // Enviar el texto a la impresora
        exec("echo $textoEscapado | lp");

        return "Impresión exitosa.";
    }


    public function generarPDF(Sale $sale)
    {
        // Crear un nuevo objeto TCPDF
        $pdf = new Tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Establecer información del documento
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Venta #' . $sale->id);
        $pdf->SetSubject('Ticket de Venta');
        $pdf->SetKeywords('Venta, Ticket, PDF');

        // Agregar una página
        $pdf->AddPage();

        // Establecer fuente y color de texto
        $pdf->SetFont('helvetica', '', 30);
        $pdf->SetTextColor(0, 0, 0); // Negro

        // Logo de la empresa
        $pdf->Image('../../dist/img/tienda.jpeg', 10, 10, 40);

        // Nombre de la empresa
        $pdf->SetFont('helvetica', 'B', 40);
        $pdf->Cell(0, 10, 'EasyFarma', 0, 1, 'C');

        // Eslogan de la empresa
        $pdf->SetFont('helvetica', 'I', 25);
        $pdf->Cell(0, 10, 'Tu salud nos mueve', 0, 1, 'C');

        // Línea divisoria
        $pdf->SetDrawColor(0, 0, 0); // Negro
        $pdf->SetLineWidth(0.5);
        $pdf->Line(10, $pdf->GetY() + 5, 200, $pdf->GetY() + 5); // Línea horizontal

        // Fecha de la venta
        $pdf->SetFont('helvetica', 'B', 30);
        $pdf->Cell(0, 10, 'Fecha de Venta: ' . $sale->created_at, 0, 1);

        // Cajero
        $pdf->SetFont('helvetica', '', 30);
        $pdf->Cell(0, 10, 'Cajero: ' . $sale->user->name, 0, 1);

        // Detalles de los productos
        $pdf->SetFont('helvetica', 'B', 30);
        $pdf->Cell(0, 10, 'Detalles de la Venta', 0, 1);

        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetFillColor(240, 240, 240); // Color de fondo gris claro

        // Cabecera de la tabla
        $pdf->Cell(30, 10, 'ID Producto', 1, 0, 'C', 1);
        $pdf->Cell(80, 10, 'Nombre', 1, 0, 'C', 1);
        $pdf->Cell(30, 10, 'Precio', 1, 0, 'C', 1);
        $pdf->Cell(20, 10, 'Cantidad', 1, 0, 'C', 1);
        $pdf->Cell(30, 10, 'Subtotal', 1, 1, 'C', 1);

        // Contenido de la tabla (detalles de los productos)
        foreach ($sale->items as $item) {
            $pdf->Cell(30, 10, $item->id, 1, 0, 'C');
            $pdf->Cell(80, 10, $item->name, 1, 0, 'C');
            $pdf->Cell(30, 10, money($item->price), 1, 0, 'C');
            $pdf->Cell(20, 10, $item->qty, 1, 0, 'C');
            $pdf->Cell(30, 10, money($item->price * $item->qty), 1, 1, 'C');
        }

        // Total
        $pdf->SetFont('helvetica', 'B', 30);
        $pdf->Cell(160, 10, 'Total', 1, 0, 'R');
        $pdf->Cell(30, 10, money($sale->total), 1, 1, 'C');

        // Firma del cajero
        $pdf->Cell(0, 10, '___________________________', 0, 1, 'R');
        $pdf->Cell(0, 10, 'Firma del Cajero', 0, 1, 'R');

        // Agradecimiento
        $pdf->SetFont('helvetica', 'I', 30);
        $pdf->Cell(0, 10, '¡Gracias por su compra!', 0, 1, 'C');

        return $pdf;
    }


    private function imprimirPDF($pdf)
    {
        // Obtener el contenido del PDF
        $pdfContent = $pdf->Output('', 'S');

        // Guardar el contenido del PDF en un archivo temporal
        $tempFile = tempnam(sys_get_temp_dir(), 'pdf');
        file_put_contents($tempFile, $pdfContent);

        // Enviar el archivo temporal a la impresora
        exec("lp $tempFile");

        // Eliminar el archivo temporal después de imprimir
        unlink($tempFile);
    }


    public function mount()
    {

        $this->product = new Product();
        $this->stock = $this->product->stock;
        $this->valores = [
            1000,
            2000,
            5000,
            10000,
            20000,
            30000,
            40000,
            50000,
            100000
        ];

        $this->total = 0;

        $this->ventaCreada = false;

        // $this->ultimaVenta = Sale::latest()->first();
        $this->updateNumeroVentasUsuario();

        $this->usuario = auth::user();
    }

    public function tieneCorteCajaAbierto()
    {
        return $this->usuario->corteCajaActual() !== null;
    }

    public function updatingPago($value)
    {
        $this->updating = 1;
        $this->pago = $value;
        $this->devuelve = (int) $this->pago - Cart::getTotal();
        $this->actualizarDevuelve();
    }

    #[On('add-product')]
    public function addProduct(Product $product)
    {
        $this->updating = 0;
        // dump($product);

        if ($product->stock > 0) {
            Cart::add($product);
            $this->dispatch('close-modal', 'modalProducto');
            $this->searchTerm = '';
        } else {
            $this->dispatch('no-stock', 'La cantidad del producto no es suficiente');
            $this->dispatch('close-modal', 'modalProducto');
            $this->searchTerm = '';
        }

    }

    // Disminuir cantidad
    public function dismin($id)
    {
        $this->updating = 0;
        Cart::dismin($id);
        $this->dispatch("incrementStock.{$id}");
    }

    // Aumentar cantidad
    public function aumentar($id)
    {
        $this->updating = 0;
        Cart::aumentar($id);
        $this->dispatch("decrementStock.{$id}");
    }

    // Eliminar item del carrito
    public function remove($id, $qty)
    {
        $this->updating = 0;
        Cart::remove($id);
        $this->dispatch("devolver.{$id}", $qty);
    }

    // Cancelar venta
    public function clear()
    {
        Cart::clear();
        $this->pago = 0;
        $this->devuelve = 0;
        $this->dispatch('msg', 'Venta cancelada');
        $this->dispatch('refreshProducts');

    }

    #[On('client_id')]
    public function client_id($id = 1)
    {
        $this->client = $id;
    }



    #[Computed()]
    public function products()
    {
        return Product::where('name', 'like', '%' . $this->search . '%')
            ->orwhere('SKU', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->cant);
    }


    public function actualizarDevuelve()
    {
        // Convertir $this->pago a float
        $pagoFloat = (float) $this->pago;

        // Calcula el monto de devuelve en tiempo real
        $this->devuelve = max(0, $pagoFloat - Cart::getTotal());
    }





    public function setePago($valor)
    {
        $this->updating = 1;
        $this->pago = $valor;
        $this->devuelve = $this->pago - Cart::getTotal();

    }

    public function isProductInCart($productId)
    {
        $this->updating = 0;
        $product = Cart::getCart()->where('id', $productId)->first();
        return $product !== null;
    }



    public function ScanCode()
    {
        // dd(bin2hex($SKU));
        $SKU = $this->SKU;
        $product = Product::where('SKU', $SKU)->first();

        if (!$product) {
            $this->dispatch('scan-notfound', 'El producto no existe');
            $this->reset(['SKU']);
            $this->SKU = '';
            return;
        }

        if ($this->isProductInCart($product->id)) {
            $carItem = Cart::getCart()->where('id', $product->id)->first();
            if (($carItem->quantity + 1) > $product->stock) {
                $this->dispatch('no-stock', 'La cantidad del producto no es suficiente');
                $this->reset(['SKU']);
                $this->SKU = '';
                return;
            }

            $this->aumentar($product->id);
            $this->total = Cart::getTotal();
            $this->dispatch('msg', 'Producto agregado');
            $this->reset(['SKU']);
            $this->SKU = '';
        } else {
            if ($product->stock < 1) {
                $this->dispatch('no-stock', 'La cantidad del producto no es suficiente');
                $this->reset(['SKU']);
                $this->SKU = '';
                return;
            }


            Cart::add($product);
            $this->total = Cart::getTotal();
            $this->reset(['SKU']);
            $this->dispatch('msg', 'Producto agregado');
        }


    }

    public function decrementStock()
    {
        $this->stock--;
    }

    public function incrementStock()
    {

        if ($this->stock == $this->product->stock - 1) {
            return;
        }

        $this->stock++;
    }

    public function devolver($qty)
    {

        $this->stock = $this->stock + $qty;
    }
    public function stockLabel()
    {
        if ($this->stock <= $this->product->stock_minimo) {
            return '<span class="badge badge-pill badge-danger">' . $this->stock . '</span>';
        } else {
            return '<span class="badge badge-pill badge-success">' . $this->stock . '</span>';
        }
    }

    public function calcularRestante()
    {
        return $this->total - ($this->pagoEfectivo + $this->pagoTarjeta);
    }

    // Agrega estos nuevos métodos a tu componente Livewire
    public function setePagoEfectivo($valor)
    {
        $this->pagoEfectivo = $valor;
        $this->actualizarRestante();
    }

    public function setePagoTarjeta($valor)
    {
        $this->pagoTarjeta = $valor;
        $this->actualizarRestante();
    }

    public function actualizarRestante()
    {
        $this->restante = $this->total - ($this->pagoEfectivo + $this->pagoTarjeta);
    }

    public function aumentarOdisminuirCantidad($productId, $action)
    {
        $product = Product::find($productId);

        if (!$product) {
            return;
        }

        if ($action === 'aumentar') {
            $this->aumentar($product->id);
        } elseif ($action === 'disminuir') {
            $this->dismin($product->id);
        }
    }

    // Verificar la suscripción y cambiar los precios 

    public $tieneSuscripcion;
    public $mensaje;

    public function nameClient($id = null)
    {
        $findClient = Cliente::find($this->idCliente);
        // Se verifica si se encontró un cliente

        if ($findClient) {
            $this->nameClient = $findClient->name;
        } else {
            $this->nameClient = 'Cliente no encontrado';
        }
    }

    public function store()
    {
        //dump('Crear Categoria');
        $rules = [
            'name' => 'required|min:5|max:255',
            'rut' => 'required|min:8|max:9|unique:clients',
            'telefono' => 'min:9|numeric',
            're_password' => 'same:password',
        ];
        $this->validate($rules);



        $clientes = new Cliente();
        $clientes->name = $this->name;
        $clientes->rut = $this->rut;
        $clientes->telefono = $this->telefono;
        $clientes->email = $this->email;
        $clientes->password = $this->password;

        $clientes->save();

        $this->dispatch('close-modal', 'modalClient');
        $this->dispatch('msg', 'Cliente añadido con éxito');

        $this->dispatch('client_id', $clientes->id);

        $this->clean();


    }

    public function BuscaRut($rut)
    {
        $client = Cliente::where('rut', $rut);

        if ($client == null) {
            $this->dispatch('scan-notfound', 'El cliente no se encontró');
            return;
        } else {
            $this->dispatch('close-modal', 'modalRut');
            $this->dispatch('msg', 'Cliente ingresado');
        }

        $this->showModal = false; // Cierra el modal
    }


    public function openModal()
    {
        $this->dispatch('open-modal', 'modalClient');
    }

    public function clean()
    {

        $this->reset(['Id', 'name', 'rut', 'telefono', 'email', 'password']);
        $this->resetErrorBag();
    }

    public $detallesSuscripcion = [];
    public $nameCliente;
    public $idCliente;
    
    public function verificarSuscripcion()
    {
        // dd($this->rut);
        $cliente = Cliente::where('rut', $this->rut)->first();
        $suscripcion = suscripciones::where('rut_cliente', $this->rut)->first();
        $totalConSuscripcion = 0;
        $this->tieneSuscripcion = true;

        // verificación de la suscripción
        if ($suscripcion && $cliente) {
            // Verificar si el cliente tiene una suscripción activa
            $fechaInicio = Carbon::parse($suscripcion->created_at);
            $fechaFin = $fechaInicio->copy()->addMonths($suscripcion->duracion);
            $hoy = Carbon::now();
            $this->nameCliente = $cliente->name;
            $this->client = $cliente->id;

            if ($hoy->between($fechaInicio, $fechaFin)) {
                // Cliente dentro del rango de suscripción
                $this->tieneSuscripcion = true;
                $this->dispatch('msg', 'El cliente tiene una suscripción de ' . $suscripcion->plan . ' por ' . $suscripcion->duracion . ' meses.');
                // Otros detalles de suscripción
                $this->detallesSuscripcion = [
                    'plan' => $suscripcion->plan,
                    'duracion' => $suscripcion->duracion,
                ];
            } else {
                // Cliente fuera del rango de suscripción
                $this->tieneSuscripcion = false;
                $this->dispatch('no-stock', 'La suscripcion ' . $suscripcion->plan . ' por ' . $suscripcion->duracion . ' meses del cliente ha expirado. Indicar que debe de renovar por favor.');
            }
        } else {
            $this->tieneSuscripcion = false;
            $this->dispatch('scan-notfound', 'El cliente no tiene suscripción.');
            $this->nameCliente = 'Generico';
            $this->idCliente = 1;
        }


        $this->actualizarPrecios();
    }

    private function actualizarPrecios()
    {
        // Obtener los productos
        $suscripcion = suscripciones::where('rut_cliente', $this->rut)->first();

        $productos_en_carrito = \Cart::session(userID())->getContent();
        // Verificar si el cliente ha alcanzado el límite de compra mensual para cada producto
        foreach ($productos_en_carrito as $product) {
            // Obtener el historial de compras del cliente para este producto en el mes actual
            $comprasMensuales = compras_cliente_producto::where('cliente_id', $this->client)
                ->where('producto_id', $product->id)
                ->sum('cantidad_comprada');

            // Aplicar el precio adecuado según la suscripción y el límite de compra mensual
            if ($this->tieneSuscripcion && $comprasMensuales <= 2) {
                $product->price = $product->associatedModel->precio_farmaPL;
            } else {
                $product->price = $product->associatedModel->precio_venta;
                if($this->tieneSuscripcion === false){
                    $this->dispatch('scan-notfound', 'La suscripcion no está disponible');
                }else{
                    $this->dispatch('no-stock', 'El cliente superó la cantidad de compras por mes para algunos productos');
                }
            }

        }
    }


    public function actualizarTipoPago(Sale $venta, Request $request){
        $nuevoTipoPago = $request->tipo_pago;

        $venta->update([
            'type' => $nuevoTipoPago
        ]);

        return response()->json(['message' => 'Tipo de pago actualizado correctamente']);
    }




}




