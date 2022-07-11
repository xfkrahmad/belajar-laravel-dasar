<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class FileStorageTest extends TestCase
{
    public function testStorage()
    {
        $filesystem = Storage::disk('local');
        $filesystem->put('file.txt', 'Fikri Ahmad Fauzi');

        $content = $filesystem->get('file.txt');

        assertEquals('Fikri Ahmad Fauzi', $content);
    }
    public function testPublicStorage()
    {
        $filesystem = Storage::disk('public');
        $filesystem->put('file.txt', 'Fikri Ahmad Fauzi');

        $content = $filesystem->get('file.txt');

        assertEquals('Fikri Ahmad Fauzi', $content);
    }
}
