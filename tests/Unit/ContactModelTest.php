<?php

namespace Tests\Unit;

use App\Models\Contact;
use Database\Seeders\ContactSeeder;
use Database\Seeders\PhoneSeeder;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ContactModelTest extends TestCase
{

    /**
     *
     * @return void
     */
    public function test_example()
    {
        $this->seed(ContactSeeder::class);
        $this->seed(PhoneSeeder::class);

        $this->assertDatabaseCount('contact', 1);
        $this->assertDatabaseCount('phone', 2);
        $this->assertDatabaseHas('phone', [
            'phone_number' => '552422222222',
        ]);
        $this->assertDatabaseHas('phone', [
            'phone_number' => '552422222223',
        ]);
    }
}
