<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    public function testGet()
    {
        $this->get('/pzn')
            ->assertStatus(200)
            ->assertSeeText('Hello Fikri Ahmad Fauzi');
    }

    public function testRedirect()
    {
        $this->get('/youtube')
            ->assertRedirect('/pzn');
    }

    public function testFallBack()
    {
        $this->get('/tidakada')
            ->assertSeeText('404 Not Found');
    }

    public function testRouteParams()
    {
        $this->get('/products/1')
            ->assertSeeText('Product 1');
        $this->get('/products/1/items/2')
            ->assertSeeText('Product 1 dan Item 2');
        $this->get('/products/2/items/YYY')
            ->assertSeeText('Product 2 dan Item YYY');
    }

    public function testRouteParamsRegex()
    {
        $this->get('/categories/112321')
            ->assertSeeText('Category : 112321');

        $this->get('/categories/as21sd')
            ->assertSeeText('404 Not Found');
    }

    public function testRouteParamsOptional()
    {
        $this->get('/users/121')
            ->assertSeeText('Users 121');

        $this->get('/users/')
            ->assertSeeText('Users 404');
    }

    public function testRouteParamsConflict()
    {
        $this->get('/conflict/budi')
            ->assertSeeText('Conflict budi');
        $this->get('conflict/fikri')
            ->assertSeeText('Conflict kedua');
    }

    public function testNamedRoute()
    {
        $this->get('/produk/1234')
            ->assertSeeText('Link http://localhost/products/1234');
        $this->get('/produk-redirect/1234')
            ->assertRedirect('/products/1234');
    }
}
