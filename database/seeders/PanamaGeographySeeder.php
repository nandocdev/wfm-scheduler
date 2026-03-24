<?php

namespace Database\Seeders;

use App\Modules\LocationModule\Models\District;
use App\Modules\LocationModule\Models\Province;
use App\Modules\LocationModule\Models\Township;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PanamaGeographySeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::transaction(function () {
            $this->seedProvinces();
            $this->seedDistricts();
            $this->seedTownships();
        });
    }

    private function seedProvinces(): void {
        $provinces = [
            ['name' => 'Panamá'],
            ['name' => 'Panamá Oeste'],
            ['name' => 'Colón'],
            ['name' => 'Chiriquí'],
            ['name' => 'Herrera'],
            ['name' => 'Los Santos'],
            ['name' => 'Veraguas'],
            ['name' => 'Coclé'],
            ['name' => 'Bocas del Toro'],
            ['name' => 'Darién'],
        ];

        foreach ($provinces as $province) {
            Province::create($province);
        }
    }

    private function seedDistricts(): void {
        $districts = [
            // Panamá
            ['province_name' => 'Panamá', 'name' => 'Panamá'],
            ['province_name' => 'Panamá', 'name' => 'San Miguelito'],
            ['province_name' => 'Panamá', 'name' => 'Chepo'],
            ['province_name' => 'Panamá', 'name' => 'Chimán'],

            // Panamá Oeste
            ['province_name' => 'Panamá Oeste', 'name' => 'Arraiján'],
            ['province_name' => 'Panamá Oeste', 'name' => 'Capira'],
            ['province_name' => 'Panamá Oeste', 'name' => 'Chame'],
            ['province_name' => 'Panamá Oeste', 'name' => 'San Carlos'],

            // Colón
            ['province_name' => 'Colón', 'name' => 'Colón'],
            ['province_name' => 'Colón', 'name' => 'Chagres'],
            ['province_name' => 'Colón', 'name' => 'Donoso'],
            ['province_name' => 'Colón', 'name' => 'Portobelo'],

            // Chiriquí
            ['province_name' => 'Chiriquí', 'name' => 'David'],
            ['province_name' => 'Chiriquí', 'name' => 'Bugaba'],
            ['province_name' => 'Chiriquí', 'name' => 'Barú'],
            ['province_name' => 'Chiriquí', 'name' => 'Boquete'],

            // Herrera
            ['province_name' => 'Herrera', 'name' => 'Chitré'],
            ['province_name' => 'Herrera', 'name' => 'Las Minas'],
            ['province_name' => 'Herrera', 'name' => 'Los Pozos'],
            ['province_name' => 'Herrera', 'name' => 'Ocú'],

            // Los Santos
            ['province_name' => 'Los Santos', 'name' => 'Las Tablas'],
            ['province_name' => 'Los Santos', 'name' => 'Los Santos'],
            ['province_name' => 'Los Santos', 'name' => 'Guararé'],
            ['province_name' => 'Los Santos', 'name' => 'Macaracas'],

            // Veraguas
            ['province_name' => 'Veraguas', 'name' => 'Santiago'],
            ['province_name' => 'Veraguas', 'name' => 'Atalaya'],
            ['province_name' => 'Veraguas', 'name' => 'San Francisco'],
            ['province_name' => 'Veraguas', 'name' => 'La Mesa'],

            // Coclé
            ['province_name' => 'Coclé', 'name' => 'Penonomé'],
            ['province_name' => 'Coclé', 'name' => 'Aguadulce'],
            ['province_name' => 'Coclé', 'name' => 'Natá'],
            ['province_name' => 'Coclé', 'name' => 'La Pintada'],

            // Bocas del Toro
            ['province_name' => 'Bocas del Toro', 'name' => 'Bocas del Toro'],
            ['province_name' => 'Bocas del Toro', 'name' => 'Changuinola'],
            ['province_name' => 'Bocas del Toro', 'name' => 'Almirante'],
            ['province_name' => 'Bocas del Toro', 'name' => 'Chiriquí Grande'],

            // Darién
            ['province_name' => 'Darién', 'name' => 'La Palma'],
            ['province_name' => 'Darién', 'name' => 'Chepigana'],
            ['province_name' => 'Darién', 'name' => 'Pinogana'],
            ['province_name' => 'Darién', 'name' => 'Yaviza'],
        ];

        foreach ($districts as $district) {
            $province = Province::where('name', $district['province_name'])->first();
            if ($province) {
                District::create([
                    'province_id' => $province->id,
                    'name' => $district['name'],
                ]);
            }
        }
    }

    private function seedTownships(): void {
        $townships = [
            // Panamá - Panamá
            ['district_name' => 'Panamá', 'province_name' => 'Panamá', 'name' => 'Bella Vista'],
            ['district_name' => 'Panamá', 'province_name' => 'Panamá', 'name' => 'San Francisco'],
            ['district_name' => 'Panamá', 'province_name' => 'Panamá', 'name' => 'Santa Ana'],
            ['district_name' => 'Panamá', 'province_name' => 'Panamá', 'name' => 'El Cangrejo'],
            ['district_name' => 'Panamá', 'province_name' => 'Panamá', 'name' => 'Calidonia'],
            ['district_name' => 'Panamá', 'province_name' => 'Panamá', 'name' => 'Curundú'],

            // Panamá - San Miguelito
            ['district_name' => 'San Miguelito', 'province_name' => 'Panamá', 'name' => 'Amelia Denis de Icaza'],
            ['district_name' => 'San Miguelito', 'province_name' => 'Panamá', 'name' => 'Belisario Porras'],
            ['district_name' => 'San Miguelito', 'province_name' => 'Panamá', 'name' => 'José Domingo Espinar'],
            ['district_name' => 'San Miguelito', 'province_name' => 'Panamá', 'name' => 'Mateo Iturralde'],

            // Colón - Colón
            ['district_name' => 'Colón', 'province_name' => 'Colón', 'name' => 'Cristóbal'],
            ['district_name' => 'Colón', 'province_name' => 'Colón', 'name' => 'Cativá'],
            ['district_name' => 'Colón', 'province_name' => 'Colón', 'name' => 'Sabanitas'],
            ['district_name' => 'Colón', 'province_name' => 'Colón', 'name' => 'Nueva Providencia'],

            // Chiriquí - David
            ['district_name' => 'David', 'province_name' => 'Chiriquí', 'name' => 'David'],
            ['district_name' => 'David', 'province_name' => 'Chiriquí', 'name' => 'Las Lomas'],
            ['district_name' => 'David', 'province_name' => 'Chiriquí', 'name' => 'Pedregal'],
            ['district_name' => 'David', 'province_name' => 'Chiriquí', 'name' => 'Los Algarrobos'],

            // Herrera - Chitré
            ['district_name' => 'Chitré', 'province_name' => 'Herrera', 'name' => 'Chitré'],
            ['district_name' => 'Chitré', 'province_name' => 'Herrera', 'name' => 'La Arena'],
            ['district_name' => 'Chitré', 'province_name' => 'Herrera', 'name' => 'Monagrillo'],
            ['district_name' => 'Chitré', 'province_name' => 'Herrera', 'name' => 'Llano Bonito'],

            // Los Santos - Las Tablas
            ['district_name' => 'Las Tablas', 'province_name' => 'Los Santos', 'name' => 'Las Tablas'],
            ['district_name' => 'Las Tablas', 'province_name' => 'Los Santos', 'name' => 'Bajo Corral'],
            ['district_name' => 'Las Tablas', 'province_name' => 'Los Santos', 'name' => 'Bayano'],
            ['district_name' => 'Las Tablas', 'province_name' => 'Los Santos', 'name' => 'El Carate'],

            // Veraguas - Santiago
            ['district_name' => 'Santiago', 'province_name' => 'Veraguas', 'name' => 'Santiago'],
            ['district_name' => 'Santiago', 'province_name' => 'Veraguas', 'name' => 'La Colorada'],
            ['district_name' => 'Santiago', 'province_name' => 'Veraguas', 'name' => 'La Peña'],
            ['district_name' => 'Santiago', 'province_name' => 'Veraguas', 'name' => 'La Raya'],

            // Coclé - Penonomé
            ['district_name' => 'Penonomé', 'province_name' => 'Coclé', 'name' => 'Penonomé'],
            ['district_name' => 'Penonomé', 'province_name' => 'Coclé', 'name' => 'Cañaveral'],
            ['district_name' => 'Penonomé', 'province_name' => 'Coclé', 'name' => 'Coclé del Norte'],
            ['district_name' => 'Penonomé', 'province_name' => 'Coclé', 'name' => 'Chiguirí Arriba'],

            // Bocas del Toro - Bocas del Toro
            ['district_name' => 'Bocas del Toro', 'province_name' => 'Bocas del Toro', 'name' => 'Bocas del Toro'],
            ['district_name' => 'Bocas del Toro', 'province_name' => 'Bocas del Toro', 'name' => 'Bastimentos'],
            ['district_name' => 'Bocas del Toro', 'province_name' => 'Bocas del Toro', 'name' => 'Cauchero'],
            ['district_name' => 'Bocas del Toro', 'province_name' => 'Bocas del Toro', 'name' => 'Punta Laurel'],

            // Darién - La Palma
            ['district_name' => 'La Palma', 'province_name' => 'Darién', 'name' => 'La Palma'],
            ['district_name' => 'La Palma', 'province_name' => 'Darién', 'name' => 'Camogantí'],
            ['district_name' => 'La Palma', 'province_name' => 'Darién', 'name' => 'Puerto Obaldía'],
            ['district_name' => 'La Palma', 'province_name' => 'Darién', 'name' => 'Tubualá'],
        ];

        foreach ($townships as $township) {
            $district = District::whereHas('province', function ($query) use ($township) {
                $query->where('name', $township['province_name']);
            })->where('name', $township['district_name'])->first();

            if ($district) {
                Township::create([
                    'district_id' => $district->id,
                    'name' => $township['name'],
                ]);
            }
        }
    }
}
