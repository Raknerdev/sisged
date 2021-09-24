<?php

namespace Database\Seeders;

use App\Models\regiones\estados;
use Illuminate\Database\Seeder;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        estados::create(['nombre' => 'Amazonas']);
        estados::create(['nombre' => 'Anzoategui']);
        estados::create(['nombre' => 'Apure']);
        estados::create(['nombre' => 'Aragua']);
        estados::create(['nombre' => 'Barinas']);
        estados::create(['nombre' => 'Bolivar']);
        estados::create(['nombre' => 'Carabobo']);
        estados::create(['nombre' => 'Cojedes']);
        estados::create(['nombre' => 'Delta Amacuro']);
        estados::create(['nombre' => 'Distrito Capital']);
        estados::create(['nombre' => 'Falcon']);
        estados::create(['nombre' => 'Guarico']);
        estados::create(['nombre' => 'Lara']);
        estados::create(['nombre' => 'Merida']);
        estados::create(['nombre' => 'Miranda']);
        estados::create(['nombre' => 'Monagas']);
        estados::create(['nombre' => 'Margarita']);
        estados::create(['nombre' => 'Portuguesa']);
        estados::create(['nombre' => 'Sucre']);
        estados::create(['nombre' => 'Tachira']);
        estados::create(['nombre' => 'Trujillo']);
        estados::create(['nombre' => 'La Guaira']);
        estados::create(['nombre' => 'Yaracuy']);
        estados::create(['nombre' => 'Zulia']);
    }
}
