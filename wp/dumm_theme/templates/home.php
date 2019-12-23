<?php 
/*
 * Template Name: Home
 */
get_header();
?>
<div class="banner"></div>
<div class="arm-section">		
    <div class="col-md-8">
        <div class="durant">
                <h2>EXPERIENCE THE DURANT ARMS</h2>
                <h5>Village Country Inn . Guest House . Free House . Family run</h5>
                <img class="img-responsive" src="<?php bloginfo('template_url') ?>/img/arm-left-img.jpg">
                <img class="img-responsive" src="<?php bloginfo('template_url') ?>/img/Public bar.jpg">
                <p>Situated in the delightful conservation village of Ashprington,
                        three miles South of the market town of Totnes, The Durant Arms,
                        established in 1725, is a country inn and a family run free-house with
                        three en-suite guest bedrooms.</p>
                        <a href="#">learn more</a>
        </div>
    </div>

    <div class="col-md-4 padding-left-0 padding-right-0">
        <div class="arm-right-back"></div>
    </div>			
</div>

<div class="stay-section">
        <div class="container">
                <div class="row">
                        <div class="col-md-12 text-center">
                                <h2>YOUR STAY AT THE DURANT ARMS</h2>
                                <p>We offer 3 rooms that are located on the first floor & accessed by a private guest entrance. <br> All rooms are en-suite.</p>
                                <div class="book">
                                        <a href="#">learn more</a>
                                        <a href="https://via.eviivo.com/duranttq9">book now</a>
                                </div>
                        </div>
                </div>
        </div>
</div>


<div class="eat-and-drink">
        <div class="col-md-6 padding-left-0 padding-right-0">
                <div class="eat-sec">
                    <a href="<?= get_permalink(80) ?>">eat</a>
                </div>
        </div>
        <div class="col-md-6 padding-left-0  padding-right-0">
                <div class="drink-sec">
                        <a href="<?= get_permalink(90) ?>">drink</a>
                </div>
        </div>
</div>

 <?php $events = $cpt_obj->filterPostGetEventHome(3);?>

<?php if(!empty($events)): ?>
<div class="upcomming">
        <div class="container">
                <div class="row">
                        <div class="col-md-12 text-center">
                                <h2>UPCOMING EVENTS</h2>
                                <p>We host a variety of events throughout the year, both indoors and out - why noy come & join us?</p>
                        </div>
                </div>
                <div class="row">
                   <?php foreach($events as $event): ?>
                        <div class="col-md-4 col-sm-4 col-lg-4 text-center">
                                <div class="fest">
                                        <?php $image =  $cpt_obj->getImageMWPL($event->ID,'thumb'); ?>
                                        <?php if($image !=""): ?>
                                        <img class="img-responsive" src="<?=$image?>">
                                        <?php endif; ?>
                                        <p><?=$event->post_title?> - <?= $cpt_obj->check_event_date_same($cpt_obj->getmetinfo( $event->ID, '_EventStartDate'),$cpt_obj->getmetinfo( $event->ID, '_EventEndDate')); ?> </p>
                                        <a href="<?= get_permalink($event->ID)?>">learn more</a>
                                </div>
                        </div>
                    <?php endforeach; ?>
                </div>
        </div>
</div>
<?php endif; ?>
<div class="morder-section">
        <div class="container">
                <div class="row">
                        <div class="col-md-6 col-sm-6 text-center">
                                <p>Thank you for making us so welcome at The Durant Arms in your
                                beautiful village. We found room 2 warm & comfy with a lovely view.</p>
                                <p>Friendly staff, excellent accommodation and food.<br>
                                A great 4 night break.</p>
                        </div>
                        <div class="col-md-6 col-sm-6 text-center">
                                <p>Very pleasant stay in friendly pub/restaurant with three rooms above.
                                Lively atmosphere in bar with wood fire. Bright and modern decor.
                                Good evening menu and we ate twice there, once in the restaurant
                                and then in the bar. Staff very approachable.</p>
                        </div>
                </div>
        </div>
</div>
<?php get_footer(); ?>