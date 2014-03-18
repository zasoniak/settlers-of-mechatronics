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

Route::get('board/{id}', function($id){
  $board = new CatanBoard(Board::find($id));
  return View::make('board')->with('board', $board);
});

/* game routes */

Route::when('game*', 'auth');

Route::get('game/create', function(){
  $game = CatanGame::generate(Auth::user());
  return Redirect::to('game/'.$game->model->id.'/join');
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
    return View::make('join')->with('players',$game->model->players);
  }
  return Response::make('Błąd',403);
});

Route::post('ajax/color', function() {
  $colors = Game::find(Input::get('game_id'))->players()->pluck('color');
  $color = Input::get('color');
  if(array_search($color, $colors))
  {
    return Response::make('Błąd',403);
  }
  $player = Player::findByGameByUser(Input::get('game_id'), Auth::user()->id);
  $player->color = $color;
  $player->save();
  return Response::make('OK', 200);
});

Route::get('game/{id}/start', function($id) {
  $game = new CatanGame(Game::find($id));
  if($game->model->players()->count() > 1)
  {
    $game->start();
    return Redirect::to("game/$id");
  }
  return Redirect::back()->with('message', 'Na pewno masz 4 graczy?');
});

Route::get('game/{id}/next', array('before'=>'turn', function($id) {
    $game = new CatanGame(Game::find($id));
    $game->endMove();
    $game->throwDice();
    return Redirect::to("game/$id");
}));


Route::post('game/{id}/build', array('before'=>'turn', function($id){
  if(Request::ajax())
  {
    $itemname = Input::get('item');
    $game = new CatanGame(Game::find($id));
    $itemlist = $itemname.'List';
    $item = $game->board->{$itemlist}[(int)Input::get('id')];
    if($game->buyItem($item))
    {
      return Response::make('OK!',200);
    }
    return Response::make('Za mało hajsiwa','403');
  }
  return Response::make('Zabronione nieajaxowe wywolanie','403');
}));

Route::get('game/{id}/update', function($id){
  if(Request::ajax())
  {
    $game = new CatanGame(Game::find($id));
    return Response::json($game->toJSON());
  }
  return Response::make('Zabronione nieajaxowe wywolanie','403');
});

/* pierdolnik */

Route::get('interface', function()
{
  return View::make('interface');
});

Route::get('generator', function()
{
  return View::make('generator');
});
