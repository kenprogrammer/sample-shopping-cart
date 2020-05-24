@extends('frontend.layouts.master')
@section('content')
<div class="container">
    <h2>Shopping cart</h2>
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $cart_total=0;
            @endphp
            @foreach($cart_items as $cart_item)
            @php
                $cart_total+=$cart_item->subtotal;
            @endphp
            <tr>
                <td>{{ $cart_item->product_name }}</td>
                <td>{{ number_format($cart_item->unit_price,2) }}</td>
                <td>{{ $cart_item->quantity }}</td>
                <td>{{ number_format($cart_item->subtotal,2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tr>
            <td></td>
            <td></td>
            <td><b>Cart Total</b></td>
            <td><b>{{ number_format($cart_total,2) }}</b></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><a href="/checkout" class="btn btn-success" role="button">Checkout</a></td>
        </tr>    
    </table>
</div>
@endsection