<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Usersearchteam
 * 
 * @property int $idUserST
 * @property int $idUser
 * @property Carbon $date
 * @property string $description
 * @property string|null $video
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Usersearchteam extends Model
{
	protected $table = 'usersearchteam';
	protected $primaryKey = 'idUserST';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'idUserST' => 'int',
		'idUser' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'idUser',
		'date',
		'description',
		'video'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'idUser');
	}
}
