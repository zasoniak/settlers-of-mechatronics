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

Route::get('/', array('as' => 'home', function() {
		return View::make('hello');
}));

Route::post('login', function() {
		$login = array(
			'email' => Input::get('email'),
			'password' => Input::get('password')
		);

		if (Auth::attempt($login))
		{
			Auth::user()->touch();
			return Redirect::home();
		}

		return Redirect::home();
});

Route::get('logout', function() {
	Auth::logout();
	return Redirect::home();
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