<?php

namespace App\Models;

use App\Models\Interfaces\HasRelationsInterface;
use App\Models\Traits\HasCreatedBy;
use App\Models\Traits\HasUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Country extends Model implements HasRelationsInterface
{
	use HasFactory, InteractsWithMedia, HasCreatedBy, HasUpdatedBy;

	/**
	 * Indicates if the model should be timestamped.
	 */
	public $timestamps = false;

	/**
	 * Indicates if the IDs are auto-incrementing.
	 */
	public $incrementing = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'flag',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [];

	/**
	 * Define model methods with Has relations.
	 */
	public function defineHasRelationships(): array
	{
		return [];
	}
}
