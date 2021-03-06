<link href="<?=PRD_PLUGIN_URL_ADMIN?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?=PRD_PLUGIN_URL_ADMIN?>css/style.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<link rel="stylesheet" type="text/css" href="<?= PRD_PLUGIN_URL  ?>/admin/datatable/jquery.dataTables.css">
<script type="text/javascript" src="<?= PRD_PLUGIN_URL  ?>/admin/datatable/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="<?= PRD_PLUGIN_URL  ?>/admin/datatable/jquery.dataTables.js"></script>
<!-- Bootstrap core CSS -->

<div class="wrap">
    <div class="container" >
        <h2>Tickets</h2>   
        
        <div class="row mb-3">
            <div class="col-sm-12">
                <div class="col-sm-6">
                    <input type="text" id="search_email" class="form-control" placeholder="Search with email">
                </div>
                <div class="col-sm-6">
                    <input type="text" id="search_last_name" class="form-control" placeholder="Search with last name">
                </div>
                
            </div>
           
        </div>
        
                
        <div class="row">
            <div class="col-sm-12">
                <table id="reportList" class='ticket-users' cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Last Name</th>  
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Category</th>
                            <th>Status</th>                
                            <th>Re-Open</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                </table>
            </div>
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
                aoData.push( { "name": "action", "value": "ticketmanagehistory" } );
                aoData.push( { "name": "email_search", "value": $("#search_email").val() } );
                aoData.push( { "name": "last_name", "value": $("#search_last_name").val() } );
            },
            "pageLength": 50,
            "order": [[ 5, "asc" ],[ 0, "desc" ]],  
            "columnDefs": [
                { "orderable": false, "targets": [1,4,6,7] }
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
        
        $('#search_email').on('keyup', function(){
            table.draw();
        });
        $('#search_last_name').on('keyup', function(){
            table.draw();
        });
    
 });
</script>
<script type="text/javascript" src="<?=PRD_PLUGIN_URL_ADMIN?>js/bootstrap.min.js"></script>

