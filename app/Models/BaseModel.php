<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;

/**
 * Class BaseModel
 * Base class for all Models
 */
abstract class BaseModel extends Model
{
	use ValidatingTrait;

	/**
	 * Let's always throw a validation exception so we don't silently fail and not save/update.
	 * @var bool
	 * @see Watson\Validating\ValidatingTrait
	 */
	protected $throwValidationExceptions = true;

	/**
	 * The default rules that the model will validate against.
	 *
	 * @var array
	 * @see Watson\Validating
	 */
	protected $rules = [];

	/**
	 * The default validation messages that the model will use.
	 * @var array
	 * @see Watson\Validating
	 */
	protected $validationMessages = [];


	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
	}
}
