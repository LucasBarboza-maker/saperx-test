<?php

namespace Tests\Unit;

use App\Models\Contact;
use Tests\TestCase;

class UserModelTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        // Delete the user named John Doe from the database
        Contact::where('name', 'John Doe')->delete();
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'birth' => '1990-01-01',
            'cpf' => '123.456.789-00',
        ];

        $contact = Contact::create($data);

        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertDatabaseHas('contact', $data);
    }
}
