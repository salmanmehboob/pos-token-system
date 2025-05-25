<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=300, initial-scale=1.0">
    <title>Print Invoice</title>
    <style>
        body {
            width: 300px;
            font-size: 10px;
            font-family: "Lucida Console", "Courier New", monospace;
            margin: 0 auto;
            padding: 5px;
        }

        .text-center {
            text-align: center;
        }

        .text-start {
            text-align: left;
        }

        .text-end {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        .border-top,
        .border-bottom {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            padding: 2px 0;
            font-size: 10px;
        }

        .mt-2 {
            margin-top: 6px;
        }

        .mb-2 {
            margin-bottom: 6px;
        }

        .footer-note {
            margin-top: 10px;
            font-size: 9px;
            text-align: left;
        }

        .footer-dev {
            font-size: 8px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="text-center fw-bold">
    {{ $setting->comp_name }}
</div>
<div class="text-center">
    {{ $setting->comp_address }}<br>
    Phone: {{ $setting->comp_phone }}<br>
    Mobile: {{ $setting->comp_mobile }}
</div>

<div class="text-center fw-bold mt-2">
    Retail Invoice
</div>

<div class="mt-2">
    <b>Date:</b> {{ $order->created_at->format('d-m-Y h:i A') }}<br>
    <b>Bill No:</b> {{ $order->id }}<br>
    <b>Employee:</b> {{ $order->employee->first_name }} {{ $order->employee->last_name }}<br>
</div>


<div class="border-top border-bottom mt-2 mb-2">
    <table>
        <thead>
        <tr>
            <th class="text-start">Item</th>
            <th class="text-start">Qty</th>
            <th class="text-end">Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td class="text-end">{{ number_format($item->subtotal, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="fw-bold border-top border-bottom mt-2 mb-2">
    <table>
        <tr>
            <td class="text-start">SUB TOTAL</td>
            <td class="text-end">{{ number_format($order->sub_total, 2) }}</td>
        </tr>
        <tr>
            <td class="text-start">DISCOUNT</td>
            <td class="text-end">{{ number_format($order->discount, 2) }}</td>
        </tr>
        <tr>
            <td class="text-start">TOTAL</td>
            <td class="text-end">{{ number_format($order->total, 2) }}</td>
        </tr>
    </table>
</div>

<!-- Footer notes -->

<small class="footer-dev">
    Software developed by AppFlex Technology +92332-928-2424
</small>

<script>
    window.onload = function () {
        window.print();

        window.onafterprint = function () {
            const urlPattern = /\/invoice\/\d+\/print$/;
            if (urlPattern.test(window.location.href)) {
                window.location.href = "{{ route('sales.pos') }}";
            }
        };
    };
</script>

</body>
</html>
