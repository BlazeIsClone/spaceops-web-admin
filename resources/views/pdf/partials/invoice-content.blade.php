<table style="margin: 0; width: 100%; border-collapse: collapse;">
    <header style="width: 100%;">
        <table style="width: 100%; border-collapse: collapse; margin: 20px auto; font-family: Helvetica, sans-serif;">
            <tbody>
                <tr style="vertical-align: top;">
                    <td colspan="2">
                        <h4 style="font-size: 32px; font-weight: bold; text-transform: uppercase; margin: 0;">
                            {{ __('Invoice') }}
                        </h4>
                        <span style="display: block; margin-top: 4px; font-size: 16px; font-weight: normal;">
                            {{ $invoice->number }}
                        </span>
                        <span style="display: block; margin-top: 4px; font-size: 16px; font-weight: normal;">
                            @isset($invoice->payment_status)
                                <span style="font-size: 16px; font-weight: 600;">
                                    {{ $invoice->payment_status->getName() }}
                                </span>
                            @else
                                <span style="font-size: 16px; font-weight: 600;">
                                    {{ InvoicePaymentStatus::PENDING->name }}
                                </span>
                            @endisset
                        </span>
                    </td>
                    <td colspan="4" style="text-align: right;">
                        @if ($logo = settings(SettingModule::INVOICE)->getFirstMedia('logo'))
                            <img src="{{ isset($pdf) && $pdf ? $logo?->getPath() : $logo?->getFullUrl() }}"
                                alt="Company Logo" style="max-width: 200px;" />
                        @endif
                        <div style="margin-top: 20px; font-weight: 400; font-size: 14px; text-align: right;">
                            {!! settings(SettingModule::INVOICE)->get('company_content') !!}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </header>

    <table style="width: 100%; border-collapse: collapse; margin: 0 auto 20px; font-weight: 600;">
        <tbody>
            <tr>
                <td colspan="2" style="font-size: 18px;">
                    {{ $invoice->customer->name }}
                </td>
            </tr>
            @if (optional($invoice->customer)->company)
                <tr>
                    <td colspan="2" style="font-size: 16px; font-weight: 400;">
                        {{ $invoice->customer->company }}
                    </td>
                </tr>
            @endif
            <tr>
                <td colspan="2">
                    <a style="font-size: 16px; font-weight: 400; margin: 0px;">{{ $invoice->customer->email }}</a>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p style="margin-top: 2px; font-size: 14px; font-weight: 400;">{!! nl2br($invoice->customer->address) !!}</p>
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width: 60%; border-collapse: collapse; margin-bottom: 35px;">
        <thead>
            <tr>
                <td>
                    <span style="font-weight: bold; font-size: 13px; text-transform: uppercase; color: #817c7a">
                        {{ __('Date') }}
                    </span>
                </td>
                <td>
                    <span style="font-weight: bold; font-size: 13px; text-transform: uppercase; color: #817c7a">
                        {{ __('Due Date') }}
                    </span>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <span style="font-weight: 400;">
                        {{ $invoice->readableDate }}
                    </span>
                </td>
                <td>
                    <span style="font-weight: 400;">
                        {{ $invoice->readableDueDate }}
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%; border-collapse: collapse; margin: 0 auto 6px;">
        <thead>
            <tr>
                <th align="left" style="border: 1px solid #ddd; padding: 8px; background-color: #f0f1f3;">
                    <p
                        style="margin: 0; font-size: 12px; font-weight: bold; text-transform: uppercase; color: #555250;">
                        {{ __('Type') }}
                    </p>
                </th>
                <th align="left" style="border: 1px solid #ddd; padding: 8px; background-color: #f0f1f3;">
                    <p
                        style="margin: 0; font-size: 12px; font-weight: bold; text-transform: uppercase; color: #555250;">
                        {{ __('Item') }}
                    </p>
                </th>
                <th align="right"
                    style="border: 1px solid #ddd; padding: 8px; background-color: #f0f1f3; color: #555250; text-align: end;">
                    <p style="margin: 0; font-size: 12px; font-weight: bold; text-transform: uppercase;">
                        {{ __('Unit Price') }}
                    </p>
                </th>
                <th align="right"
                    style="border: 1px solid #ddd; padding: 8px; background-color: #f0f1f3; color: #555250; text-align: end;">
                    <p style="margin: 0; font-size: 12px; font-weight: bold; text-transform: uppercase;">
                        {{ __('Quantity') }}
                    </p>
                </th>
                <th align="right"
                    style="border: 1px solid #ddd; padding: 8px; background-color: #f0f1f3; color: #555250; text-align: end;">
                    <p style="margin: 0; font-size: 12px; font-weight: bold; text-transform: uppercase;">
                        {{ __('Amount') }}
                    </p>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->formattedInvoiceItems as $invoiceItem)
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px; min-width: 100px;">
                        <p style="margin: 3px 0 0; font-size: 14px;">
                            {{ $invoiceItem->type }}
                        </p>
                    </td>
                    <td style="border: 1px solid #ddd; padding: 8px; min-width: 100px;">
                        <p style="margin: 3px 0 0; font-size: 14px;">
                            {{ $invoiceItem->description }}
                        </p>
                    </td>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">
                        <span>{{ MoneyHelper::print($invoiceItem->unit_price) }}</span>
                    </td>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">
                        <span>{{ $invoiceItem->quantity }}</span>
                    </td>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">
                        <span>{{ MoneyHelper::print($invoiceItem->amount) }}</span>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" style="border: 1px solid #ddd; padding: 8px; font-size: 18px; font-weight: bold;">
                    {{ __('Total Amount') }}
                </td>
                <td
                    style="border: 1px solid #ddd; padding: 8px; text-align: right; font-size: 18px; font-weight: bold;">
                    {{ $invoice->readableTotalPrice }}
                </td>
            </tr>
            @empty($pdf)
                <tr>
                    @if ($invoice->status !== InvoiceStatus::COMPLETED)
                        <td colspan="5" style="padding-top: 15px; text-align: right;">
                            <a href="{{ $invoice->checkout_link }}" target="_blank" class="btn btn-sm btn-primary">
                                {{ __('Pay Now') }}
                            </a>
                        </td>
                    @endif
                </tr>
            @endempty
        </tbody>
    </table>

    @if ($invoice->notes)
        <table>
            <tbody>
                <tr>
                    <td style="padding-top: 25px;">
                        <h6
                            style="margin-bottom: 0; font-weight: bold; font-size: 13px; text-transform: uppercase; color: #817c7a">
                            {{ __('Notes') }}
                        </h6>
                        <p style="margin-top: 6px; ">{{ $invoice->notes }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif

    <footer
        style="@empty($pdf) margin-top: 30px; @else position: absolute; bottom: 0;  @endif width: 100%; font-size: 14px;">
        {!! settings(SettingModule::INVOICE)->get('footer_content') !!}
    </footer>
</table>
