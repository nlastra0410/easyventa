<?php

namespace Database\Seeders;

use App\Models\shop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Eliminar carpeta

        Storage::deleteDirectory('public/shop');
        Storage::makeDirectory('public/shop');

        

        shop::factory(1)->create()->each(function(Shop $shop){
            $faker = Faker::create();
            $shop->image()->create(['url'=>'shop/'.$faker->image('public/storage/shop',640,480,'Shop',false)]);
        });
    }
}
