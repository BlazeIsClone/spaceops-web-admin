<?php

namespace App\Repositories;

use App\Models\Inquiry;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;

class InquiryRepository extends BaseRepository
{
	public function __construct(
		private Inquiry $inquiry,
	) {
		parent::__construct($inquiry);
	}

	/**
	 * Get all resources.
	 */
	public function getAll(): Collection
	{
		return $this->inquiry::all();
	}

	/**
	 * Get active resources.
	 */
	public function getActive(array $inquiryIds = null): Collection
	{
		if ($inquiryIds) {
			return $this->inquiry->active()
				->find($inquiryIds);
		}

		return $this->inquiry->active()
			->get();
	}

	/**
	 * Get resources with pagination.
	 */
	public function getPaginated(): LengthAwarePaginator
	{
		$query = $this->inquiry->active()
			->orderBy('created_at', 'desc');

		return $query->paginate();
	}

	/**
	 * Get the specified resource.
	 */
	public function getById(int $inquiryId): ?Inquiry
	{
		return $this->inquiry::find($inquiryId);
	}

	/**
	 * Get the resource by column name and value.
	 */
	public function getFirstWhere(string $columnName, mixed $value): ?Inquiry
	{
		return $this->inquiry::where($columnName, $value)->first();
	}

	/**
	 * Delete a specific resource.
	 */
	public function delete(int $inquiryId): bool
	{
		$inquiry = $this->getById($inquiryId);

		$this->checkModelHasParentRelations($inquiry);

		try {
			return $inquiry->delete($inquiryId);
		} catch (QueryException $e) {
			throw new \Exception($e->getMessage());

			return false;
		}
	}

	/**
	 * Create a new resource.
	 */
	public function create(array $attributes): Inquiry
	{
		$inquiry = $this->inquiry::create([
			'name' => $attributes['inquiry_name'],
			'customer' => $this->inquiryCustomerData($attributes),
			'created_by' => $attributes['created_by'],
		]);

		return $inquiry;
	}

	/**
	 * Update an existing resource.
	 */
	public function update(int $inquiryId, array $newAttributes): bool
	{
		$inquiry = $this->inquiry::findOrFail($inquiryId)
			->fill([
				'name' => $newAttributes['name'],
				'status' => $newAttributes['status'],
				'updated_by' => $newAttributes['updated_by'],
			]);

		$saved = $inquiry->save();

		return $saved;
	}

	/**
	 * Get the inquiry customer data payload.
	 */
	private function inquiryCustomerData(array $data): array
	{
		return Arr::only($data, [
			'name',
			'email',
			'phone',
			'message',
		]);
	}
}
