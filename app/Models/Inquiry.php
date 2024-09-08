<?php

namespace App\Models;

use App\Enums\InquiryStatus;
use App\Models\Interfaces\HasRelationsInterface;
use App\Models\Traits\HasCreatedBy;
use App\Models\Traits\HasUpdatedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model implements HasRelationsInterface
{
	use HasFactory, HasCreatedBy, HasUpdatedBy;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'status',
		'name',
		'customer',
		'created_by',
		'updated_by',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'status' => InquiryStatus::class,
		'customer' => 'array',
	];

	/**
	 * Scope a query to only include active.
	 */
	public function scopeActive(Builder $query): void
	{
		$query->where('status', InquiryStatus::ACTIVE);
	}

	/**
	 * Define model methods with Has relations.
	 */
	public function defineHasRelationships(): array
	{
		return [];
	}
}
