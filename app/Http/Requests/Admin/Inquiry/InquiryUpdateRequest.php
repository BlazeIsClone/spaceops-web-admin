<?php

namespace App\Http\Requests\Admin\Inquiry;

use App\Enums\InquiryStatus;
use App\Http\Requests\BaseRequest;
use App\Models\Inquiry;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;

class InquiryUpdateRequest extends BaseRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
	 */
	public function rules(): array
	{
		return [
			'name' => [
				'required', 'string', 'min:3', 'max:255', Rule::unique(Inquiry::class, 'name')->ignore($this->inquiry),
			],
			'status' => [
				'required', 'integer', new Enum(InquiryStatus::class),
			],
		];
	}
}
