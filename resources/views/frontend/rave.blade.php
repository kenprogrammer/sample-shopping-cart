@php
$array = array(array('metaname' => 'color', 'metavalue' => 'blue'),
array('metaname' => 'size', 'metavalue' => 'big'));
@endphp

@extends('frontend.layouts.master')
@section('content')
<div class="container">
    <div class="col-sm-9">
        <p>You'll be redirected to a 3rd party website to complete the payment</p>
    </div>
    <div class="col-sm-3">    
        <h5>Pay with Rave (Powered by Flutterwave)</h5>
        <form method="POST" action="{{ route('pay') }}" id="paymentForm">
            {{ csrf_field() }}
            <input type="hidden" name="amount" value="{{ $order_total }}" /> <!-- Replace the value with your transaction amount -->
            <input type="hidden" name="payment_method" value="both" /> <!-- Can be card, account, both -->
            <input type="hidden" name="description" value="Customer Order Payment" />
            <!-- Replace the value with your transaction description -->
            <input type="hidden" name="country" value="KE" /> <!-- Replace the value with your transaction country -->
            <input type="hidden" name="currency" value="KES" /> <!-- Replace the value with your transaction currency -->
            <input type="hidden" name="email" value="{{ $email }}" /> <!-- Replace the value with your customer email -->
            <input type="hidden" name="firstname" value="{{ $first_name }}" /> <!-- Replace the value with your customer firstname -->
            <input type="hidden" name="lastname" value="{{ $last_name }}" /> <!-- Replace the value with your customer lastname -->
            <input type="hidden" name="metadata" value="{{ json_encode($array) }}">
            <!-- Meta data that might be needed to be passed to the Rave Payment Gateway -->
            <input type="hidden" name="phonenumber" value="{{ $phone_no }}" />
    
            <div class="form-group">
                <input class="form-control" type="submit" value="Proceed with Rave" />
            </div>
        </form>
    </div>
</div>
@endsection