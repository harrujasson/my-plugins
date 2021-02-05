
<link href="<?=PRD_PLUGIN_URL_ADMIN?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?=PRD_PLUGIN_URL_ADMIN?>css/style.css" rel="stylesheet">
<div class="wrap">

    <div class="container">
        <h2>Merge Ticket</h2>   
    	<div class="row mt-3">
            
            <div class="col-md-12">
            	<div class="your-tickets-reply">      
                  
                  
                  <div class="text-center">
                      <form class="form-ticketsubmit" enctype="multipart/form-data" method="post">
                          <h1 class="h3 mb-3 font-weight-normal">Merge Ticket </h1>
                            <p>Merge the ticket with other ticket</p>
                            
                            <div class="ticket-system-content text-left">                             
                                <div class="form-group">
                                    <label for="category">Please select customer*</label>
                                    <select class="form-control" id="users" name="user" >
                                        <option value="">--Choose--</option>
                                        <?php if(!empty($users_list)){ ?>
                                        <?php foreach($users_list as $user): ?>
                                            <option value="<?=$user->ID?>"><?=$user->display_name?></option>
                                        <?php endforeach; ?>
                                        <?php } ?>
                                    </select>
                                </div> 
                                <div class="form-group">
                                    <label for="category">Ticket*</label>
                                    <select class="form-control tickets" id="from_ticket" name="from_ticket" >
                                        <option value="">--Choose--</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="category">Merge To*</label>
                                    <select class="form-control tickets" id="to_ticket" name="to_ticket" >
                                        <option value="">--Choose--</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="ticket_merge_action" >
                            <button class="btn btn-primary" type="submit" >Merge</button> &nbsp;
                            <a href="<?= admin_url('admin.php?page=mwpl_ticket') ?>" class="btn btn-primary">BACK</a>
                      </form>
                  </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
jQuery(document).ready(function($){
    $("#users").change(function(){
       var options ='<option value="">--Choose--</option>';
       var $this = $(this);
       $.ajax({
           type:"post",
           dataType:"json",
           data:{
               action:"usersticket",
               id:$this.val()
           },
           url:'<?= admin_url('admin-ajax.php')?>',
           success:function(data){
               $(".tickets").html('');
            $.each(data, function(index) {
                options+='<option value="'+data[index].id+'">'+data[index].category+' - '+data[index].subject+' </option>';   
                console.log("ID "+data[index].id);
            });
            $(".tickets").append(options);
           }
       });
    });
    
    
});
</script>
<script type="text/javascript" src="<?=PRD_PLUGIN_URL_ADMIN?>js/bootstrap.min.js"></script>