<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\Phone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Database\Seeders\ContactSeeder;
use Database\Seeders\PhoneSeeder;
use Tests\TestCase;

class ContactFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $contact_id = DB::table('contact')
            ->where('name', 'John Doe Feature')
            ->value('id');

        if ($contact_id)
            Phone::where('contact_id', $contact_id)->delete();

        Contact::where('name', 'John Doe Feature')->delete();
    }

    public function testUserRegistrationWithValidData()
    {
        $data = [
            'name' => 'John Doe Feature',
            'email' => 'johndoeFeatureTest@example.com',
            'birth' => '1990-01-01',
            'cpf' => '12345678912',
            "phone" => [
                [
                    "phone_number" => "552422555225"
                ], 
                [
                    "phone_number" => "552422277226"
                ]

            ]
        ];

        $this->post('/api/contact', $data);

        $this->assertDatabaseHas('contact', [
            'name' => 'John Doe Feature',
            'email' => 'johndoeFeatureTest@example.com',
            'birth' => '1990-01-01',
            'cpf' => '12345678912',

        ]);

        $this->assertDatabaseHas('phone', [
            "phone_number" => "552422555225"
        ]);

        $this->assertDatabaseHas('phone', [
            "phone_number" => "552422277226"
        ]);
    }

    public function testGetContact()
    {
 
        $this->seed(ContactSeeder::class);
        $this->seed(PhoneSeeder::class);
        $contact = Contact::first();

        $response = $this->get("/api/contact/{$contact->id}");
        $response->assertJson([[
            'name' => $contact->name,
            'email' => $contact->email,
            'birth' => $contact->birth,
            'cpf' => $contact->cpf
        ]]);
        $response->assertStatus(200);

        
    }
    

    public function testUserRegistrationWithMissingFields()
    {
        $data = [
            'name' => '',
            'email' => '',
            'birth' => '',
            'cpf' => '',

        ];

        $response = $this->post('/api/contact', $data);

        $response->assertStatus(500);
        $response->assertSee("Error: The given data was invalid.");
    }
}
