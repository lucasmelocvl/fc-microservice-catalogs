<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\TestCase;

// Testar: Traits, Fillable Attributes, Dates, KeyType, Cast, Incrementing

class GenreTest extends TestCase
{
    private $genre;

    public function setUp(): void
    {
        parent::setUp();
        $this->genre = new Genre();
    }

    public function testIfUseTraits()
    {
        $traits = [
            SoftDeletes::class,
            Uuid::class
        ];
        $genreTraits = array_keys(class_uses(Genre::class));
        $this->assertEquals($traits, $genreTraits);
    }

    public function testFillableAttributes()
    {
        $fillable = ['name', 'is_active'];
        $this->assertEquals($fillable, $this->genre->getFillable());
    }

    public function testDates()
    {
        $dates = [
            'created_at',
            'updated_at',
            'deleted_at'
        ];
        $genreDates = $this->genre->getDates();

        $this->assertEqualsCanonicalizing($dates, $genreDates);
        $this->assertCount(count($dates), $genreDates);
    }

    public function testKeyType()
    {
        $keyType = 'string';
        $this->assertEquals($keyType, $this->genre->getKeyType());
    }

    public function testCast()
    {
        $cast = [
            'id' => 'string',
            'is_active' => 'bool'
        ];
        $this->assertEquals($cast, $this->genre->getCasts());
    }

    public function testIncrementing()
    {
        $this->assertFalse($this->genre->incrementing);
    }
}
