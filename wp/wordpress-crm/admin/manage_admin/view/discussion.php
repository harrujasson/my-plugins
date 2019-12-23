<link href="<?=MWPL_PARTIALS?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?=MWPL_PARTIALS?>css/style.css" rel="stylesheet">
<link rel="stylesheet" href="<?=PRD_PLUGIN_URL_ADMIN?>css/jquery-ui.css" integrity="sha256-p6xU9YulB7E2Ic62/PX+h59ayb3PBJ0WFTEQxq0EjHw=" crossorigin="anonymous" />
<script src="<?=PRD_PLUGIN_URL_ADMIN?>js/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
<div class="wrap">

    <div class="container">
        <h2>Tickets - Discussion</h2>   
    	<div class="row mt-3">
            <div class="col-md-6">
            	<div class="your-tickets-reply">      
                  
                  <?php if($discussion){ ?>
                    <h1 class="h3 mb-3 font-weight-normal text-center">Reply </h1>
                    <?php foreach($discussion as $chat): ?>
                        <div class="ticket-system-content text-left">
                          <table class="ticket-users reply-tickets">

                              <tbody>
                                  <?php if($chat->private_ticket): ?>
                                  <tr>
                                      <td>&nbsp;</td>
                                      <td><h4 class="text-danger">Private Note</h4></td>
                                  </tr>
                                  <?php endif; ?>
                                  <tr>
                                      <td>Date</td>
                                      <td><?=date('M d Y h:i A', strtotime($chat->created_at))?></td>
                                  </tr>
                                  <tr>
                                      <td>Posted By:</td>
                                      <td class="ticket-open"><?php if($chat->from_id == $call->user_id()) { echo "You";}else{echo  $this->get_user_field($chat->from_id).'('.$this->get_user_role($chat->from_id).')';} ?></td>                                
                                  </tr>

                                  <tr>
                                      <td>Reply</td>
                                      <td><?=$chat->comment?></td>
                                  </tr>
                                  <?php if($chat->attachment!=""): ?>
                                  <tr>
                                      <td>Attachment</td>
                                      <td><?php $call->get_upload_dir_path(); ?> <a href="<?=$call->get_upload_dir_path().$chat->attachment?>" download="">Download</a></td>
                                  </tr>
                                  <?php endif; ?>
                              </tbody>

                          </table>          
                        </div> 
                    <?php endforeach; ?>
                  <?php } ?>
                     <?php if($r->status == 0): ?>
                        <div class="ticket-reply-content">
                              <form class="form-ticketreply" enctype="multipart/form-data" method="post">
                                  <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="description" name="comment" class="form-control"></textarea>
                                  </div>
                                  <div class="form-group">                                                         
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="private_note">Private Note
                                        </label>
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label for="description">Attachments</label>
                                      <input type="file" name="myfile" id="media" />
                                  </div>

                                  <div class="text-right">
                                      <input type="hidden" name="ticket_create_authorized_admin" >
                                      <input type="hidden" name="ticket" value="<?= $r->id ?>">
                                      <button class="btn btn-primary" type="submit">SUBMIT</button> &nbsp;
                                      <a href="<?=admin_url('admin.php?page=mwpl_ticket')?>" class="btn btn-primary">BACK</a>
                                  </div>

                              </form>

                        </div> 
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-6">
            	<div class="your-tickets-reply">      
                  <h1 class="h3 mb-3 font-weight-normal text-right">Ticket <?=$r->id?></h1>
                  <div class="ticket-system-content text-left">
                    <table class="ticket-users reply-tickets">                       
                        <tbody>
                            <tr>
                                <td>Start Date</td>
                                <td><?=date('M d Y h:i A', strtotime($r->created_at))?></td>
                            </tr>
                            
                            <tr>
                                <td>Subject</td>
                                <td><?=$r->subject?></td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td><?=$r->category?></td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td><?=$r->description?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td class="ticket-open">
                                    <?php if($r->status) {echo "Closed";}else{echo "Open";} ?>
                                </td>                                
                            </tr>
                            
                            <tr>
                                <td>Attachment</td>
                                <td>
                                    <?php if($r->attachment!=""): ?>
                                        <a href="<?=$call->get_upload_dir_path().$r->attachment?>" download="">Download</a>
                                    <?php else: ?>
                                        No attachment.
                                    <?php endif; ?>
                                </td>
                            </tr>
                            
                        </tbody>                        
                    </table>          
                  </div>
                  <div class="ticket-reply-content">
                    <form class="form-ticketreply" enctype="multipart/form-data" method="post">
                        <div class="form-group">                                                         
                            <label for="description">Priority</label>
                            <select class="form-control" name="priority">
                                <option value="1" <?php if($r->priority == "1"){echo "selected";} ?> >Urgent</option>
                                <option value="2" <?php if($r->priority == "2"){echo "selected";} ?>>High</option>
                                <option value="3" <?php if($r->priority == "3"){echo "selected";} ?>>Normal</option>
                                <option value="4" <?php if($r->priority == "4"){echo "selected";} ?>> Low</option>
                                <option value="0" <?php if($r->priority == "0"){echo "selected";} ?>>Lowest</option>
                            </select>
                        </div>
                      <input type="hidden" name="ticket_priority_authorized_admin" >
                      <input type="hidden" name="ticket" value="<?= $r->id ?>">
                      <button class="btn btn-primary close-ticket btn-sm" type="submit">Change Priority</button>
                    </form>
                  </div>
                  <?php if($r->status == 0): ?>
                  <h1 class="h3 mb-3 font-weight-normal text-right">PROBLEM IS SOLVED</h1>
                  <form class="form-ticketreply" enctype="multipart/form-data" method="post">
                    <div class="text-right">
                        <input type="hidden" name="ticket_close_authorized_admin" >
                        <input type="hidden" name="ticket" value="<?= $r->id ?>">
                        <button class="btn btn-primary close-ticket" type="submit">CLOSE TICKET</button>
                    </div>     
                  </form>
                  <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
jQuery(document).ready(function($){
    $( "#description" ).autocomplete({
        source: function( request, response ) {
          $.ajax( {
            url: "<?= site_url("wp-admin/admin-ajax.php") ?>",
            dataType: "json",
            type:"post",
            data: {
              term: request.term,
              action:"cannedfetchlist",
            },
            success: function( data ) {
              response( data );
            }
          });
        },
        minLength: 2,
        select: function( event, ui ) {
          //log( "Selected: " + ui.item.value + " aka " + ui.item.id );
        }
    });
});
</script>
<script type="text/javascript" src="<?=PRD_PLUGIN_URL_ADMIN?>js/bootstrap.min.js"></script>