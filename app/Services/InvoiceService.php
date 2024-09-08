<?php

namespace App\Services;

use App\Enums\InvoicePaymentStatus;
use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Notifications\Invoice\InvoiceCreateCustomerNotification;
use App\Notifications\Invoice\InvoiceUpdateCustomerNotification;
use App\Repositories\InvoiceRepository;
use App\RoutePaths\Pdf\PdfRoutePath;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDF;
use Exception;

class InvoiceService extends BaseService
{
	public function __construct(
		private InvoiceRepository $invoiceRepository,
		private SettingService $settingService,
		private CustomerService $customerService,
	) {
		parent::__construct($invoiceRepository);
	}

	/**
	 * Get all invoices.
	 */
	public function getAllInvoices(): Collection
	{
		return $this->invoiceRepository->getAll();
	}

	/**
	 * Create a new invoice.
	 */
	public function createInvoice(array $attributes): Invoice
	{
		$notification = Arr::pull($attributes, 'notification');

		if ($this->getAdminAuthUser()) {
			$attributes['created_by'] = $this->getAdminAuthUser()->id;
		}

		$invoice = $this->invoiceRepository->create($attributes);

		if ($notification) {
			$this->invoiceCreateMailNotification($invoice);
		}

		return $invoice;
	}

	/**
	 * Get the specified invoice.
	 */
	public function getInvoice(int $invoiceId): ?Invoice
	{
		return $this->invoiceRepository->getById($invoiceId);
	}

	/**
	 * Get the specified invoice attribute.
	 */
	public function getInvoiceWhere(string $columnName, mixed $value): ?Invoice
	{
		return $this->invoiceRepository->getFirstWhere($columnName, $value);
	}

	/**
	 * Get the invoice that belongs to the customer.
	 */
	public function getCustomerInvoice(int $invoiceId, int $customerId): ?Invoice
	{
		return $this->invoiceRepository->getCustomerInvoice($invoiceId, $customerId);
	}

	/**
	 * Get the invoices that belongs to the customer.
	 */
	public function getCustomerInvoices(int $customerId): Collection
	{
		return $this->invoiceRepository->getCustomerInvoices($customerId);
	}

	/**
	 * Get the count of invoices that are past the due date.
	 */
	public function dueInvoiceCount(): int
	{
		return $this->invoiceRepository->getModel()
			->whereDate('due_date', '<', now())
			->where('status', '!=', InvoiceStatus::DRAFT)
			->where('payment_status', '!=', InvoicePaymentStatus::PAID)
			->count();
	}

	/**
	 * Check if the invoice is currently due.
	 */
	public function isDueInvoice(Invoice $invoice): bool
	{
		return $this->invoiceRepository->getModel()
			->where('id', $invoice->id)
			->whereDate('due_date', '<', now())
			->where('status', '!=', InvoiceStatus::DRAFT)
			->where('payment_status', '!=', InvoicePaymentStatus::PAID)
			->exists();
	}

	/**
	 * Delete a specific invoice.
	 */
	public function deleteInvoice(int $invoiceId): int
	{
		return $this->invoiceRepository->delete($invoiceId);
	}

	/**
	 * Update an existing invoice.
	 */
	public function updateInvoice(int $invoiceId, array $newAttributes): bool
	{
		$notification = Arr::pull($newAttributes, 'notification');

		if ($this->getAdminAuthUser()) {
			$newAttributes['updated_by'] = $this->getAdminAuthUser()->id;
		}

		$updated = $this->invoiceRepository->update($invoiceId, $newAttributes);

		if ($notification) {
			$this->invoiceUpdateMailNotification(
				$this->getInvoice($invoiceId)
			);
		}

		return $updated;
	}

	/**
	 * Get invoice file name.
	 */
	public function invoiceFileName(Invoice $invoice): string
	{
		return Str::of($invoice->number)
			->prepend('-')
			->prepend('invoice')
			->replace('/', '-');
	}

	/**
	 * Generate invoice PDF.
	 */
	public function invoicePDF(Invoice $invoice): DomPDF
	{
		return Pdf::loadView(PdfRoutePath::INVOICE, [
			'invoice' => $invoice,
		]);
	}

	/**
	 * Handle invoice create mail notfications.
	 */
	private function invoiceCreateMailNotification(Invoice $invoice): bool|Exception
	{
		try {
			$invoice->notify(new InvoiceCreateCustomerNotification($invoice));

			return true;
		} catch (Exception $e) {
			return $e;
		}

		return false;
	}

	/**
	 * Handle invoice update mail notfications.
	 */
	private function invoiceUpdateMailNotification(Invoice $invoice): bool|Exception
	{
		try {
			$invoice->notify(new InvoiceUpdateCustomerNotification($invoice));

			return true;
		} catch (Exception $e) {
			return $e;
		}

		return false;
	}

	/**
	 * return the custom filtered result as a page.
	 *
	 * @return integer 	$data[count]		Results Count
	 * @return array 	$data[data]			Results
	 */
	public function getAllWithCustomFilter($filterQuery, $filterColumns)
	{
		$query = $this->invoiceRepository->getModel()->select('*');

		$query->where(function ($subQuery) use ($filterQuery) {
			if (isset($filterQuery->status)) {
				if ($filterQuery->status === 'past_due_date') {
					$subQuery->where('status', InvoiceStatus::ACTIVE->value);
					$subQuery->where('payment_status', '!=', InvoicePaymentStatus::PAID->value);
					$subQuery->whereDate('due_date', '<', now());
				} else {
					$subQuery->where('status', $filterQuery->status);
				}
			}

			if (isset($filterQuery->payment_status)) {
				$subQuery->where('payment_status', $filterQuery->payment_status);
			}

			if (isset($filterQuery->number)) {
				$subQuery->where('number', 'like', '%' . $filterQuery->number . '%');
			}

			if (isset($filterQuery->date_start) && isset($filterQuery->date_end)) {
				$subQuery->whereBetween('created_at', [$filterQuery->date_start . ' 00:00:00', $filterQuery->date_end . ' 23:59:59']);
			}

			if (isset($filterQuery->customer)) {
				$subQuery->whereHas('customer', function ($subQuery) use ($filterQuery) {
					$subQuery->where('id', $filterQuery->customer);
				});
			}

			if (isset($filterQuery->company)) {
				$subQuery->whereHas('customer', function ($subQuery) use ($filterQuery) {
					$subQuery->where('company', 'like', '%' . $filterQuery->company . '%');
				});
			}
		});

		$query->where(function ($query) use ($filterColumns, $filterQuery) {
			foreach ($filterColumns as $column) {
				if ($column) {
					$query->orWhere($column, 'like', '%' . $filterQuery->search['value'] . '%');
				}
			}
		});

		$data['count'] = $query->count();

		$orderByColumn = $filterColumns[$filterQuery->order[0]['column']] ?? $filterColumns[count($filterColumns) - 1];
		$orderByDirection = $filterQuery->order[0]['dir'];

		$query->orderBy($orderByColumn, $orderByDirection);

		if ($filterQuery->length != -1) {
			$query->skip($filterQuery->start)->take($filterQuery->length);
		}

		$data['data'] = $query->get();

		return $data;
	}

	/**
	 * Get all customers.
	 */
	public function getAllCustomers(): Collection
	{
		return $this->customerService->getAllActiveCustomers();
	}
}
