<?php

namespace App\Services;

use App\Enums\SettingModule;
use App\Mail\InquiryMail;
use App\Models\Inquiry;
use App\Providers\AuthServiceProvider;
use App\Repositories\InquiryRepository;
use Illuminate\Mail\SentMessage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Exception;

class InquiryService extends BaseService
{
	public function __construct(
		private InquiryRepository $inquiryRepository,
		private SettingService $settingService,
	) {
		parent::__construct($inquiryRepository);
	}

	/**
	 * Get all resources.
	 */
	public function getAllInquiries(): Collection
	{
		return $this->inquiryRepository->getAll();
	}

	/**
	 * Get active resources.
	 */
	public function getActiveInquiries(array $inquiryIds = null): Collection
	{
		return $this->inquiryRepository->getActive($inquiryIds);
	}

	/**
	 * Get paginated resources.
	 */
	public function getPaginatedInquiries(): LengthAwarePaginator
	{
		return $this->inquiryRepository->getPaginated();
	}

	/**
	 * Create a new resource.
	 */
	public function createInquiry(array $attributes): Inquiry
	{
		if ($this->getAdminAuthUser()) {
			$attributes['created_by'] = $this->getAdminAuthUser()->id;
		} else {
			$attributes['created_by'] = AuthServiceProvider::SUPER_ADMIN;
		}

		return $this->inquiryRepository->create($attributes);
	}

	/**
	 * Get the specified resource.
	 */
	public function getInquiry(int $inquiryId = null): ?Inquiry
	{
		return $this->inquiryRepository->getById($inquiryId);
	}

	/**
	 * Get the specified resource attribute.
	 */
	public function getInquiryWhere(string $columnName, mixed $value): ?Inquiry
	{
		return $this->inquiryRepository->getFirstWhere($columnName, $value);
	}

	/**
	 * Delete a specific resource.
	 */
	public function deleteInquiry(int $inquiryId): int
	{
		return $this->inquiryRepository->delete($inquiryId);
	}

	/**
	 * Update an existing resource.
	 */
	public function updateInquiry(int $inquiryId, array $newAttributes): bool
	{
		if ($this->getAdminAuthUser()) {
			$newAttributes['updated_by'] = $this->getAdminAuthUser()->id;
		}

		return $this->inquiryRepository->update($inquiryId, $newAttributes);
	}

	/**
	 * Handle contact form submission.
	 */
	public function storeInquiryForm(array $attributes): bool|Exception
	{
		$this->createInquiry([
			...$attributes,
			'inquiry_name' => __('Inquiry by :name', $attributes),
		]);


		try {
			$this->InquiryMailNotification($attributes);
			return true;
		} catch (Exception $e) {
			return $e;
		}

		return false;
	}

	/**
	 * Handle contact form submission.
	 */
	public function storeContactForm(array $attributes): bool|Exception
	{
		try {
			$this->ContactFormMailNotification($attributes);

			return true;
		} catch (Exception $e) {
			return $e;
		}

		return false;
	}

	/**
	 * Handle mail notfications.
	 */
	private function InquiryMailNotification(array $attributes): ?SentMessage
	{
		$subject = Str::title("Inquiry Form Inqiury From {$attributes['name']}");

		return Mail::to($this->notificationEmails())->send(
			new InquiryMail(
				mailSubject: $subject,
				mailBody: $attributes,
			)
		);
	}

	/**
	 * Handle mail notfications.
	 */
	private function ContactFormMailNotification(array $attributes): ?SentMessage
	{
		$subject = Str::title("Contact Form Inqiury From {$attributes['name']}");

		return Mail::to($this->notificationEmails())->send(
			new InquiryMail(
				mailSubject: $subject,
				mailBody: $attributes,
			)
		);
	}

	/**
	 * Get mail settings.
	 */
	protected function mailSettings(): SettingService
	{
		return $this->settingService->module(SettingModule::MAIL);
	}

	/**
	 * Retrieve the notification emails.
	 */
	public function notificationEmails(): array
	{
		return Collection::make(
			$this->mailSettings()->get('notifications')
		)->pluck('email')->toArray();
	}
}
