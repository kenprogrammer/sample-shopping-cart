@extends('frontend.layouts.master')
@section('content')
<div class="container">
    <h2>Checkout</h2>
    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @elseif (session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif
    <div id="row">
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
                <td><b>Order Total</b></td>
                <td><b>{{ number_format($cart_total,2) }}</b></td>
            </tr>
        </table>
    </div>
    <div id="row">
        <div class="col-sm-9">
        </div>
        <div class="col-sm-3">    
            <form name="checkout" method="post" action="/checkout">
                @csrf
                <div class="form-group">
                    <label>First Name:</label>
                    <input type="text" class="form-control" name="first_name" value="">
                </div>
                <div class="form-group">
                    <label>Last Name:</label>
                    <input type="text" class="form-control" name="last_name" value="">
                </div>
                <div class="form-group">
                    <label>Phone No:</label>
                    <input type="text" class="form-control" name="phone_no" value="">
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" class="form-control" name="email" value="">
                </div>  
                <label>Choose Payment Method:</label>
                <div class="radio">
                    <label><input type="radio" name="payment_method" required value="Rave Laravel" checked>Rave (Laravel Package)</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="payment_method" required value="Rave Standard">Rave (Standard)</label>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Place Order</button>
                </div>    
            </form>
        </div>
    </div>
</div>
@endsection