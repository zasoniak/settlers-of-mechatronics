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
Route::get('interface', function()
{
  return View::make('interface');
});

/* game routes */

Route::when('game*', 'auth');
Route::when('*ajax*', 'ajax');

Route::get('game/create', function(){
  $game = CatanGame::generate(Auth::user());
  return Redirect::to('game/'.$game->model->id.'/join');
});

Route::get('game/my', function(){
  $games = Game::your();
  return View::make('yourgamelist')->with('games', $games);
});

Route::get('game', function(){
  $games = Game::waiting();
  return View::make('gamelist')->with('games', $games);
});

Route::get('game/{id}', function($id){
  $game = new CatanGame(Game::find($id));
  if($game->model->is_finished)
  {
    return Response::make("Gra została zakończona.",200);
  }
  return View::make('game')->with('game',$game);
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

Route::get('game/{id}/start', function($id) {
  $game = new CatanGame(Game::find($id));
  try
  {
    $game->start();
  } catch (Exception $exc)
  {
    return Response::make($exc->getMessage());
  }
  return Redirect::to("game/$id");
});

Route::post('game/{id}/ajax/color', function($id) {
  $colors = Game::find(Input::get('game_id'))->players()->lists('color');
  $color = Input::get('color');
  if(array_search($color, $colors) !== false)
  {
    return Response::make('Ktoś już zajął ten kolor :(',403);
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

Route::post('game/ajax/tradereject', function(){
  $input  = Input::all();
  $key = array_search('on', $input);
  $hostarray = explode('_', $key);
  $host = $hostarray[1];
  $client = Player::findByGameByUser($input['game_id'], Auth::user()->id);
  $trade = Trade::findByHostByClient($host, $client->id);
  $trade->reject();
  return Response::make('OK', 200);
});

Route::post('game/ajax/tradeconfirm', function(){
  $input  = Input::all();
  $key = array_search('on', $input);
  $hostarray = explode('_', $key);
  $client = $hostarray[1];
  $host = Player::findByGameByUser($input['game_id'], Auth::user()->id);
  $trade = Trade::findByHostByClient($host->id, $client);
  try
  {
    $trade->confirm();
  } catch (Exception $exc) {
    return Response::make($exc->getMessage(),403);
  }
  $trade->delete();
  $rejected = Trade::where('host_id', $host)->get();
  foreach ($rejected as $reject)
  {
    $reject->delete();
  }
  return Response::make('OK',200);
});

Route::post('game/ajax/tradedelete', function(){
  $input  = Input::all();
  $key = array_search('on', $input);
  $hostarray = explode('_', $key);
  $client = $hostarray[1];
  $host = Player::findByGameByUser($input['game_id'], Auth::user()->id);
  $trade = Trade::findByHostByClient($host, $client->id);
  $trade->delete();
  return Response::make('OK',200);
});

Route::post('game/ajax/playcard', function(){
  $input = Input::all();
  $player = Player::findByGameByUser($input['game_id'], Auth::user()->id);
  $card = new CatanCard(Card::find($input['id']));
  if($card->model->player->id != $player->id)
  {
    return Response::make('To nie Twoja karta!', 403);
  }
  $data = array();
  if(isset($input['res']))
  {
    $data['resource'] = $input['res'];
  }
  if(isset($input['trade_wood']))
  {
    $resources = array('wood', 'stone', 'sheep', 'clay', 'wheat');
    foreach ($resources as $resource)
    {
      $offer[$resource] = $input["trade_$resource"];
    }
    $data['offer'] = $offer;
  }
  try
  {
    $card->play($data);
  } catch (Exception $exc)
  {
    return Response::make($exc->getMessage(), 403);
  }
  return Response::make('OK', 200);
});

Route::post('game/ajax/thief', array('before'=>'turn', function(){
  $game = new CatanGame(Game::find(Input::get('game_id')));
  try
  {
    $game->moveThief(Input::get('new_thief_location'), Input::get('player_id'));
  } catch (Exception $exc) {
    return Response::make($exc->getMessage(),403);
  }
  return Response::make('OK!', 200);
}));

Route::post('game/ajax/next', array('before'=>'turn', function() {
  $game = new CatanGame(Game::find(Input::get('game_id')));
  try
  {
    $game->endMove();
  } catch (Exception $exc) {
    return Response::make($exc->getMessage(),403);
  }
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
      return Response::make($exc->getMessage(),403);
    }
  }
  return Response::make('OK!',200);
}));

Route::get('game/ajax/update', function(){
  $game = new CatanGame(Game::find(Input::get('game_id')));
  return Response::json($game->toJSON());
});
