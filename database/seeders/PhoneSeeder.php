<?php

namespace Database\Seeders;

use App\Models\Phone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $contact_id = DB::table('contact')
            ->where('name', 'John Doe')
            ->value('id');

        Phone::where('contact_id', $contact_id)->delete();


        $phones = [
            [
                'phone_number' => '552422222222',
                'contact_id' => $contact_id,
            ],
            [
                'phone_number' => '552422222223',
                'contact_id' => $contact_id,
            ],
        ];

        DB::table('phone')->insert($phones);
    }
}
