<?php

namespace Tests\Feature\Modles;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample1()
    {
        Category::creating([
            'name' => 'test1'
        ]);
    }

    public function testExample2()
    {
        dd(Category::all());
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
