
<?php $this->load_view_admin('customer/view/sidebar.php'); ?>


<div class="col-md-9">
    
<link rel="stylesheet" type="text/css" href="<?= PRD_PLUGIN_URL  ?>/admin/datatable/jquery.dataTables.css">
<script type="text/javascript" src="<?= PRD_PLUGIN_URL  ?>/admin/datatable/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="<?= PRD_PLUGIN_URL  ?>/admin/datatable/jquery.dataTables.js"></script>

    <div class="inner viewPageBox pt-0 pl-md-4">
        <div class="row">
            <div class="col-12">
                <div id="page-heading">
                    <ol class="breadcrumb">
                        <li><a href="<?=site_url('customer-account')?>">Dashboard</a></li>
                        <li class="active">My order/tours</li>
                    </ol>

                    <h1>My order</h1>
                    <?php $this->load_view_admin('customer/view/notifications.php'); ?>
                </div>
            </div>
        </div>
        <div class="table mt-3">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <label for="search_status">Search with Order ID#</label>                        
                    <input type="text" class="form-control dataTableSrch" id="search_status" placeholder="Enter Order ID">
                </div>
            </div>  
            <table id="reportList" class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>ID</th>                        
                        <th>Tour</th>
                        <th>Transaction</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
   
        var table = $("#reportList").DataTable({ 
            "bDestroy": true,   
            "responsive": true,
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "POST",
            "sAjaxSource": '<?= site_url("wp-admin/admin-ajax.php") ?>',
            "fnServerParams": function ( aoData ) {
                aoData.push( { "name": "action", "value": "tourordermanagecustomer" } );
                aoData.push( { "name": "order_id", "value": $("#search_status").val() } );               
            },
            "pageLength": 50,
            "order": [[ 0, "desc" ]],  
            "columnDefs": [
                { "orderable": false, "targets": [1,2,3] }
              ],

        
             "language": {
                "emptyTable":"Record not found",
                "search": '',
                "searchPlaceholder": 'Search..',  
            },
            "scrollX": true,
            "bFilter": false,
            "bInfo": false
        }); 
        
        $('#search_status').on('keyup', function(){
            table.draw();
        });
        
    
 });
</script>



