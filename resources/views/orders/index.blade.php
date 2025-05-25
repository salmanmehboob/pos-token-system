@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>{{ $title }}</h2>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Order#</th>
                <th>Employee</th>
                <th>Sub Total</th>
                <th>Discount</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>
                        {{ $order->employee->first_name ?? 'Counter' }} {{ $order->employee->last_name ?? '' }}
                    </td>

                    <td>{{ number_format($order->sub_total, 2) }}</td>
                    <td>{{ number_format($order->discount, 2) }}</td>
                    <td>{{ number_format($order->total, 2) }}</td>
                    <td>
                    <span class="badge bg-success text-dark">
                        {{ ucfirst($order->status) }}
                    </span>
                    </td>
                    <td>{{ $order->created_at->format('j F Y h:i A') }}</td>
                    <td>
                        <a href="#" onclick="openPrintWindow({{ $order->id }})" style="border:none; background-color:white;">
                            <i class="fas fa-print fa-2x"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No Orders Found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

@endsection

@push('js')
    <script>
        function openPrintWindow(orderId) {
            const printWindow = window.open(`/invoice/${orderId}/print`, '_blank', 'width=400,height=600');
            if (printWindow) {
                printWindow.focus();
            }
        }
    </script>
@endpush

