<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 * 
 * @property int $idNotification
 * @property int $idUser
 * @property string $message
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Notification extends Model
{
	protected $table = 'notifications';
	protected $primaryKey = 'idNotification';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'idNotification' => 'int',
		'idUser' => 'int'
	];

	protected $fillable = [
		'idUser',
		'message'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'idUser');
	}
}
