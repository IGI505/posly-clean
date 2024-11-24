<?php
$languageDirection = isset($_COOKIE['language']) && $_COOKIE['language'] == 'ar' ? 'rtl' : 'ltr';
?>

    <!DOCTYPE html>
<html lang="en" dir="{{ $languageDirection }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{asset('/assets/js/vue.js')}}"></script>

    <title>Invoice #{{ $sale['Ref'] }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            font-size: 12px; /* Slightly larger font for readability */
            direction: {{ $languageDirection }};
        }
        .container {
            width: 80mm; /* Adjust to match your POS paper width */
            margin: 0 auto;
            padding: 5mm;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .header, .invoice-details, .summary {
            margin-bottom: 5mm;
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 2mm;
        }
        .header img {
            max-width: 60mm; /* Adjust logo size */
        }
        .header h1 {
            margin: 0;
            font-size: 16px; /* Larger font for the title */
        }
        .invoice-details p {
            margin: 4px 0;
            font-size: 12px; /* Larger font for invoice details */
            text-align: {{ $languageDirection == 'rtl' ? 'right' : 'left' }};
        }
        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5mm;
        }
        .item-table th, .item-table td {
            padding: 3mm;
            text-align: {{ $languageDirection == 'rtl' ? 'right' : 'left' }};
            border-bottom: 1px solid #ddd;
            font-size: 12px; /* Larger font for item table */
        }
        .item-table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .summary table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px; /* Larger font for summary table */
        }
        .summary th, .summary td {
            padding: 3mm;
            text-align: {{ $languageDirection == 'rtl' ? 'right' : 'left' }};
            border-bottom: 1px solid #ddd;
        }
        .summary th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            font-size: 10px; /* Slightly larger font for footer */
            margin-top: 10mm;
        }
        .btn {
            padding: 5px 10px;
            font-size: 12px;
            color: #ffffff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .hidden-print {
            display: block;
            margin-bottom: 10mm;
        }

        @media print {
            .hidden-print {
                display: none;
            }
            body {
                margin: 0;
                padding: 0;
                width: 80mm;
            }
            .container {
                width: 80mm;
                padding: 0;
            }
            .item-table th, .item-table td {
                font-size: 10px;
            }
            .footer {
                font-size: 8px;
            }
        }
    </style>
</head>
<body>
<div id="in_pos">
    <!-- Print Button -->
    <div class="hidden-print">
        <a @click="print_pos" class="btn">{{ __('translate.print') }}</a>
        <br>
    </div>
</div>
<div class="container" id="invoice-POS">
    <!-- Header Section -->
    <div class="header">
        <img src="{{ asset('images/alshara-png.png') }}" alt="Company Logo">
        <h1>{{ $setting['CompanyName'] }}</h1>
    </div>

    <!-- Invoice Details -->
    <div class="invoice-details">
        <p dir="{{ $languageDirection }}">
            <span>{{ __('translate.Invoice') }} # : {{ $sale['Ref'] }}<br></span>
            <span>{{ __('translate.time') }} : {{ $sale['time'] }}<br></span>
            <span>{{ __('translate.date') }} : {{ $sale['date'] }}<br></span>
            <span v-show="pos_settings.show_phone">{{ __('translate.Phone') }} : {{ $setting['CompanyPhone'] }}<br></span>
            <span v-show="pos_settings.show_customer">{{ __('translate.Customer') }} : {{ $sale['client_name'] }}<br></span>
            <span v-show="pos_settings.show_Warehouse">{{ __('translate.warehouse') }} : {{ $sale['warehouse_name'] }}<br></span>
        </p>
    </div>

    <!-- Itemized List -->
    <table class="item-table">
        <thead>
        <tr>
{{--            <th>{{ __('translate.Code') }}</th>--}}
            <th>{{ __('translate.Description') }}</th>
            <th>{{ __('translate.Qty') }}</th>
            <th>{{ __('translate.Price') }}</th>
            <th>{{ __('translate.Total') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($details as $detail)
            <tr>
{{--                <td>{{ $detail['code'] }}</td>--}}
                <td>{{ $detail['name'] }}</td>
                <td>{{ $detail['quantity'] }}</td>
                <td>{{ $detail['price'] }}</td>
                <td>{{ $detail['total'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Summary -->
    <div class="summary">
        <table>
            <tbody>
            <tr>
                <th>{{ __('translate.Subtotal') }}</th>
                <td>{{ $sale['GrandTotal'] }}</td>
            </tr>
            <tr>
                <th>{{ __('translate.Discount') }}</th>
                <td>{{ $sale['discount'] }}</td>
            </tr>
            <tr>
                <th>{{ __('translate.Shipping') }}</th>
                <td>{{ $sale['shipping'] }}</td>
            </tr>
            <tr>
                <th>{{ __('translate.Tax') }} ({{ $sale['tax_rate'] }}%)</th>
                <td>{{ $sale['taxe'] }}</td>
            </tr>
{{--            <tr>--}}
{{--                <th>{{ __('translate.Grand_Total') }}</th>--}}
{{--                <td>{{ $sale['GrandTotal'] }}</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <th>{{ __('translate.Paid_Amount') }}</th>--}}
{{--                <td>{{ $sale['paid_amount'] }}</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <th>{{ __('translate.Due_Amount') }}</th>--}}
{{--                <td>{{ $sale['due'] }}</td>--}}
{{--            </tr>--}}
            </tbody>
        </table>
    </div>

    <!-- Payments -->
    <div class="summary">
        <h3>{{ __('translate.Payments') }}</h3>
        <table>
            <thead>
            <tr>
                <th>{{ __('translate.Method') }}</th>
                <th>{{ __('translate.Amount') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment['Reglement'] }}</td>
                    <td>{{ $payment['montant'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <strong>{{ __('translate.Thank_You_For_Shopping_With_Us_Please_Come_Again') }}</strong>
    </div>
</div>

<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/js/vue.min.js') }}"></script>
<script>
    new Vue({
        el: '#in_pos',
        methods: {
            print_pos() {
                var divContents = document.getElementById("invoice-POS").innerHTML;
                var a = window.open("", "", "height=500, width=500");
                // a.document.write('<link rel="stylesheet" href="/assets/styles/vendor/pos_print.css"><html>');
                a.document.write("<body>");
                a.document.write(divContents);
                a.document.write("</body></html>");
                a.document.close();
                setTimeout(() => {
                    a.print();
                }, 1000);
            }
        }
    });
</script>
</body>
</html>
