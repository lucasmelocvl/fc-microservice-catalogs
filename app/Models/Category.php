<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    // Trait que adiciona um comportamento de deleção para realizar uma exclusão lógica, ao invés de física
    // Em toda a busca, que tiver data no deleted_at, não irá ser mostrada
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    protected $dates = ['deleted_at'];
}
