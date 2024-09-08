<?php

namespace App\Http\Requests\Front\Contact;

use App\Http\Requests\BaseRequest;

class ContactStoreRequest extends BaseRequest
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
				'required', 'string', 'min:1', 'max:255',
			],
			'email' => [
				'email', 'max:255',
			],
			'phone' => [
				'required', 'string', 'min:3', 'max:255',
			],
			'message' => [
				'required', 'string', 'min:3', 'max:255',
			],
		];
	}
}
