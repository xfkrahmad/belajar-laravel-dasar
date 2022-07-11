<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testView()
    {
        $this->get('/hello')
            ->assertSeeText('Hello Fikri');

        $this->get('/hello-again')
            ->assertSeeText('Hello Fikri');
    }

    public function testNestedView()
    {
        $this->get('/hello-world')
            ->assertSeeText('World Fikri');
    }

    public function testViewWithoutRoute()
    {
        $this->view('hello', ['name' => 'Fikri'])
            ->assertSeeText('Hello Fikri');

        $this->view('hello.world', ['name' => 'Fikri'])
            ->assertSeeText('World Fikri');
    }
}
