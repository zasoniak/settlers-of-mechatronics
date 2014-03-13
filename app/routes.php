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
			return Redirect::home();
		}
		return Redirect::home()->with('message', 'Email lub hasło są niepoprawne');
});

Route::get('logout', function() {
	Auth::logout();
	return Redirect::home();
});

Route::get('signup', function() {
  return View::make('signup');
});

Route::post('signup', function() {
  $messages = array(
      'required' => 'Atrybut :attribute jest wymagany.',
      'min' => 'Atrybut :attribute musi mieć przynajmniej :min znaków',
      'between' => 'Atrybut :attribute musi być dłuższy niż :min i krótszy niż :max'
  );
  $rules = array(
      'nick' => array('required', 'between:3,20'),
      'email' => array('required', 'email'),
      'password' => array('required', 'confirmed', 'min:8')
  );
  $valid = Validator::make(Input::all(), $rules, $messages);
  if($valid->passes())
  {
    $user = new User;
    $user->email = Input::get('email');
    $user->password = Hash::make(Input::get('password'));
    $user->nickname = Input::get('nick');
    $user->save();
    return Redirect::home()->with('message', 'rejestracja zakończyła się sukcesem');
  }
  return Redirect::to('signup')->withErrors($valid);
});

Route::get('game/create', function(){
  $game = CatanGame::generate(Auth::user());
  return Redirect::to('game/'.$game->model->id);
});

Route::get('board/{id}', function($id){
  $board = new CatanBoard(Board::find($id));
  return View::make('board')->with('board', $board);
});

Route::get('game/{id}', function($id){
  $game = new CatanGame(Game::find($id));
  return View::make('game')->with('game',$game);
});

Route::get('game', function(){
  $games = Game::waiting();
  return View::make('gamelist')->with('games', $games);
});

Route::get('game/{id}/join', function($id) {
  $game = new CatanGame(Game::find($id));
  if($game->addPlayer(Auth::user()))
  {  
    return Redirect::to("game/$id");
  }
  return Redirect::home()->with('message', 'Coś poszło nie tak, sorry.');
});

Route::get('game/{id}/start', function($id) {
  $game = new CatanGame(Game::find($id));
  if($game->model->players()->count() > 1)
  {
    $game->start();
    return Redirect::to("game/$id");
  }
  return Redirect::back()->with('message', 'Coś spierdoliłeś!!! Na pewno masz 4 graczy?');
});

Route::get('interface', function()
{
  return View::make('interface');
});

Route::get('generator', function()
{
  return View::make('generator');
});


Route::get('game/{id}/next', function($id) {
    $game = new CatanGame(Game::find($id));
    $game->endMove();
    return Redirect::to("game/$id");
});
