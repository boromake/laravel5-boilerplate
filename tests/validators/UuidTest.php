<?php

use Ramsey\Uuid\Uuid;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UuidTest extends TestCase
{
	/**
	 * Test that Uuid validation passes
	 *
	 * @return void
	 */
	public function testUuidValidator()
	{
		$valid_uuid = Uuid::uuid4()->toString();

		$validator = Validator::make(['uuid' => $valid_uuid], [
			'uuid' => 'uuid',
		]);

		$this->assertTrue($validator->passes());
	}

	/**
	 * Test that Uuid validation correctly fails
	 *
	 * @return void
	 */
	public function testUuidValidatorFails()
	{
		$invalid_uuid = 'invalid uuid';

		$validator = Validator::make(['uuid' => $invalid_uuid], [
			'uuid' => 'uuid',
		]);

		$this->assertFalse($validator->passes());
	}
}
