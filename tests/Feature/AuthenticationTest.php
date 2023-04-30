<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthenticationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    //we need use RefreshDatabase; so the database would be re-migrated fresh before each test. Just don't forget to change to the testing database beforehand!

    public function testUserCanLoginWithCorrectCredentials()
    {
        //Arrange (prepare): we create a fake user
        $user = User::factory()->create();

        //Act (do something): we try to log in
        $response = $this->postJson('/api/v1/auth/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        //Assert (check if the result is as expected): we check the status code of the result
        $response->assertStatus(201);
    }

    public function testUserCannotLoginWithIncorrectCredentials()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/v1/auth/login', [
            'email'    => $user->email,
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(422);
    }

    /*
    1-  we have TWO tests for the same login endpoint, and that's pretty important. You need to test not only the success scenario but also that the incorrect or invalid request actually fails with the correct errors
    */


    public function testUserCanRegisterWithCorrectCredentials()
{
    $response = $this->postJson('/api/v1/auth/register', [
        'name'                  => 'ahmed updated',
        'email'                 => 'ahmed97@yahoo.com',
        'password'              => '12345678',
        'password_confirmation' => '12345678',
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'access_token',
        ]);

    $this->assertDatabaseHas('users', [
        'name'  => 'ahmed updated',
        'email' => 'ahmed97@yahoo.com',
    ]);
}

public function testUserCannotRegisterWithIncorrectCredentials()
{
    $response = $this->postJson('/api/v1/auth/register', [
        'name'                  => 'ahmed updated',
        'email'                 => 'ahmed97@yahoo.com',
        'password'              => 'password',
        'password_confirmation' => 'wrong_password',
    ]);

    $response->assertStatus(422);

    $this->assertDatabaseMissing('users', [
        'name'      => 'ahmed updated',
        'email'      => 'ahmed97@yahoo.com',
    ]);
}
}
