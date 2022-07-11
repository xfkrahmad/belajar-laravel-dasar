<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get('/input/hello?name=Fikri')
            ->assertSeeText('Hello Fikri');

        $this->post('/input/hello', [
            'name' => 'Fikri'
        ])->assertSeeText('Hello Fikri');
    }

    public function testInputNested()
    {
        $this->post('/input/hello/first', [
            'name' => [
                'first' => 'Fikri',
                'last' => 'Ahmad'
            ]
        ])->assertSeeText('Hello Fikri');
    }

    public function testInputAll()
    {
        $this->post('/input/hello/input', [
            'name' => [
                'first' => 'Fikri',
                'last' => 'Ahmad'
            ]
        ])->assertSeeText('name')
            ->assertSeeText('first')
            ->assertSeeText('last')
            ->assertSeeText('Fikri')
            ->assertSeeText('Ahmad');
    }

    public function testArrayInput()
    {
        $this->post('/input/hello/array', [
            'products' => [
                [
                    'name' => 'Galaxy S12',
                    'price' => '10000'
                ],
                [
                    'name' => 'Galaxy S15',
                    'price' => '15000'
                ],
                [
                    'name' => 'Galaxy S17',
                    'price' => '18000'
                ]
            ]
        ])->assertSeeText('Galaxy S12')
            ->assertSeeText('Galaxy S15')
            ->assertSeeText('Galaxy S17');
    }

    public function testInputType()
    {
        $this->post('/input/type', [
            'name' => 'Budi',
            'married' => 'true',
            'birth_date' => '1990-10-10'
        ])->assertSeeText('Budi')
            ->assertSeeText('true')
            ->assertSeeText('1990-10-10');
    }

    public function testFilterOnly()
    {
        $this->post('/input/filter/only', [
            'name' => [
                'first' => "Fikri",
                'middle' => "Ahmad",
                'last' => "Fauzi"
            ]
        ])->assertSeeText('Fikri')
            ->assertSeeText('Fauzi')
            ->assertDontSee('Ahmad');
    }

    public function testFilterExcept()
    {
        $this->post('/input/filter/except', [
            'username' => "Fikri",
            'password' => "rahasia",
            'admin' => "True"
        ])->assertSeeText('Fikri')
            ->assertSeeText('password')
            ->assertDontSeeText('admin');
    }

    public function testFilterMerge()
    {
        $this->post('/input/filter/merge', [
            'username' => "Fikri",
            'password' => "rahasia",
            'admin' => "True"
        ])->assertSeeText('Fikri')
            ->assertSeeText('password')
            ->assertSeeText('admin')
            ->assertSeeText('false');
    }
}
