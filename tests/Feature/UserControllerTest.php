<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')->assertSeeText("Login");
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" => "fazda"
        ])->get('/login')->assertRedirect('/');
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "fazda"
        ])->post("/login", [
            "user" => "fazda",
            "password" => "rahasia"
        ])->assertRedirect('/');
    }

    public function testLoginValidationError()
    {
        $this->post("/login", [])
            ->assertSeeText("Username or password are required");
    }

    public function testLoginFailed()
    {
        $this->post("/login", [
            "user" => "wrong",
            "password" => "wrong"
        ])->assertSeeText("Username or password wrong");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "fazda"
        ])->post('/logout')
            ->assertRedirect('/')
            ->assertSessionMissing('user');
    }
    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect('/');
    }
}