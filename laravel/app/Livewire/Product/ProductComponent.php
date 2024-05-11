<?php

namespace App\Livewire\Product;

use App\Models\Enfermedad;
use App\Models\Principio;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;

#[Title('EasyVenta/Productos')]

class ProductComponent extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $search='';
    public $totalRegistros=0;
    public $cant=5;

    //modelo
    public $Id=0;
    public $SKU;
    public $name;
    public $category_id;
    public $enfermedad_id;
    public $principio_id;
    public $descripcion;
    public $precio_compra;
    public $precio_venta;
    public $precio_farmaPL;
    public $stock=1;
    public $stock_minimo=10;
    public $active=1;
    public $image;
    public $imageModel;
    public function render()
    {
        $this->totalRegistros = Product::count();

        $products =Product::where('name','like','%'.$this->search.'%')
                    ->orWhere('SKU','like','%'.$this->search.'%')
                    ->orderBy('id','desc')
                    ->paginate($this->cant);
        return view('livewire.product.product-component', [
            'products' => $products
        ]);
    }

    #[computed()]
    public function categories(){
        return Category::all();
    }

    #[computed()]
    public function enfermedad(){
        return Enfermedad::all();
    }

    #[computed()]
    public function principio(){
        return Principio::all();
    }

    
    public function create(){

        $this->Id=0;
        
        $this->clean(); 
        
        $this->dispatch('open-modal','modalProduct');
    }

    public function store(){
        //dump('Crear producto');
        $rules = [
            'name'=> 'required|min:5|max:255|unique:products',
            'descripcion' => 'max:255',
            'precio_compra'=> 'required|numeric',
            'precio_venta'=> 'required|numeric',
            'precio_farmaPL'=> 'required|numeric',
            'stock'=> 'required|numeric',
            'stock_minimo'=> 'numeric|nullable',
            'image'=> 'image|max:1024|nullable',
            'category_id'=> 'required|numeric',
        ];
        $this->validate($rules);
        $product = new Product();
        $customName = null;

        

        
        $product->SKU = $this->SKU;
        $product->name = $this->name;
        $product->category_id = $this->category_id;
        //$product->enfermedad_id = $this->enfermedad_id;
        //$product->principio_id = $this->principio_id;
        $product->descripcion = $this->descripcion;
        $product->precio_compra = $this->precio_compra;
        $product->precio_venta = $this->precio_venta;
        $product->precio_farmaPL = $this->precio_farmaPL;
        $product->stock = $this->stock;
        $product->stock_minimo = $this->stock_minimo;
        $product->active = $this->active;
        $product->save();

        if($this->image){
            $customName = 'products/'.uniqid().'.'.$this->image->extension();
            $this->image->storeAs('public',$customName);
            $product->image()->create(['url'=>$customName]);
        }

        $this->dispatch('close-modal','modalCategory');
        $this->dispatch('msg','Producto Creado con éxito');
        $this->clean();


        
    }

    public function edit(Product $product){
        $this->clean();
        $this->Id = $product->id;
        $this->SKU = $product->SKU;
        $this->name = $product->name;
        $this->descripcion = $product->descripcion;
        $this->precio_compra = $product->precio_compra;
        $this->precio_venta = $product->precio_venta;
        $this->precio_farmaPL = $product->precio_farmaPL;
        $this->stock = $product->stock;
        $this->stock_minimo = $product->stock_minimo;
        $this->imageModel = $product->imagen;
        $this->active = $product->active;
        $this->category_id = $product->category_id;


        $this->dispatch('open-modal','modalProduct');



        //dump($category);
    }

    public function update(Product $product){
        //dump($category);
        $rules = [
            'name'=> 'required|min:5|max:255|unique:products,id,'.$this->Id,
            'descripcion' => 'max:255',
            'precio_compra'=> 'required|numeric',
            'precio_venta'=> 'required|numeric',
            'precio_farmaPL'=> 'required|numeric',
            'stock'=> 'required|numeric',
            'stock_minimo'=> 'numeric|nullable',
            'image'=> 'image|max:1024|nullable',
            'category_id'=> 'required|numeric',
        ];

        $this->validate($rules);

        $product->SKU = $this->SKU;
        $product->name = $this->name;
        $product->descripcion = $this->descripcion;
        $product->precio_compra = $this->precio_compra;
        $product->precio_venta = $this->precio_venta;
        $product->precio_farmaPL = $this->precio_farmaPL;
        $product->stock = $this->stock;
        $product->stock_minimo = $this->stock_minimo;
        $product->active = $this->active;
        $product->category_id = $this->category_id;
        //$product->image = $this->imageModel;

        $product->update();  
        if($this->image){
            if($product->image!=null){
                Storage::delete('public/'. $product->image->url);
                $product->image()->delete();    
            }
            $customName = 'products/'.uniqid().'.'.$this->image->extension();
            $this->image->storeAs('public',$customName);
            $product->image()->create(['url'=>$customName]);
        }

        $this->dispatch('close-modal','modalProduct');
        $this->dispatch('msg','Producto Editado con éxito');

    
        $this->clean();
    }

    #[On('destroyProduct')]
    public function destroy($id){
        //dump($id);
        $product = Product::findOrfail($id);

        if($product->image!=null){
            Storage::delete('public/'. $product->image->url);
            $product->image()->delete();    
        }

        $product->delete();

        $this->dispatch('msg','El Producto se eliminó con éxito');
    }

    //Metodo encargado de limpiar los campos de los formularios
    public function clean(){

        $this->reset(['Id','name','image','SKU','category_id','descripcion','precio_compra','precio_venta','precio_farmaPL','stock','stock_minimo','active']);
        $this->resetErrorBag();
    }
}
