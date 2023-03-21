<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Phone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
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

        if($contact_id)
        Phone::where('contact_id', $contact_id)->delete();

        Contact::where('name', 'John Doe')->delete();

        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'birth' => '1990-01-01',
            'cpf' => '12345678900',
        ];

        DB::table('contact')->insert($data);
    }
}
