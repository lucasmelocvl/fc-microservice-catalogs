<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

// Testar: List, Create, Update, Delete

class GenreTest extends TestCase
{
    use DatabaseMigrations;

    const mainClass = Genre::class;

    public function testList()
    {
        factory(Genre::class, 1)->create();
        $genre = Genre::all();
        $this->assertCount(1, $genre);

        $genreKeys = array_keys($genre->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at'
            ],
            $genreKeys
        );
    }

    public function testCreate()
    {
        $genre = Genre::create([
            'name' => 'testGenre'
        ]);
        $genre->refresh();
        $this->assertEquals('testGenre', $genre->name);
        $this->assertTrue($genre->is_active);

        $genre = Genre::create([
            'name' => 'testGenre',
            'is_active' => false,
        ]);
        $this->assertFalse($genre->is_active);

        $genre = Genre::create([
            'name' => 'testGenre',
            'is_active' => true,
        ]);
        $this->assertTrue($genre->is_active);
    }

    public function testUpdate()
    {
        $genre = factory(Genre::class)->create([
            'is_active' => false
        ])->first();

        $data = [
            'name' => 'testGenre',
            'is_active' => true
        ];

        $genre->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $genre->{$key});
        }
    }

    public function testDelete()
    {
        $genre = factory(Genre::class)->create();

        $id = $genre->id;
        $genre->delete();
        $nullGenre = Genre::find($id);

        $this->assertNull($nullGenre);
    }

    public function testIfUuidIsValid()
    {
        $genre = factory(Genre::class)->create();

        // UUID tem 32 dígitos + 4 hífens
        $this->assertEquals("36", strlen($genre->id));

        $uuidParts = explode('-', $genre->id);

        // UUID é separado em 5 partes
        $this->assertCount(5, $uuidParts);

        // As primeiras três partes são interpretadas como números hexadecimais completos
        $this->assertTrue(ctype_xdigit($uuidParts[0]));
        $this->assertTrue(ctype_xdigit($uuidParts[1]));
        $this->assertTrue(ctype_xdigit($uuidParts[2]));

        // As duas partes finais como uma sequência de bytes pura
        $this->assertTrue(ctype_alnum($uuidParts[3]));
        $this->assertTrue(ctype_alnum($uuidParts[4]));
    }
}
