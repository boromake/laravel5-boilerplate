<?php

namespace App\Models;

use App\Models\BaseModel;

class ExampleModel extends BaseModel
{
	/**
	 * Use this trait if this Model makes use of Laravel's "Soft Delete" feature
	 * @see https://laravel.com/docs/5.3/eloquent#soft-deleting
	 */
	use SoftDeletes;

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	/*
	protected static function boot()
	{
		parent::boot();

		//add a custom anonymous global scope
		static::addGlobalScope('scope_name', function(Builder $builder) {
			$builder->where('age', '>', 200);
		});
	}
	*/

	/**
	 * The name of the corresponding database table
	 * @var string
	 */
	protected $table = 'my_table';

	/**
	 * Set this if the primary key of the corresponding database table is not 'id'
	 * If it is, then you should delete this property
	 * @var string
	 */
	protected $primaryKey = 'primary_key';

	/**
	 * Eloquent assumes that the primary key is an incrementing integer value. If you wish to use a
	 * non-incrementing primary key, you must set the $incrementing property on your model to false.
	 * If true, then you should delete this property.
	 * @var bool
	 */
	public $incrementing = true;

	/**
	 * Eloquent expects 'created_at' and 'updated_at' columns to exist on your tables. If you do not
	 * have these fields, then set this property to false.
	 * If true, then you should delete this property.
	 * @var bool
	 */
	public $timestamps = true;

	/**
	 * Add any fields that should be mutated to dates.
	 * 'created_at', 'updated_at', and 'deleted_at' will automaticallly be mutated, so you don't need to add them.
	 * @var array
	 */
	protected $dates = [
		'some_date_column'
	];

	/**
	 * Add all database fields you want to make mass assignable
	 * @var array
	 */
	protected $fillable = [
		'column_name_1',
		'column_name_2',
	];

	/**
	 * Sometimes you may wish to limit the attributes, such as passwords, that are included in your model's
	 * array or JSON representation.
	 *
	 * @var array
	 * @see https://laravel.com/docs/5.2/eloquent-serialization#hiding-attributes-from-json
	 */
	protected $hidden = [
		'password'
	];

	/**
	 * The $casts property on your model provides a convenient method of converting attributes to common data types.
	 * The $casts property should be an array where the key is the name of the attribute being cast, while the value
	 * is the type you wish to cast to the column to.
	 *
	 * The supported cast types are:
	 * integer, real, float, double, string, boolean, object, array, collection, date and datetime.
	 *
	 * @var array
	 */
	protected $casts = [
		'is_admin' => 'boolean',
	];

	/**
	 * Add validation rules
	 * @var array
	 * @see https://github.com/dwightwatson/validating
	 * @see https://laravel.com/docs/5.2/validation#available-validation-rules
	 */
	protected $rules = [
		'example_start_date' => 'required|date_format:n/j/Y|before:tomorrow',
		'example_end_date' => 'bail|required|date_format:n/j/Y|after:start_date',
		'example_number' => 'required|numeric|between:0,99.99',
		'example_required_field' => 'required',
	];

	/**
	 * Optionally add any custom error messaging
	 * @var array
	 * @see https://github.com/dwightwatson/validating
	 * @see https://laravel.com/docs/5.2/validation#custom-error-messages
	 */
	protected $validationMessages = [
		'example_date' => 'The :attribute must be in the format: mm/dd/yyyy',
	];

	/**
	 * Example local scope
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 * @see https://laravel.com/docs/5.2/eloquent#local-scopes
	 */
	/*
	public function scopeOfType($query, $type)
	{
		return $query->where('type', $type);
	}
	*/

	/**
	 * Example Accessor
	 *
	 * @see https://laravel.com/docs/5.1/eloquent-mutators#accessors-and-mutators
	 *
	 * @param  string  $value
	 * @return string
	 */
	/*public function getFirstNameAttribute($value)
	{
		return (new Carbon($value))->format(config('app.date_format'));
	}*/

	/**
	 * Example Mutator
	 *
	 * @see https://laravel.com/docs/5.1/eloquent-mutators#accessors-and-mutators
	 *
	 * @param  string  $value
	 * @return string
	 */
	/*public function setFirstNameAttribute($value)
	{
		$this->attributes['first_name'] = strtolower($value);
	}*/


	/**
	 * Example relationships
	 */
	/*

	//This is a parent, that has ONE child object
	public function post()
	{
		return $this->hasOne('App\Phone', 'foreign_key', 'local_key');
	}

	//This is a parent, that has ONE or MANY child objects
	public function comments()
	{
		return $this->hasMany('App\Comment', 'foreign_key', 'local_key');
	}

	//This is a child to a parent
	public function user()
	{
		return $this->belongsTo('App\Models\Users\User', 'local_key', 'foreign_key');
	}
	*/
}