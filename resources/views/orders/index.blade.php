@extends('layouts.app')

@section('content')

<div class="container">
    <h2>{{ $title }}</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order#</th>
                <th>No Of Items</th>
                <th>Sub Total</th>
                <th>Discount</th>
                <th>Total </th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)


            @foreach ($order->items as $item)
            <tr>
                <td>{{ $order->id }}</td>

                <td>{{ $item->quantity}}</td>

                <td>{{ $order->sub_total }}</td>
                <td>{{ $order->discount }}</td>
                <td>{{ $order->total }}</td>
                <td>
                    <span class="badge bg-success text-dark">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>

                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('j F Y') }}</td>

                <td>

                    <a href="#" onclick="openPrintWindow({{ $order->id }})"
                        style="border:none; background-color:white;">
                        <i class="fas fa-print fa-2x"></i>
                    </a>


                </td>
            </tr>
            @endforeach




            @empty
            <tr>
                <td colspan="6" class="text-center">No Orders Found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

@push('js')

<script>
function openPrintWindow(orderId) {
    const printWindow = window.open(`/invoice/${orderId}`, '_blank', 'width=400,height=600');

    // Optional: bring focus to the print tab
    if (printWindow) {
        printWindow.focus();
    }
}
</script>


@endpush