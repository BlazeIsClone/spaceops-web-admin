<?php

namespace App\Services;

use App\Models\Country;
use App\Repositories\CountryRepository;
use Illuminate\Support\Collection;

class CountryService extends BaseService
{
	public function __construct(
		private CountryRepository $countryRepository,
		private SettingService $settingService,
	) {
	}

	/**
	 * Get all countries.
	 */
	public function getAllCountries(): Collection
	{
		return $this->countryRepository->getAll();
	}

	/**
	 * Get the specified country.
	 */
	public function getCountry(int $countryId = null): ?Country
	{
		return $this->countryRepository->getById($countryId);
	}
}
