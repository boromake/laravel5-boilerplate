<?php

namespace App\Models\Users;

use App\Models\BaseModel;
use App\Traits\UuidModel;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends BaseModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
	use Notifiable, SoftDeletes, Authenticatable, Authorizable, CanResetPassword, UuidModel;

	protected $fillable = [
		'email',
		'account_type',
		'password',
	];

	protected $hidden = [
		'id',
		'password',
		'remember_token',
	];

	protected $rules = [
		'email' => 'required|email|unique:users',
		'password' => 'required',
	];

	protected $validationMessages = [
		'email.unique' => 'The email address you entered is already in use. Please try a different email address.',
	];

	public function __construct(array $attributes = [])
	{
		$this->uuid = Uuid::uuid4()->toString();

		parent::__construct($attributes);
	}
}