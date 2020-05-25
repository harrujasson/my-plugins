<?php $this->load_view_admin('customer/view/sidebar.php'); ?>
<div class="col-md-9">
    <div class="inner viewPageBox pt-0">
        <div id="wrap">
            <div class="row">
                <div class="col-12">
                    <div id="page-heading">
                        <ol class="breadcrumb">
                            <li><a href="<?=site_url('customer-account')?>">Dashboard</a></li>
                            <li class="active">View</li>
                        </ol>
                        <h1>Order #<?=$r->id?></h1>
                        <?php $this->load_view_admin('customer/view/notifications.php'); ?>
                    </div>
                </div>
            </div>

           <div class="row">
                <div class="col-md-6 mt-3">
                    <div class="panel panel-info">
                        <div class="panel-body">
                            <h1>Order Detail</h1>
                            <div class="mb-4">
                                <div class="form-row">
                                    <h3><a target="_blank" href="<?=get_permalink($r->tour_id)?>"><?=$r->title?></a></h3>                                    
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="form-row mt-3">
                                    <label class="col-sm-4">Status:</label>
                                    <div class="col-sm-8">
                                        <?php if($r->status): ?>
                                        <span class="badge badge-success"><?= get_order_status($r->status)?></span>
                                        <?php else: ?>
                                        <span class="badge badge-danger">No status updated</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <div class="form-row mt-3">
                                    <label class="col-sm-4">Order Date:</label>
                                    <div class="col-sm-8">
                                        <?=date('F d, Y', strtotime($r->created_at))?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <label class="col-sm-4">Tour Date:</label>
                                    <div class="col-sm-8">

                                        <?=date('F d, Y', strtotime($r->date_of_tour))?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <label class="col-sm-4">Number of persons:</label>
                                    <div class="col-sm-8">
                                         <?=$r->number_of_person?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <label class="col-sm-4">Number of infant:</label>
                                    <div class="col-sm-8">
                                        <?=$r->number_of_infant?>
                                    </div>
                                </div>
                            </div>                            
                            <div class="form-group">
                                <div class="form-row">
                                    <label class="col-sm-4">Tour Price:</label>
                                    <div class="col-sm-8">
                                        <?= number_format($r->tour_price,2)?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <label class="col-sm-4">Sub Total:</label>
                                    <div class="col-sm-8">
                                        <?=number_format($r->sub_total,2)?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <label class="col-sm-4">GST(18%):</label>
                                    <div class="col-sm-8">
                                        <?=number_format($r->gst,2)?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-row">
                                    <label class="col-sm-4">Grand Total:</label>
                                    <div class="col-sm-8">
                                        <?=number_format($r->grand_total,2)?>
                                    </div>
                                </div>
                            </div>                           
                            <div class="mt-4">
                                <div class="form-row">
                                    <h5>Summery note:</h5>
                                    <div class="col-sm-12">
                                        <p class="tourDesc"> <?=$r->description?><p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="panel panel-info">

                        <div class="panel-body">                                           
                            <div class="form-group mt-4">
                                <h1>Transaction Details</h1>
                            </div>
                            <?php if(!empty($trans)): ?>
                            <div class="form-group">
                                <div class="form-row">
                                    <label class="col-sm-4">Transaction ID:</label>
                                    <div class="col-sm-8">
                                        <?php if($trans->transaction_id !=""): ?>
                                        <span class="badge badge-success"><?=$trans->transaction_id?></span>
                                        <?php else: ?>
                                        <span class="badge badge-danger">Pending</span>
                                        
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <label class="col-sm-4">Payment Mode:</label>
                                    <div class="col-sm-8">
                                        <?=$trans->method?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <label class="col-sm-4">Date of transaction:</label>
                                    <div class="col-sm-8">
                                        <?=date('F d Y h:i A', strtotime($trans->created_at));?>
                                    </div>
                                </div>
                            </div>

                            <?php else: ?>
                            <div class="form-group">
                                <div class="form-row">                                            
                                    <div class="col-sm-12">
                                        <h4 class="badge badge-danger">Still no transaction completed by customer</h4>                                        
                                    </div>
                                </div>                                
                            </div>
                            <div class="form-group">
                                <div class="form-row">                                            
                                    <div class="col-sm-12">
                                        <a href="<?=site_url('customer-account/payment/'.$r->id)?>" class="btn btn-success mb-4">Complete the payment</a>                                 
                                    </div>
                                </div>                                
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>


                <?php $post =  $call->get_post_by_id($r->tour_id);?>
                <?php if(!empty($post)): ?>
                <div class="col-md-12 mt-3 viewOrder-tourInfo">
                    <div class="panel panel-info">

                        <div class="panel-body">
                            <h1>Purchased Tour</h1>
                            <div class="inner tourHolderBox">
                                <div class="row">
                                    <div class="col-4 left">
                                        <a target="_blank" href="<?=get_permalink($post->ID)?>">
                                            <img src="<?=$call->getImageMWPL($post->ID);?>" class="w-100 tourImg">
                                        </a>
                                    </div>
                                    <div class="col-8">
                                        <h3 class="tourTitle">
                                            <a target="_blank" href="<?=get_permalink($post->ID)?>"><?=$post->post_title?></a>
                                        </h3>

                                        <p class="tourDuration"><?=$call->getmetinfo($post->ID,'cmsmasters_project_duration');?></p>                               
                                        <p class="tourDesc"><?=$post->post_excerpt?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

               
                <div class="col-md-12 mt-3">
                    <div class="panel panel-info">

                        <div class="panel-body"> 
                             <h1>Order Activity</h1>
                            <?php if(!empty($status)): ?>  
                             <div class="col-md-12">

                                 <div class="row orderstatus-container">
                                     <div class="col-12">
                                         <?php foreach($status as $st): ?>
                                         <div class="orderstatus done">
                                             <div class="orderstatus-check"></div>
                                             <div class="orderstatus-text">
                                                 <p class="statusHdng">
                                                     <?=get_order_status($st->status)?> <?=get_order_status($st->status)?> <span>By: <?= $call->get_user_field($st->updated_by); ?> <i>(<?=$call->get_user_role($st->updated_by)?>)</i></span>                           
                                                 </p>
                                                 <p class="statusDesc"><?=$st->comment?></p>
                                                 <p class="statusDescTime"><?=date('j d Y h:ia', strtotime($st->created_at))?></p>
                                             </div>
                                         </div>
                                         <?php endforeach; ?>


                                     </div>
                                 </div>

                             </div>

                            <?php else: ?>
                            <div class="form-group">
                                <div class="form-row">                                            
                                    <div class="col-sm-12">
                                        <h4 class="badge badge-danger">Yet, No status updated</h4>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>

        </div> <!-- container -->
    </div>
</div>