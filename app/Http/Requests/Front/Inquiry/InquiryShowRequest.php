<?php

namespace App\Http\Requests\Front\Inquiry;

use App\Http\Requests\BaseRequest;
use App\RoutePaths\Front\Page\PageRoutePath;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class InquiryShowRequest extends BaseRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
	 */
	public function rules(): array
	{
		return [];
	}

	/**
	 * Modify the input data before validation.
	 */
	public function validationData(): array
	{
		$data = $this->all();

		try {
			if (isset($data['data'])) {
				$decryptedData = Crypt::decrypt($data['data']);
			}
		} catch (DecryptException) {
			redirect()->route(PageRoutePath::INQUIRY)
				->withErrors('URL parameters is invalid or expired.');
		}

		$this->replace($data);

		return $data;
	}
}
