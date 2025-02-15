<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    protected $table = 'recipes';

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_recipe', 'recipe_id', 'ingredient_id');
    }
}
