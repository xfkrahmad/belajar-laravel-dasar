<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class URLGenerationTest extends TestCase
{
    public function testURLCurrent()
    {
        $this->get('/url/current?name=Fikri')
            ->assertSeeText('/url/current?name=Fikri');
    }

    public function testNamed()
    {
        $this->get('/redirect/named')
            ->assertSeeText('redirect/name/Fikri');
    }

    public function testAction()
    {
        $this->get('/url/action')
            ->assertSeeText('/form');
    }
}
