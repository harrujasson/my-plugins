
<link href="<?=PRD_PLUGIN_URL_ADMIN?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?=PRD_PLUGIN_URL_ADMIN?>css/style.css" rel="stylesheet">
<div class="wrap">

    <div class="container">
        <h2>Canned - Edit</h2>   
    	<div class="row mt-3">
            
            <div class="col-md-12">
            	<div class="your-tickets-reply">      
                  
                  
                  <div class="text-center">
                      <form class="form-ticketsubmit" enctype="multipart/form-data" method="post">
                          <h1 class="h3 mb-3 font-weight-normal">Edit - Canned </h1>
                            
                            <div class="ticket-system-content text-left">                             
                                
                                <div class="form-group">
                                    <label for="category">Title*</label>
                                    <input type="text" class="form-control" name="title" value="<?=$r->title?>" required="">
                                </div>                                
                            </div>
                          <input type="hidden" name="canned_edit" value="<?=$r->id?>" >
                            
                            <button class="btn btn-primary" type="submit" >Update</button> &nbsp;
                            <a href="<?= admin_url('admin.php?page=mwpl_ticket_canned') ?>" class="btn btn-primary">BACK</a>
                      </form>
                  </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript" src="<?=PRD_PLUGIN_URL_ADMIN?>js/bootstrap.min.js"></script>