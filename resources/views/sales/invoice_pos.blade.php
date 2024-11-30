<!DOCTYPE html>
<html lang="en" dir="{{ $languageDirection }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('/assets/js/vue.js') }}"></script>

    <title>Invoice #{{ $sale['Ref'] }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            font-size: 12px;
            direction: {{ $languageDirection }};
        }
        .container {
            width: 80mm;
            margin: 0 auto;
            padding: 0;
        }
        .header, .invoice-details, .summary {
            margin-bottom: 5mm;
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 2mm;
        }
        .header img {
            max-width: 100%;
            height: auto;
        }
        .header h1 {
            margin: 0;
            font-size: 14px;
        }
        .invoice-details p {
            margin: 2mm 0;
            font-size: 11px;
            text-align: {{ $languageDirection == 'rtl' ? 'right' : 'left' }};
        }
        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5mm;
            font-size: 11px;
        }
        .item-table th, .item-table td {
            padding: 2mm;
            text-align: {{ $languageDirection == 'rtl' ? 'right' : 'left' }};
            border-bottom: 1px solid #000;
        }
        .item-table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .summary table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        .summary th, .summary td {
            padding: 2mm;
            text-align: {{ $languageDirection == 'rtl' ? 'right' : 'left' }};
            border-bottom: 1px solid #000;
        }
        .summary th {
            font-weight: bold;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 10mm;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .hidden-print {
                display: none;
            }
            .container {
                width: 100%;
                margin: 0 auto;
                padding: 0;
                page-break-inside: avoid;
            }
            .header, .invoice-details, .summary {
                margin-bottom: 3mm;
            }
            .item-table th, .item-table td {
                font-size: 10px;
                border-bottom: 1px solid #000;
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
            <th>{{ __('translate.Description') }}</th>
            <th>{{ __('translate.Qty') }}</th>
            <th>{{ __('translate.Price') }}</th>
            <th>{{ __('translate.Total') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($details as $detail)
            <tr>
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
