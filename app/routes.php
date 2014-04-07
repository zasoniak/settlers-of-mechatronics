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
Route::when('*ajax*', 'ajax');

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
  $player = Player::findByGameByUser($id, Auth::user()->id);
  if(!is_null($player))
  {
    return Redirect::to("game/$id/waitroom");
  }
  if($game->addPlayer(Auth::user()))
  {
    return Redirect::to("game/$id/waitroom");
  }
  return Redirect::home()->with('message','Układ planet nie pozwala Ci grać.');
});

Route::get('game/{id}/waitroom', function($id) {
  $game = new CatanGame(Game::find($id));
  $playersByColor = array();
  foreach ($game->model->players as $player)
  {
    $playersByColor[$player->color] = $player;
  }
  return View::make('join')->with('game', $game)->with('players', $playersByColor);
});

Route::post('ajax/color', function() {
  $colors = Game::find(Input::get('game_id'))->players()->lists('color');
  $color = Input::get('color');
  if(array_search($color, $colors) !== false)
  {
    return Response::make('Błąd '.json_encode($colors),403);
  }
  $player = Player::findByGameByUser(Input::get('game_id'), Auth::user()->id);
  $player->color = $color;
  $player->save();
  return Response::make('OK', 200);
});

Route::get('game/ajax/board', function() {
  $game = new CatanGame(Game::find(Input::get('game_id')));
  return Response::json($game->board->toJSON(false));
});

Route::post('game/ajax/trade', array('before'=>'turn',function() {
  $game = new CatanGame(Game::find(Input::get('game_id')));
  $players = $game->getOpponents();
  $clients = array();
  foreach ($players as $player)
  {
    if (Input::get("player_".$player->model->id))
    {
      array_push($clients,$player->model->id);
    }
  }
  $resources = array('wood','stone','sheep','clay','wheat');
  foreach($resources as $resource)
  {
    $offer[$resource] = Input::get("trade_$resource");
  }
  try
  {
      $game->tradeRequest($offer, $clients);
  } catch (Exception $exc)
  {
      return Response::make($exc->getMessage(),403);
  }
  return Response::make('OK',200);
}));

Route::post('game/ajax/tradeaccept', function(){
  $input  = Input::all();
  $key = array_search('on', $input);
  $hostarray = explode('_', $key);
  $host = $hostarray[1];
  $resources = array('wood','stone','sheep','clay','wheat');
  foreach($resources as $resource)
  {
    $offer[$resource] = $input["trade_$resource"];
  }
  $client = Player::findByGameByUser($input['game_id'], Auth::user()->id);
  $trade = Trade::findByHostByClient($host, $client->id);
  $trade->accept($offer);
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

Route::post('game/ajax/next', array('before'=>'turn', function() {
    $game = new CatanGame(Game::find(Input::get('game_id')));
    $game->endMove();
    return Response::make('OK!', 200);
}));

Route::post('game/ajax/build', array('before'=>'turn', function(){
  $game = new CatanGame(Game::find(Input::get('game_id')));
  if($game->model->turn_number == 0)
  {
    try
    {
      $game->settleItem(Input::get('item'), Input::get('id'));
    } 
    catch (Exception $exc)
    {
      return Response::make($exc->getMessage(),403);
    }
  }
  else
  {
    try
    {
      $game->buyItem(Input::get('item'), Input::get('id'));
    } 
    catch (Exception $exc)
    {
      return Response::make(var_dump($exc),403);
    }
  }
  return Response::make('OK!',200);
}));

Route::get('game/ajax/update', function(){
  $game = new CatanGame(Game::find(Input::get('game_id')));
  return Response::json($game->toJSON());
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
