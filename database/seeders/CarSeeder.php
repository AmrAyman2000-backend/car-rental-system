<?php


namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run()
    {
        $cars = [
            [
                'name' => 'Toyota Corolla',
                'type' => 'Sedan',
                'price_per_day' => 50.00,
                'availability_status' => 'available',
                'image' => 'toyota_corolla.jpg',
            ],
            [
                'name' => 'Honda Civic',
                'type' => 'Sedan',
                'price_per_day' => 60.00,
                'availability_status' => 'available',
                'image' => 'honda_civic.jpg',
            ],
            [
                'name' => 'Ford Mustang',
                'type' => 'Coupe',
                'price_per_day' => 120.00,
                'availability_status' => 'unavailable',
                'image' => 'ford_mustang.jpg',
            ],
            [
                'name' => 'Chevrolet Malibu',
                'type' => 'Sedan',
                'price_per_day' => 70.00,
                'availability_status' => 'available',
                'image' => 'chevrolet_malibu.jpg',
            ],
            [
                'name' => 'Tesla Model 3',
                'type' => 'Electric',
                'price_per_day' => 150.00,
                'availability_status' => 'available',
                'image' => 'tesla_model_3.jpg',
            ],
            [
                'name' => 'BMW X5',
                'type' => 'SUV',
                'price_per_day' => 200.00,
                'availability_status' => 'unavailable',
                'image' => 'bmw_x5.jpg',
            ],
            [
                'name' => 'Audi A4',
                'type' => 'Sedan',
                'price_per_day' => 90.00,
                'availability_status' => 'available',
                'image' => 'audi_a4.jpg',
            ],
            [
                'name' => 'Mercedes C-Class',
                'type' => 'Sedan',
                'price_per_day' => 110.00,
                'availability_status' => 'available',
                'image' => 'mercedes_c_class.jpg',
            ],
            [
                'name' => 'Hyundai Elantra',
                'type' => 'Sedan',
                'price_per_day' => 55.00,
                'availability_status' => 'available',
                'image' => 'hyundai_elantra.jpg',
            ],
            [
                'name' => 'Jeep Wrangler',
                'type' => 'SUV',
                'price_per_day' => 130.00,
                'availability_status' => 'unavailable',
                'image' => 'jeep_wrangler.jpg',
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}

