<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Document</title>
    <link href="{{ asset('assets/css/sb-admin-2.min.css')  }}" rel="stylesheet">
    <style>
    body {
        width: 300px;
        font-size: 12px;
        font-family: monospace;
        margin: 0 auto;
        padding: 10px;
    }



    .text-center {
        text-align: center;
    }

    .border-top,
    .border-bottom {
        border-top: 1px dashed #000;
        border-bottom: 1px dashed #000;
        margin: 4px 0;
    }

    table {
        width: 100%;
    }

    td,
    th {
        padding: 2px 0;
    }

    .fw-bold {
        font-weight: bold;
    }

    .text-end {
        text-align: end;
    }
    </style>

</head>

<body>


    <div class="text-center fw-bold">
        Appflex Technology
    </div>
    <div class="text-center">
        Al-Sadiq Plaza Old Post Office Road ,<br>
        near leopards courier, Mingora Swat.<br>
        PHONE : +92 332 9282424<br>
    </div>

    <div class="text-center fw-bold mt-2">
        Retail Invoice
    </div>




    <div class="mt-2">
        Date : {{$order->created_at }}<br>
        Bill No: <b> {{$order->id }}</b><br>
    </div>

    <div class="border-top border-bottom mt-2 mb-2">
        <table>
            <thead>
                <tr>
                    <th style="width: 50%;" class="text-start">Item</th>
                    <th style="width: 50%;" class="text-start">Qty</th>
                    <th style="width: 50%;" class="text-start">Amt</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)


                <tr>
                    <td>{{$item->product->name}}</td>
                    <td>{{$item->quantity}}</td>
                    <td class="text-end">{{$item->subtotal}}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div class="fw-bold border-top border-bottom mt-2 mb-2">
        <table>
            <tr>
                <td style="width:80% ;">SUB TOTAL</td>
                <td style="width: 50%;" class="text-end">{{$order->sub_total}}</td>
            </tr>
        </table>
    </div>
    <div class="fw-bold border-top border-bottom mt-2 mb-2">

        <table>
            <tr>
                <td style="width: 80%;">Discount</td>
                <td class="text-end" colspan="2">{{$order->discount}}</td>
            </tr>

        </table>
    </div>
    <div class="fw-bold border-top border-bottom mt-2 mb-2">

        <table>
            <tr>
                <td style="width: 80%;">TOTAL</td>
                <td class="text-end" colspan="2">{{$order->total}}</td>
            </tr>

        </table>
    </div>




    <script>
    window.onload = function() {
        window.print();

        // This will trigger after user prints or cancels
        window.onafterprint = function() {
            // Check if the current URL matches the print invoice route pattern
            const urlPattern = /\/invoice\/\d+\/print$/;

            if (urlPattern.test(window.location.href)) {
                // Redirect to POS index route after print dialog is closed
                window.location.href = "{{ route('sales.pos') }}";
            }
        };
    };
    </script>




</body>

</html>