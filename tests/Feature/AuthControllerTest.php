<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_registerUser(): void
    {
        $response = $this->post(route("register"), [
            "name" => "test",
            "email" => "test@test.com",
            "password" => "12345678",
            "password_confirmation" => "12345678"
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseCount("users", 1);
    }

    public function test_badRegisterUser(): void
    {
        $response = $this->post(route("register"), [
            "name" => "test",
            "email" => "test@test.com",
            "password" => "12345678"
        ]);

        $response->assertStatus(302)->assertRedirect("/");
        $this->assertDatabaseCount("users", 0);
    }

    public function test_registerApiUser(): void
    {
        $response = $this->post("/api/auth/register", [
            "name" => "test",
            "email" => "test@test.com",
            "password" => "12345678",
            "password_confirmation" => "12345678"
        ]);

        $response->assertStatus(201)->assertJsonFragment([
            "name" => "test",
            "email" => "test@test.com"
        ]);
        $this->assertDatabaseCount("users", 1);
    }

    public function test_badRegisterApiUser(): void
    {
        $response = $this->post("/api/auth/register", [
            "name" => "test",
            "email" => "test@test.com",
            "password" => "12345678",
        ]);

        $response->assertStatus(400);
        $this->assertDatabaseCount("users", 0);
    }

    public function test_loginUser(): void
    {
        $user = User::factory()->create([
            "email" => "test@test.com",
            "password" => "12345678"
        ]);
        $response = $this->post(route("login"), [
            "email" => $user->email,
            "password" => "12345678"
        ]);

        $response->assertStatus(302)->assertRedirect("/");
    }

    public function test_badLoginUser(): void
    {
        $user = User::factory()->create([
            "email" => "test@test.com",
            "password" => "12345678"
        ]);
        $response = $this->post(route("login"), [
            "email" => $user->email,
            "password" => "12345677"
        ]);

        $response->assertStatus(302)->assertRedirect("/");
    }

    public function test_loginApiUser(): void
    {
        $user = User::factory()->create([
            "email" => "test@test.com",
            "password" => "12345678"
        ]);
        $response = $this->post("/api/auth/login", [
            "email" => "test@test.com",
            "password" => "12345678",
        ]);
        $response->assertStatus(200)->assertJsonStructure(["access_token", "token_type", "expires_in"]);
    }

    public function test_badLoginApiUser(): void
    {
        $user = User::factory()->create([
            "email" => "test@test.com",
            "password" => "12345678"
        ]);
        $response = $this->post("/api/auth/login", [
            "email" => "test@test.com",
            "password" => "1234567",
        ]);
        $response->assertStatus(401)->assertJsonFragment(["error" => "Unauthorized"]);
    }

    public function test_getCurrentUser(): void
    {
        $credentials = [
            "email" => "test@test.com",
            "password" => "12345678"
        ];
        $user = User::factory()->create($credentials);
        $token = auth("api")->attempt($credentials);
        $response = $this->withHeaders(["Authentication" => "Bearer ".$token])->post(route("me"));

        $response->assertStatus(200)->assertJsonFragment([
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email
        ]);
    }

    public function test_refreshUser(): void
    {
        $credentials = [
            "email" => "test@test.com",
            "password" => "12345678"
        ];
        $user = User::factory()->create($credentials);
        $token = auth("api")->attempt($credentials);
        $response = $this->withHeaders(["Authentication" => "Bearer ".$token])->post(route("refresh"));

        $response->assertStatus(200)->assertJsonStructure(["access_token", "token_type", "expires_in"]);
    }

    public function test_logoutUser(): void
    {
        $credentials = [
            "email" => "test@test.com",
            "password" => "12345678"
        ];
        $user = User::factory()->create($credentials);
        $token = auth("api")->attempt($credentials);
        $response = $this->withHeaders(["Authentication" => "Bearer ".$token])->post(route("logout"));

        $response->assertStatus(302);
        $this->assertFalse(auth()->check());
    }

    public function test_logoutApiUser(): void
    {
        $credentials = [
            "email" => "test@test.com",
            "password" => "12345678"
        ];
        $user = User::factory()->create($credentials);
        $token = auth("api")->attempt($credentials);
        $response = $this->withHeaders(["Authentication" => "Bearer ".$token])->post("/api/auth/logout");

        $response->assertStatus(200)->assertJsonFragment(["message" => "Successfully logged out"]);
    }
}