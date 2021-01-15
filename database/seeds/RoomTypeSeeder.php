<?php

use Illuminate\Database\Seeder;
use App\RoomType;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types_rooms = [
            ['basico', 80.00, 'habitacion basica'],
            ['estandar', 160.00, 'habitacion estandar'],
            ['premium', 240.00, 'habitacion premium']
        ];
        foreach ($types_rooms as $type) {
            RoomType::create([
                'titulo' => $type[0], 
                'price_day' => $type[1], 
                'description' => $type[2]
            ]);
        }
    }
}
