<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        factory(Category::class, 1)->create();
        $categories = Category::all();
        $this->assertCount(1, $categories);

        $categoryKey = array_keys($categories->first()->getAttributes());
        $this->assertEqualsCanonicalizing([
                'id',
                'name',
                'description',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at'
            ],
            $categoryKey
        );
    }

    public function testCreate()
    {
        $category = Category::create([
           'name' => 'test1'
        ]);
        $category->refresh();
        $this->assertEquals('test1', $category->name);
        $this->assertNull($category->description);
        $this->assertTrue($category->is_active);

        $category = Category::create([
            'name' => 'test1',
            'description' => null
        ]);
        $this->assertNull($category->description);

        $category = Category::create([
            'name' => 'test1',
            'description' => 'test_description'
        ]);
        $this->assertEquals('test_description', $category->description);

        $category = Category::create([
            'name' => 'test1',
            'is_active' => false
        ]);
        $this->assertFalse($category->is_active);

        $category = Category::create([
            'name' => 'test1',
            'is_active' => true
        ]);
        $this->assertTrue($category->is_active);
    }

    public function testUpdate()
    {
        $category = factory(Category::class)->create([
            'description' => 'test_description',
            'is_active' => false
        ])->first();

        $data = [
            'name' => 'test1',
            'description' => 'test_description_updated',
            'is_active' => true
        ];

        $category->update($data);

        foreach($data as $key => $value) {
            $this->assertEquals($value, $category->{$key});
        }
    }

    public function testDelete()
    {
        $category = factory(Category::class)->create();

        $id = $category->id;
        $category->delete();
        $nullCategory = Category::find($id);

        $this->assertNull($nullCategory);
    }

    public function testIfUuidIsValid()
    {
        $genre = factory(Category::class)->create();

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
