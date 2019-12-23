@extends('layouts.admin')
@section('header_extra')
@stop
@section('banner')
<div class="span-title">
    <h1>Page Settings</h1>
    <div class="page-map"><p>Admin &nbsp;/&nbsp; Orders Show </p></div>
</div>
@stop
@section('content')
<div class="main">
    <div class="section">
        <div class="section-title">
            <h2>Order#  {{$r->id}}</h2>            
            <hr class="center">
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="profile-sidebar">                 
                  <h5>{{$r->customer_name}}</h5>
                  <h6>{{$r->email}}</h6>
                  <p>{{$r->phone}}</p>
                  <p>{{$r->address}}</p>
                </div>
            </div>
            <div class="col-md-8">
              <div class="profile-content">
                  <h5>Order Details</h5>
                  <div class="span-experience">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="inner-experience">
                            <h6>Message</h6>
                              <p>{{$r->message}}</p>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="inner-experience">
                            <h6>Payment For</h6>
                              <p>{{$r->regarding_payment}}</p>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="inner-experience">
                            <h6>Transaction Detail</h6>                            
                            <p>Pay-ID: {{$r->payment_txn_id}}</p>
                            <p>Order-ID: {{$r->payment_order_id}}</p>
                            <p>Amount: {{$r->amount}}</p>
                            <p>Amount: {{$r->status}}</p>
                          </div>
                        </div>
                        
                      </div>
                  </div>

              </div>  
            </div>
        </div>
    </div>
</div>

@stop
@section('footer_scripts')
@stop
