<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * 
 * @property int $idUser
 * @property string $username
 * @property string $mail
 * @property string $password
 * @property int $platform
 * @property int|null $idActualTeam
 * @property string $logo
 * @property string|null $twitter
 * @property string|null $position
 * @property string|null $secondPosition
 * 
 * @property Team|null $team
 * @property Collection|Notification[] $notifications
 * @property Collection|Team[] $teams
 * @property Collection|Usersearchteam[] $usersearchteams
 *
 * @package App\Models
 */
class User extends Authenticatable implements JWTSubject
{
	protected $table = 'users';
	protected $primaryKey = 'idUser';
	public $timestamps = false;

	protected $casts = [
		'platform' => 'int',
		'idActualTeam' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'username',
		'mail',
		'password',
		'platform',
		'idActualTeam',
		'logo',
		'twitter',
		'position',
		'secondPosition'
	];

	public function team()
	{
		return $this->belongsTo(Team::class, 'idActualTeam');
	}

	public function notifications()
	{
		return $this->hasMany(Notification::class, 'idUser');
	}

	public function teams()
	{
		return $this->belongsToMany(Team::class, 'teamusers', 'idUser', 'idTeam');
	}

	public function usersearchteams()
	{
		return $this->hasMany(Usersearchteam::class, 'idUser');
	}

	public function getJWTIdentifier(){
		return $this->getKey();
	}

	public function getJWTCustomClaims(){
		return [];
	}
}
