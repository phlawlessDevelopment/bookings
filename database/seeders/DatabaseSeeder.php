<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Chalet;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => "test",
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $booking_data = [
            [
                'from_date' => Carbon::now()->addDays(0),
                'to_date' => Carbon::now()->addDays(7),
                'user_id' => 1,
            ],
            [
                'from_date' => Carbon::now()->addDays(0),
                'to_date' => Carbon::now()->addDays(7),
                'user_id' => 1,
            ],

        ];
        $chalets = Chalet::factory(count($booking_data))->create();

        for ($i = 0; $i < count($booking_data); $i++) {
            Booking::factory()->create($booking_data[$i])->chalets()->attach($chalets[$i]);
        }
    }
}
