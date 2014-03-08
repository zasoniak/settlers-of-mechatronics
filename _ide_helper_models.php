<?php
/**
 * An helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace {
/**
 * Port
 *
 * @property integer $id
 * @property string $type
 * @property integer $board_id
 * @property integer $x
 * @property integer $y
 * @property integer $z
 * @method static \Illuminate\Database\Query\Builder|\Port whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Port whereType($value) 
 * @method static \Illuminate\Database\Query\Builder|\Port whereBoardId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Port whereX($value) 
 * @method static \Illuminate\Database\Query\Builder|\Port whereY($value) 
 * @method static \Illuminate\Database\Query\Builder|\Port whereZ($value) 
 */
	class Port {}
}

namespace {
/**
 * Game
 *
 */
	class Game {}
}

namespace {
/**
 * User
 *
 * @property integer $id
 * @property string $nickname
 * @property string $email
 * @property string $password
 * @property integer $games_played
 * @property integer $games_won
 * @property integer $games_completed
 * @method static \Illuminate\Database\Query\Builder|\User whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\User whereNickname($value) 
 * @method static \Illuminate\Database\Query\Builder|\User whereEmail($value) 
 * @method static \Illuminate\Database\Query\Builder|\User wherePassword($value) 
 * @method static \Illuminate\Database\Query\Builder|\User whereGamesPlayed($value) 
 * @method static \Illuminate\Database\Query\Builder|\User whereGamesWon($value) 
 * @method static \Illuminate\Database\Query\Builder|\User whereGamesCompleted($value) 
 */
	class User {}
}

namespace {
/**
 * Tile
 *
 * @property integer $id
 * @property string $type
 * @property integer $x
 * @property integer $y
 * @property integer $z
 * @property integer $probability
 * @property integer $board_id
 * @property-read \Board $board
 * @method static \Illuminate\Database\Query\Builder|\Tile whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Tile whereType($value) 
 * @method static \Illuminate\Database\Query\Builder|\Tile whereX($value) 
 * @method static \Illuminate\Database\Query\Builder|\Tile whereY($value) 
 * @method static \Illuminate\Database\Query\Builder|\Tile whereZ($value) 
 * @method static \Illuminate\Database\Query\Builder|\Tile whereProbability($value) 
 * @method static \Illuminate\Database\Query\Builder|\Tile whereBoardId($value) 
 */
	class Tile {}
}

namespace {
/**
 * Player
 *
 * @property integer $id
 * @property integer $board_id
 * @property integer $user_id
 * @property integer $wood
 * @property integer $stone
 * @property integer $sheep
 * @property integer $clay
 * @property integer $wheat
 * @property-read \User $user
 * @property-read \Board $board
 * @method static \Illuminate\Database\Query\Builder|\Player whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Player whereBoardId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Player whereUserId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Player whereWood($value) 
 * @method static \Illuminate\Database\Query\Builder|\Player whereStone($value) 
 * @method static \Illuminate\Database\Query\Builder|\Player whereSheep($value) 
 * @method static \Illuminate\Database\Query\Builder|\Player whereClay($value) 
 * @method static \Illuminate\Database\Query\Builder|\Player whereWheat($value) 
 */
	class Player {}
}

namespace {
/**
 * Road
 *
 * @property integer $id
 * @property integer $board_id
 * @property integer $x
 * @property integer $y
 * @property integer $z
 * @property-read \Tile $tile1
 * @property-read \Tile $tile2
 * @property-read \Player $player
 * @method static \Illuminate\Database\Query\Builder|\Road whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Road whereBoardId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Road whereX($value) 
 * @method static \Illuminate\Database\Query\Builder|\Road whereY($value) 
 * @method static \Illuminate\Database\Query\Builder|\Road whereZ($value) 
 */
	class Road {}
}

namespace {
/**
 * Board
 *
 * @property integer $id
 * @property integer $thief
 * @property boolean $finished
 * @property boolean $is_changed
 * @property-read \Game $game
 * @property-read \Illuminate\Database\Eloquent\Collection|\Tile[] $tiles
 * @property-read \Illuminate\Database\Eloquent\Collection|\Settlement[] $settlements
 * @property-read \Illuminate\Database\Eloquent\Collection|\Road[] $roads
 * @property-read \Illuminate\Database\Eloquent\Collection|\Port[] $ports
 * @method static \Illuminate\Database\Query\Builder|\Board whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Board whereThief($value) 
 * @method static \Illuminate\Database\Query\Builder|\Board whereFinished($value) 
 * @method static \Illuminate\Database\Query\Builder|\Board whereIsChanged($value) 
 */
	class Board {}
}

namespace {
/**
 * Settlement
 *
 * @property integer $id
 * @property boolean $is_town
 * @property integer $board_id
 * @property integer $x
 * @property integer $y
 * @property integer $z
 * @property-read \Board $board
 * @method static \Illuminate\Database\Query\Builder|\Settlement whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Settlement whereIsTown($value) 
 * @method static \Illuminate\Database\Query\Builder|\Settlement whereBoardId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Settlement whereX($value) 
 * @method static \Illuminate\Database\Query\Builder|\Settlement whereY($value) 
 * @method static \Illuminate\Database\Query\Builder|\Settlement whereZ($value) 
 */
	class Settlement {}
}

