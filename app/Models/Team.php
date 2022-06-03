<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Team
 * 
 * @property int $idTeam
 * @property string $name
 * @property int $captain
 * @property string $teamLogo
 * @property string|null $twitter
 * 
 * @property User $user
 * @property Collection|Teamsearchuser[] $teamsearchusers
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Team extends Model
{
	protected $table = 'teams';
	protected $primaryKey = 'idTeam';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'idTeam' => 'int',
		'captain' => 'int'
	];

	protected $fillable = [
		'name',
		'captain',
		'teamLogo',
		'twitter'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'captain');
	}

	public function teamsearchusers()
	{
		return $this->hasMany(Teamsearchuser::class, 'idTeam');
	}

	public function users()
	{
		return $this->hasMany(User::class, 'idActualTeam');
	}
}
