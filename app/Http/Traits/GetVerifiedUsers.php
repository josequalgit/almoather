<?php
namespace App\Http\Traits;

trait GetVerifiedUsers {

	/**
	 * Boot the scope.
	 * 
	 * @return void
	 */
	public static function bootGetVerifiedUsers()
	{
		//static::addGlobalScope(new GetVerifiedUsers);
	}

	/**
	 * Get the name of the column for applying the scope.
	 * 
	 * @return string
	 */
	public function getPublishedColumn()
	{
		return defined('static::email_verified_at') ? static::email_verified_at : true;
	}

	/**
	 * Get the fully qualified column name for applying the scope.
	 * 
	 * @return string
	 */
	public function getQualifiedPublishedColumn()
	{
		return $this->getTable().'.'.$this->getPublishedColumn();
	}

	/**
	 * Get the query builder without the scope applied.
	 * 
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public static function withDrafts()
	{
		return with(new static)->newQueryWithoutScope(new GetVerifiedUsers);
	}

}
