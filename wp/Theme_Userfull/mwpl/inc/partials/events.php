<?php $events = $this->filterPostGetEventHome(3);?>
<?php if(!empty($events)): ?>
    <div class="col-lg-12 col-xs-12 back-clor sec-pdng">
                        <div class="col-lg-12 text-center">
                            <div class="durant-event">
                                <h2>UPCOMING EVENTS</h2>
                                <p>We host a variety of events throughout the year, both indoors and out - why noy come & join us?</p>
                            </div>
                        </div>
                   <?php foreach($events as $event): ?>
                        <div class="col-md-4 col-sm-4 col-lg-4 col-xs-12 mt-10 text-center">
                                <div class="fest">
                                        <?php $image =  $this->getImageMWPL($event->ID,'thumb'); ?>
                                        <?php if($image !=""): ?>
                                        <img class="img-responsive cmnMrgn" src="<?=$image?>">
                                        <?php endif; ?>
                                        <p class="cmnMrgn"><?=$event->post_title?> - <?= $this->check_event_date_same($this->getmetinfo( $event->ID, '_EventStartDate'),$this->getmetinfo( $event->ID, '_EventEndDate')); ?> </p>
                                        <p><a href="<?= get_permalink($event->ID)?>">learn more</a></p>
                                </div>
                        </div>
                    <?php endforeach; ?>
    </div>
<?php endif; ?>