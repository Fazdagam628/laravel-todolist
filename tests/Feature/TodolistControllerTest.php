<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            "user" => "fazda",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Gam",
                ],
                [
                    "id" => "2",
                    "todo" => "Jam",
                ],
            ]
        ])->get('/todolist')
            ->assertSeeText("1")
            ->assertSeeText("Gam")
            ->assertSeeText("2")
            ->assertSeeText("Jam");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "fazda"
        ])->post("/todolist", [])
            ->assertSeeText("Todo is required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "fazda"
        ])->post("/todolist", [
            "todo" => "Gam"
        ])->assertRedirect("/todolist");
    }

    public function testRemoveTodolist()
    {
        $this->withSession([
            "user" => "fazda",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Gam",
                ],
                [
                    "id" => "2",
                    "todo" => "Jam",
                ],
            ]
        ])->post("/todolist/1/delete")
            ->assertRedirect("/todolist");
    }
}
