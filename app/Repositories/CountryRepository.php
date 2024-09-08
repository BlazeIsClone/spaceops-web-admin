<?php

namespace App\Repositories;

use App\Models\Country;
use Illuminate\Support\Collection;

class CountryRepository
{
	public function __construct(
		private Country $country,
	) {
	}

	/**
	 * Get all countries.
	 */
	public function getAll(): Collection
	{
		return $this->country::all();
	}

	/**
	 * Display the specified country.
	 */
	public function getById(int $countryId): ?Country
	{
		return Country::find($countryId);
	}
}
