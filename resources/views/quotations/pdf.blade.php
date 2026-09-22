<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Quotation {{ $quotation->quotation_number }}</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 12mm 12mm 14mm 12mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
            margin: 0;
            padding: 0;
        }

        /* Company Header */
        .company-header {
            border-bottom: 2px solid #0891b2;
            padding-bottom: 6px;
            margin-bottom: 14px;
        }

        .company-name {
            font-size: 19px;
            font-weight: bold;
            color: #0891b2;
        }

        .company-tagline {
            font-size: 9px;
            color: #666;
            margin-top: 2px;
        }

        /* General */
        .section {
            margin-bottom: 12px;
        }

        .section-title {
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 5px;
        }

        .muted {
            color: #666;
        }

        /* Borderless information tables */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            vertical-align: top;
            padding: 2px 8px 2px 0;
        }

        .info-label {
            font-weight: bold;
            margin-bottom: 3px;
        }

        .info-value {
            color: #666;
        }

        /* Customer / Service Provider */
        .party-table {
            margin-bottom: 12px;
        }

        .party-table td {
            width: 50%;
            vertical-align: top;
            padding-right: 20px;
        }

        .party-name {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .party-details {
            color: #666;
            line-height: 1.45;
        }

        /* Quotation Items */
        .items-table {
            border: 1px solid #ccc;
        }

        .items-table th {
            font-weight: bold;
            padding: 6px 5px;
            border-bottom: 1px solid #999;
            text-align: left;
            white-space: nowrap;
        }

        .items-table td {
            padding: 6px 5px;
            vertical-align: top;
            border-bottom: 1px solid #ddd;
        }

        .items-table th.center,
        .items-table td.center {
            text-align: center;
        }

        .items-table th.right,
        .items-table td.right {
            text-align: right;
        }

        .description-name {
            font-weight: bold;
        }

        .description-code {
            font-size: 8px;
            color: #777;
        }

        .description-text {
            font-size: 9px;
            color: #666;
            margin-top: 2px;
            line-height: 1.35;
        }

        /* Summary */
        .summary-wrapper {
            width: 45%;
            margin-left: auto;
            margin-top: 10px;
        }

        .summary-table td {
            padding: 4px 0;
        }

        .summary-label {
            text-align: left;
            color: #555;
        }

        .summary-value {
            text-align: right;
        }

        .grand-total td {
            border-top: 1px solid #999;
            padding-top: 6px;
            font-weight: bold;
            font-size: 11px;
        }

        /* Notes / Terms */
        .notes-section {
            margin-top: 12px;
        }

        .notes-title {
            font-weight: bold;
            margin-bottom: 3px;
        }

        .notes-text {
            color: #666;
            line-height: 1.4;
        }

        .terms-section {
            margin-top: 8px;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            border-top: 2px solid #0891b2;
            padding-top: 4px;
            font-size: 7.5px;
            color: #666;
        }

        .footer-table td {
            vertical-align: top;
        }

        .footer-left {
            width: 25%;
        }

        .footer-right {
            width: 75%;
            text-align: right;
        }

        /* Prevent important blocks from splitting */
        .no-break {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

    {{-- Company Header --}}
    <div class="company-header">
        <div class="company-name">
            Meissa Software Solutions Pvt. Ltd.
        </div>

        <div class="company-tagline">
            Aim To Provide Affordable Solutions
        </div>
    </div>


    {{-- Quotation Information --}}
    <div class="section no-break">

        <table class="info-table">
            <tr>
                <td width="25%">
                    <div class="info-label">Date</div>
                    <div class="info-value">
                        {{ $quotation->quotation_date?->format('d M Y') }}
                    </div>
                </td>

                <td width="25%">
                    <div class="info-label">Quote No.</div>
                    <div class="info-value">
                        {{ $quotation->quotation_number }}
                    </div>
                </td>

                <td width="25%">
                    <div class="info-label">Valid Until</div>
                    <div class="info-value">
                        {{ $quotation->valid_until?->format('d M Y') ?? '—' }}
                    </div>
                </td>

                <td width="25%">
                    <div class="info-label">Installation</div>
                    <div class="info-value">
                        {{ $quotation->service_arrangement ?: '—' }}
                    </div>
                </td>
            </tr>
        </table>

    </div>


    {{-- Customer / Service Provider --}}
    <div class="section no-break">

        <table class="party-table">
            <tr>

                {{-- Customer --}}
                <td>
                    <div class="section-title">
                        To
                    </div>

                    <div class="party-name">
                        {{ $quotation->customer->company_name }}
                    </div>

                    <div class="party-details">

                        @if ($quotation->customer->contact_person)
                            {{ $quotation->customer->contact_person }}<br>
                        @endif

                        @if ($quotation->customer->address_line1)
                            {{ $quotation->customer->address_line1 }}<br>
                        @endif

                        @if ($quotation->customer->address_line2)
                            {{ $quotation->customer->address_line2 }}<br>
                        @endif

                        @if ($quotation->customer->city)
                            {{ $quotation->customer->city }}
                        @endif

                        @if ($quotation->customer->state)
                            , {{ $quotation->customer->state }}
                        @endif

                        @if ($quotation->customer->pincode)
                            - {{ $quotation->customer->pincode }}
                        @endif

                        @if ($quotation->customer->gstin)
                            <br>
                            GSTIN: {{ $quotation->customer->gstin }}
                        @endif

                    </div>
                </td>


                {{-- Service Provider --}}
                <td>
                    <div class="section-title">
                        Service Provider
                    </div>

                    <div class="party-name">
                        Meissa Software Solutions Pvt. Ltd.
                    </div>

                    <div class="party-details">
                        Ph: +91-9881124454<br>
                        support-meissa@meissa.co.in
                    </div>
                </td>

            </tr>
        </table>

    </div>


    {{-- Quotation Items --}}
    <div class="section">

        <table class="items-table">

            <thead>
                <tr>
                    <th class="center" width="7%">
                        S.No.
                    </th>

                    <th width="37%">
                        Description
                    </th>

                    <th width="12%">
                        Duration
                    </th>

                    <th class="right" width="12%">
                        Quantity
                    </th>

                    <th class="right" width="16%">
                        Price
                    </th>

                    <th class="right" width="16%">
                        Total Price
                    </th>
                </tr>
            </thead>

            <tbody>

                @foreach ($quotation->quotationItems as $index => $item)

                    <tr>

                        {{-- S.No. --}}
                        <td class="center">
                            {{ $index + 1 }}
                        </td>

                        {{-- Description --}}
                        <td>
                            <div class="description-name">
                                {{ $item->product->name }}
                            </div>

                            @if ($item->product->code)
                                <div class="description-code">
                                    Code: {{ $item->product->code }}
                                </div>
                            @endif

                            @if ($item->description)
                                <div class="description-text">
                                    {{ $item->description }}
                                </div>
                            @endif
                        </td>

                        {{-- Duration --}}
                        <td>
                            {{ $item->duration ?: '—' }}
                        </td>

                        {{-- Quantity --}}
                        <td class="right">
                            {{ number_format($item->quantity, 2) }}
                        </td>

                        {{-- Price --}}
                        <td class="right">
                            ₹{{ number_format($item->unit_price, 2) }}
                        </td>

                        {{-- Total --}}
                        <td class="right">
                            ₹{{ number_format($item->base_amount, 2) }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>


    {{-- Quotation Summary --}}
    <div class="summary-wrapper no-break">

        <table class="summary-table">

            <tr>
                <td class="summary-label">
                    Subtotal
                </td>

                <td class="summary-value">
                    ₹{{ number_format($quotation->subtotal, 2) }}
                </td>
            </tr>

            <tr>
                <td class="summary-label">
                    GST ({{ number_format($quotation->gst_rate ?? 0, 2) }}%)
                </td>

                <td class="summary-value">
                    ₹{{ number_format($quotation->gst_amount, 2) }}
                </td>
            </tr>

            <tr class="grand-total">
                <td>
                    Grand Total
                </td>

                <td class="summary-value">
                    ₹{{ number_format($quotation->grand_total, 2) }}
                </td>
            </tr>

        </table>

    </div>


    {{-- Notes --}}
    <div class="notes-section no-break">

        <div class="notes-title">
            Notes
        </div>

        <div class="notes-text">
            {{ $quotation->notes ?: '—' }}
        </div>

    </div>


    {{-- Terms & Conditions --}}
    <div class="terms-section">

        <div class="notes-title">
            Terms & Conditions
        </div>

        <div class="notes-text">
            All Terms and Conditions are attached to the quotation.
        </div>

    </div>


    {{-- Company Footer --}}
    <div class="footer">

        <table class="footer-table">

            <tr>

                <td class="footer-left">
                    CIN: U72900PN2017PTC169478
                </td>

                <td class="footer-right">
                    RH24, Lake Paradise, Opp. CRPF, Talegaon Dabhade,
                    Talegaon, Pune - 410507, MH<br>
                    Ph: +91-9881124454
                </td>

            </tr>

        </table>

    </div>

</body>
</html>