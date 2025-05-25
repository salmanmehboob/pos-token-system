@extends('layouts.app')

@section('content')

<head>

</head>
<div class="container">
    <h2>{{ $title }}</h2>

    <form method="GET" action="{{ route('histories.index') }}" class="mb-4 row g-2">
        <div class="col-md-3">
            <select name="category_id" class="form-control select2">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="product_id" class="form-control select2">
                <option value="">All Products</option>
                @foreach($products as $product)
                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>
        <div class="col-md-2">
            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <table id="historyTable" class=" table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Category</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Stock Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($histories as $history)
            <tr>
                <td>{{ $history->id }}</td>
                <td>{{ $history->category->name ?? 'N/A' }}</td>
                <td>{{ $history->product->name ?? 'N/A' }}</td>
                <td>{{ $history->quantity }}</td>
                <td>{{ $history->is_stock ? 'In Stock' : 'Out of Stock' }}</td>
                <td>{{ $history->created_at }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No history found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>



@endsection