<?php if($isRecord): ?>
<link rel="stylesheet" href="<?=PRD_PUBLIC_URL?>assets/style.css" />
<div class="mwpl-main-scetion">
    <div class="mwpl_public_list_container">
    <?php if(!empty($list)): ?>
        <ul>
            <?php foreach ($list as $fld): ?>
                <li><?=$fld?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <?php if(!empty($group)): ?>
        <div class="mwpl_grouped">
            <?php for($i=0; $i<count($group); $i++){ ?>
                <div class="mwpl_grouped_container">
                    <span class="mwpl_grouped_label" ><?=$group[$i]['label']?>:</span>
                    <span class="mwpl_grouped_label"><strong><?=$group[$i]['value']?></strong></span>
                </div>
            <?php } ?>
        </div>
    <?php endif; ?>    
    </div>
</div>
<?php endif; ?> 