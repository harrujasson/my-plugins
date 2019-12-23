<link href="<?=PRD_PLUGIN_URL_ADMIN?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?=PRD_PLUGIN_URL_ADMIN?>css/style.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<link rel="stylesheet" type="text/css" href="<?= PRD_PLUGIN_URL  ?>/admin/datatable/jquery.dataTables.css">
<script type="text/javascript" src="<?= PRD_PLUGIN_URL  ?>/admin/datatable/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="<?= PRD_PLUGIN_URL  ?>/admin/datatable/jquery.dataTables.js"></script>
<!-- Bootstrap core CSS -->

<div class="wrap">
    <div class="container" >
        <h2>Canned List</h2>   
        
        <div class="row mb-3">
            <div class="col-sm-12">
                <div class="col-sm-6">
                    <a href="<?= admin_url('admin.php?page=mwpl_ticket_canned_new')?>" class="btn btn-primary">Add new</a>
                </div>
            </div>
        </div>
        
                
        <div class="row">
            <div class="col-sm-12">
                <table id="reportList" class='ticket-users' cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Action</th>
                    
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function confirmdel(id){
    var x =confirm("Are you sure you want to delete?");
    if(x == true){
        window.location.href = "<?= admin_url('admin.php?page=mwpl_ticket_canned_delete&id=')?>"+id;
    }
    
}
$(document).ready(function() {
    var table = $("#reportList").DataTable({ 
            "bDestroy": true,   
            "responsive": true,
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "POST",
            "sAjaxSource": '<?= site_url("wp-admin/admin-ajax.php") ?>',
            "fnServerParams": function ( aoData ) {
                aoData.push( { "name": "action", "value": "cannedmanage" } );
            },
            "pageLength": 50,
            "order": [[ 0, "desc" ]],  
            "columnDefs": [
                { "orderable": false, "targets": [2] }
              ],

        
             "language": {
                "emptyTable":"Record not found",
                "search": '',
                "searchPlaceholder": 'Search..',  
            },
            "scrollX": true,
            
        }); 
 });
</script>
<script type="text/javascript" src="<?=PRD_PLUGIN_URL_ADMIN?>js/bootstrap.min.js"></script>

