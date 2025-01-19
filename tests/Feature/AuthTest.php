<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function test_register_user()
    {
        
        $user = [
            'name' => 'Anthony',
            'email' => 'tony@gmail.com',
            'password' => 'tony123'  
        ];

        $response = $this->postJson('api/register', $user);
        $response->assertCreated();

        $this->assertDatabaseHas('users', [
            'email' => 'tony@gmail.com',
            'name' => 'Anthony',
        ]);
    
    }

    public function test_login_user(){
        User::create([
            'name' => 'Anthony',
            'email' => 'tony@gmail.com',
            'password' => bcrypt('tony123')
        ]);
    
        $login = [
            'email' => 'tony@gmail.com',
            'password' => 'tony123'
        ];
    
        $response = $this->postJson('api/login', $login);    
        $response->assertOk();
    }

    
}
