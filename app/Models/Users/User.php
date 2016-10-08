<?php

namespace App\Models\Users;

use App\Enums\UserAccountTypes;
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
		'email' => 'required|max:255|email|unique:users',
		'password' => 'required|min:6|max:255',
	];

	protected $validationMessages = [
		'email.unique' => 'The email address you entered is already in use. Please try a different email address.',
	];

	public function __construct(array $attributes = [])
	{
		$this->uuid = Uuid::uuid4()->toString();

		parent::__construct($attributes);
	}


	#region Public methods

	/*
	 * True if the user is an admin
	 *
	 * @return boolean
	 */
	public function is_admin()
	{
		return $this->account_type == UserAccountTypes::OWNER || $this->account_type == UserAccountTypes::ADMIN;
	}

	/*
	 * True if the user is an "internal" user (defined as admin/moderator)
	 *
	 * @return boolean
	 */
	public function is_internal_user()
	{
		return $this->is_admin() || $this->account_type == UserAccountTypes::MODERATOR;
	}

	/*
	 * Determine if a user has access to a certain section of the site.
	 * We are incorrectly mixing website "section" with account type
	 *
	 * @param \App\Enums\UserAccountTypes $type
	 * @return boolean
	 */
	public function has_access($type)
	{
		switch($type)
		{
			case UserAccountTypes::ADMIN:
				return $this->is_admin();
				break;

			default:
				return false;
				break;
		}
	}

	#endregion


	#region Accessors / Mutators

	/**
	 * Mutator for 'password' field
	 *
	 * @param  string  $value
	 * @return string
	 */
	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = Hash::make($value);
	}

	#endregion



	#region Relationships

	public function login_history()
	{
		return $this->hasMany('App\Models\Users\LoginHistory', 'user_id', 'uuid');
	}

	#endregion
}
