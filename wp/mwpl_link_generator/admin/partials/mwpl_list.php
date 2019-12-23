<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<div class="wrap">
    <div class="container" >
        <h2>Manage</h2>
        <h4>Short code: [mwpl_link_gen]</h4>
        <p>Past the code where you want to display these links.</p>
        
        
        <div class="row">
            <div class="col-lg-12 m-b-20 m-t-20">
                <?php if(isset($_GET['status']) && $_GET['status']  == "1"): ?>
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&#120;</a>
                        <strong>Success!</strong> Record has been deleted.
                    </div>
                <?php elseif(isset($_GET['status']) && $_GET['status']  == "3"): ?>
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&#120;</a>
                        <strong>Success!</strong> Record has been inserted.
                    </div>
                <?php elseif(isset($_GET['status']) && $_GET['status']  == "2"): ?>
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&#120;</a>
                        <strong>Success!</strong> Record has been updated.
                    </div>
                <?php elseif(isset($_GET['status']) && $_GET['status']  == "error"): ?>
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&#120;</a>
                        <strong>Error!</strong> Something went wrong.Please try after some time.
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <table id="myTable" class='widefat datata'>
            <thead>
                <tr>                               
                    <th>Page</th>
                    <th>Total Links</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if(!empty($record)): ?>
            <?php foreach($record as $p): 
                    $total = $this->total_links($p->ID);
                ?>
            
                <tr>
                    <td> <?php if($p->post_title!=""){echo $p->post_title; }else{echo "(no title)";} ?></td>
                    <td><?=$total?></td>
                    <td>
                        
                        <?php if($total > 0): ?>
                            <a href='<?=admin_url('admin.php?page=mwpl_link_generation_edit&page_id='.$p->ID)?>'>Edit</a>&nbsp;&nbsp;  
                        <?php else: ?>
                            <a href='<?=admin_url('admin.php?page=mwpl_link_generation_new&page_id='.$p->ID)?>'>New</a>&nbsp;&nbsp; 
                        <?php endif; ?>
                    </td>
                </tr>
                
            
            <?php endforeach; ?>
                <tr>
                    <td>All Pages</td>
                    <td><?php $total = $this->total_links(0); echo $total; ?></td>
                    <td>                        
                        <?php if($total > 0): ?>
                            <a href='<?=admin_url('admin.php?page=mwpl_link_generation_edit&page_id=0')?>'>Edit</a>&nbsp;&nbsp; 
                            <?php else: ?>
                            <a href='<?=admin_url('admin.php?page=mwpl_link_generation_new&page_id=0')?>'>New</a>&nbsp;&nbsp;    
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
            <?php else: ?>
            <tbody>
            <tr>
                <td colspan="5" class="no_record_found">No record found!</td>
            </tr>
            </tbody>
            <?php endif; ?>
        </table>
    </div>
</div>
<script type="text/javascript">
$(document).ready( function () {
    $('#myTable').DataTable({
        "pageLength": 50
    });
} );
</script>