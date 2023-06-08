<?php

use App\Models\Recipe;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\IngredientController;
use TCG\Voyager\Facades\Voyager;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //If user is logged in, redirect to their Freego
    if (auth()->check()) {
        return redirect()->route('ingredients.search');
        //Show generic welcome message to guests
    } else {
        return view('welcome');
    }
});

//get all recipes

Route::get('/recipes', function () {
    return view('recipes', [
        'recipes' => Recipe::all()
    ]);
})->middleware('auth');

//single recipe
Route::get('/recipe/{id}', function ($id) {
    $recipe = Recipe::find($id);
    return view('recipe', compact('recipe'));
});

//add ingredients to recipe
Route::get('/recipes/{id}', [RecipeController::class, 'show'])->name('recipes.show');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});


// GET all ingredients
// Route::get('/products', [IngredientController::class, 'index'])->middleware('auth');

//Search ingredients
Route::get('/ingredients', [IngredientController::class, 'search'])->name('ingredients.search')->middleware('auth');

Route::post('/ingredients/{ingredient}/add-to-selected', [IngredientController::class, 'addToSelected'])->name('ingredients.addToSelected');


//Add to shopping list
Route::get('/ingredient/{id}/fridgelist', [IngredientController::class, 'moveToFridgelist'])->name('ingredient.moveToFridgeList');

// //Delete ingredients
Route::delete('/ingredient/{id}/delete', [IngredientController::class, 'delete'])->name('ingredient.delete');





// // GET ingredient by name
// Route::get('/products/{name}', function ($name) {
//     $ingredient = Ingredient::where('name', $name)->get();
//     return $ingredient;
// });

//Show register form
Route::get('/register', [UserController::class, 'create']);

//Create New User
Route::post('/users', [UserController::class, 'store']);


//Logout
Route::post('/logout', [UserController::class, 'logout']);

//Show Login Form
Route::get('/login', [UserController::class, 'login'])->name('login');

//Log In User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);