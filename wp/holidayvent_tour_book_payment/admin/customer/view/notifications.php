<?php  
if($this->notice_front_get()): ?>
<div class="alert alert-<?=$this->notice_front_get()?> alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&#215;</button>
    <strong>Notification: </strong> <?= $this->notice_front_get('notice_text')?>
</div>
<?php $this->notice_front_falsh_remove(); ?>
<?php endif; ?>