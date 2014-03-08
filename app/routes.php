<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
    return View::make('hello');
});

Route::get('game/{id}', function($id){
  $board = new CatanBoard(Board::find($id));
  return View::make('game')->with('board', $board);
});

Route::get('interface', function()
{
  return View::make('interface');
});

Route::get('generator', function()
{
  return View::make('generator');
});