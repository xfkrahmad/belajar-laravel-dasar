<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{

    public function testPutSession()
    {
        $this->get('/session/create')
            ->assertSeeText('OK')
            ->assertSessionHas('userId', 'Fikri')
            ->assertSessionHas('isMember', true);
    }

    public function testGetSession()
    {
        $this->withSession([
            'userId' => 'Fikri',
            'isMember' => 'true'
        ])->get('/session/get')
            ->assertSeeText('User Id : Fikri, is Member : true');

        $this->get('/session/get')
            ->assertSeeText('User Id : Fikri, is Member : true');
    }
}
