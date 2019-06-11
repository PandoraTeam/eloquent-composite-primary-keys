<?php
namespace PandoraTeam\EloquentCompositePrimaryKeys;

use Illuminate\Database\Eloquent\Builder;

trait HasCompositePrimaryKey {

	/**
	 * Get the value indicating whether the IDs are incrementing.
	 *
	 * @return bool
	 */
	public function getIncrementing() {
		return false;
	}

	/**
	 * Set the keys for a save update query.
	 *
	 * @param Builder $query
	 * @return Builder
	 */
	protected function setKeysForSaveQuery(Builder $query) {
		$keys = $this->getKeyName();
		if (!is_array($keys)) {
			return parent::setKeysForSaveQuery($query);
		}

		foreach ($keys as $keyName) {
			$query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
		}

		return $query;
	}

	/**
	 * Get the primary key value for a save query.
	 *
	 * @param mixed $keyName
	 * @return mixed
	 */
	protected function getKeyForSaveQuery($keyName = null) {
		if (is_null($keyName)) {
			$keyName = $this->getKeyName();
		}

		if (isset($this->original[$keyName])) {
			return $this->original[$keyName];
		}

		return $this->getAttribute($keyName);
	}

}
