@extends('layouts.admin')

@section('header_extra')
<!--Datatable--->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css"/>

<!-- Sweet Alert -->
<link href="{{ asset('public/front/js/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
@stop
@section('banner')
<div class="span-title">
    <h1>Page Settings</h1>
    <div class="page-map"><p>Admin &nbsp;/&nbsp; Orders </p></div>
</div>
@stop
@section('content')
<div class="main">
    <div class="section">
        <div class="section-title">
            <h2>Orders - Manage</h2>            
            <hr class="center">
        </div>
        <div class="row">
            <div class="col-md-12">               
                
                <div class="card-box table-responsive">                               
                    @include('widget/notifications')
                    <table id="datatable-inline" class="table table-striped table-bordered " style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>   
                                <th>Date</th>
                                <th>Email</th>                                
                                <th>TXN ID</th>
                                <th>Sale ID</th>                                
                                <th>Status</th>     
                                <th></th>
                            </tr>
                        </thead>                       
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('footer_scripts') 
<!--Datatable--->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    
<!-- Sweet-Alert  -->
<script src="{{ asset('public/front/js/sweet-alert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('public/front/js/jquery.sweet-alert2.init.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
       var table = $('#datatable-inline').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 25,
            ajax: '{!! route('admin.orders_showAjaxList') !!}',
            columns: [                
                { data: 'id', name: 'id' },  
                { data: 'date', name: 'date' },  
                { data: 'email', name: 'email' },                 
                { data: 'payment_txn_id', name: 'payment_txn_id' },
                { data: 'payment_order_id', name: 'payment_order_id' },
                { data: 'status', name: 'status'}, 
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
             order: [[0, 'desc']]
        });

    });
</script>
@stop
