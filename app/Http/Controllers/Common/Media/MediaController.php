<?php

namespace App\Http\Controllers\Common\Media;

use App\Http\Controllers\Common\CommonBaseController;
use App\Messages\MediaMessage;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response as Http;

class MediaController extends CommonBaseController
{
	public function __construct(
		private MediaService $mediaService,
		private MediaMessage $mediaMessage,
	) {
		//
	}

	/**
	 * FilePond process route for asynchronous upload.
	 */
	public function store(Request $request): HttpResponse
	{
		return Response::make(
			$this->mediaService->store($request),
			Http::HTTP_OK,
			['content-type' => 'text/plain']
		);
	}

	/**
	 * FilePond restore temporary server upload.
	 */
	public function restore(?string $id = ''): HttpResponse
	{
		$fileData = $this->mediaService->restore($id);

		if (!$fileData) {
			return Response::make(
				$this->mediaMessage->restoreFailed(),
				Http::HTTP_BAD_REQUEST,
				['content-type' => 'text/plain']
			);
		}

		return Response::make($fileData['file'], Http::HTTP_OK)
			->header('Content-Disposition', "inline; filename=\"{$fileData['file_name']}\"")
			->header('Content-Type', $fileData['mime_type']);
	}

	/**
	 * Reverting the upload.
	 */
	public function revert(Request $request): HttpResponse
	{
		$deleted = $this->mediaService->revert($request);

		if (!$deleted) {
			return Response::make(
				$this->mediaMessage->revertFailed(),
				Http::HTTP_BAD_REQUEST,
				['content-type' => 'text/plain']
			);
		}

		return Response::make(
			'',
			Http::HTTP_OK,
			['content-type' => 'text/plain']
		);
	}
}
