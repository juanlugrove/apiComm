<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Teamuser
 * 
 * @property int $idTeam
 * @property int $idUser
 * 
 * @property User $user
 * @property Team $team
 *
 * @package App\Models
 */
class Teamuser extends Model
{
	protected $table = 'teamusers';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'idTeam' => 'int',
		'idUser' => 'int'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'idUser');
	}

	public function team()
	{
		return $this->belongsTo(Team::class, 'idTeam');
	}
}
