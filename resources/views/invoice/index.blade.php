<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=300, initial-scale=1.0">
    <title>Print Invoice</title>
    <style>
        body {
            width: 300px; /* For 80mm printers */
            font-size: 11px;
            font-family: "Courier New", monospace;
            margin: 0 auto;
            padding: 8px 5px 5px 5px;
            font-weight: 600; /* Make all text bolder by default */
        }

        .text-center { text-align: center; }
        .text-start { text-align: left; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: 800; font-size: 13px; }
        .fw-xbold { font-weight: 900; font-size: 16px; letter-spacing: 0.5px; }

        .border-top { border-top: 1.5px dashed #000; }
        .border-bottom { border-bottom: 1.5px dashed #000; }
        .mt-3 { margin-top: 10px; }
        .mb-3 { margin-bottom: 10px; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            padding: 3px 0;
            font-size: 11px;
            word-wrap: break-word;
            font-weight: 700; /* Make table text bolder */
        }

        th {
            font-weight: 900;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        .footer-dev {
            font-size: 10px;
            text-align: center;
            margin-top: 14px;
            font-weight: 700;
        }

        @media print {
            body {
                width: 100%;
                margin: 0;
                padding: 10px;
                font-size: 11px;
                font-family: "Courier New", monospace;
                font-weight: 600;
            }

            table {
                width: 95% !important;
                table-layout: fixed;
                border-collapse: collapse;
            }

            th, td {
                padding: 3px 4px;
                font-size: 11px;
                word-wrap: break-word;
                overflow: hidden;
                text-overflow: ellipsis;
                box-sizing: border-box;
                font-weight: 700;
            }

            /* Optional: prevent last column from expanding */
            th:last-child, td:last-child {
                max-width: 40%;
            }

            /* Force printing to not clip content */
            @page {
                margin: 0;
                size: auto;
            }

            html, body {
                overflow: visible !important;
            }
        }

    </style>
</head>
<body>

<div class="text-center fw-xbold">
    {{ $setting->comp_name }}
</div>
<div class="text-center">
    {{ $setting->comp_address }}<br>
    Phone: {{ $setting->comp_phone }}<br>
    Mobile: {{ $setting->comp_mobile }}
</div>

<div class="mt-3">
    <b>Date:</b> {{ $order->created_at->format('d-m-Y h:i A') }}<br>
    <b>Bill No:</b> {{ $order->id }}<br>
    <b>Employee:</b> {{ $order->employee->first_name ?? 'Counter' }}
</div>

<div class="border-top border-bottom mt-3 mb-3">
    <table>
        <thead>
        <tr>
            <th class="text-start" style="width: 52%;">Item</th>
            <th class="text-center" style="width: 18%;">Qty</th>
            <th class="text-end" style="width: 30%;">Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-end">{{ number_format($item->subtotal) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="fw-bold border-top border-bottom mt-3 mb-3">
    <table>
        <tr>
            <td class="text-start">SUB TOTAL</td>
            <td class="text-end">{{ number_format($order->sub_total) }}</td>
        </tr>
        <tr>
            <td class="text-start">DISCOUNT</td>
            <td class="text-end">{{ number_format($order->discount) }}</td>
        </tr>
        <tr class="fw-xbold">
            <td class="text-start">TOTAL</td>
            <td class="text-end">{{ number_format($order->total) }}</td>
        </tr>
    </table>
</div>

<div class="footer-dev">
    Software by AppFlex Technology<br>
    +92 332 9282424
</div>

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
