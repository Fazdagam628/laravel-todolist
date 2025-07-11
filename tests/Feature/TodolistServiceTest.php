<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todolistService;
    protected function setUp(): void
    {
        parent::setUp();

        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodo()
    {
        $this->todolistService->saveTodo("1", "fazda");

        $todolist = Session::get("todolist");
        foreach ($todolist as $value) {
            self::assertEquals("1", $value['id']);
            self::assertEquals("fazda", $value['todo']);
        }
    }

    public function testGetTodoListEmpty()
    {
        self::assertEquals([], $this->todolistService->getTodoList());
    }

    public function testGetTodolistNotEmpty()
    {
        $expected = [
            [
                "id" => "1",
                "todo" => "Fazda",
            ],
            [
                "id" => "2",
                "todo" => "Gam",
            ]
        ];

        $this->todolistService->saveTodo("1", "Fazda");
        $this->todolistService->saveTodo("2", "Gam");

        self::assertEquals($expected, $this->todolistService->getTodoList());
    }

    public function testRemoveTodo()
    {
        $this->todolistService->saveTodo("1", "Fazda");
        $this->todolistService->saveTodo("2", "Gam");

        self::assertEquals(2, sizeof($this->todolistService->getTodoList()));

        $this->todolistService->removeTodo("3");

        self::assertEquals(2, sizeof($this->todolistService->getTodoList()));

        $this->todolistService->removeTodo("1");

        self::assertEquals(1, sizeof($this->todolistService->getTodoList()));

        $this->todolistService->removeTodo("2");

        self::assertEquals(0, sizeof($this->todolistService->getTodoList()));
    }
}
