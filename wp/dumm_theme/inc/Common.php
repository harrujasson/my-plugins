<?php

Class Wp_Common{
    
    function __construct() {
        add_shortcode( 'rooms', array($this,'roominformation')  );
        add_shortcode( 'events-home', array($this,'eventinformation')  );
        add_shortcode( 'about-us', array($this,'about_us_information')  );
        
    }
    
    function getMetavalue($id,$key){
        return get_post_meta( $id, $key,  TRUE );     
    }
    function getPost($posttype,$number_post = -1,$order='ASC'){
        $args = array(
        'orderby'          => 'date',
        'order'            => $order,
        'post_type'        => $posttype,
        'post_status'      => 'publish',
        'numberposts'     => $number_post,
        'suppress_filters' => true );
        $posts = get_posts( $args );
        return $posts;
    }
    
    
    public function filterPostGetEventHome($numberpost=-1){        
        $args = array(
        'post_type'     => 'tribe_events',
        'post_status'   => 'publish',
        'orderby'         => 'meta_value',
        'meta_key'    => '_EventStartDate',
        'order'            => 'DESC',    
        'suppress_filters' => true, 
        'numberposts'     => $numberpost,
        'meta_query'    =>array(            
            'key' => '_EventStartDate',
            'value' => date("Y-m-d H:i:s"),
            'compare' => '>=',
            'type' => 'DATE'
        ) 
        );
        $posts = get_posts($args);        
        return $posts;        
    }
    function get_post_field_by_id($id=0,$fld='post_title'){
        $post = get_post($id);
        if(!empty($post)){
            return $post->$fld;
        }
    }
    public function getImageMWPL($id,$size ='large'){       
        return get_the_post_thumbnail_url($id, $size);
    }
    function getPageContentMwpl($slug=''){
        $page_data = get_page_by_path($slug);
        if($page_data){
            return $page_data;
        }
    }
     
    public function getmetinfo($postid,$meta_name=''){       
        $values=get_post_meta( $postid, $meta_name,  TRUE );
        return $values;
    }
    function check_event_date_same($start_event, $end_event ){
        $Start_date = date('d-m-Y', strtotime($start_event));
        $end_date = date('d-m-Y', strtotime($end_event));
        $check = $this->dateManuplationGet($Start_date, $end_date,'equality');
        if($check == 0){
            return date('l jS F', strtotime($start_event));
        }else{
            return date('jS F', strtotime($start_event)).' - '.date('jS F', strtotime($end_date));
        }
    }
    
    function dateManuplationGet($start,$end,$return=""){
        
            $dateOne = new DateTime($start);
            $dateTwo = new DateTime($end);            
            $interval = $dateOne->diff($dateTwo);
            
            $minutes = $interval->format("%i");

            $hours = $interval->h;
            $hours = $hours + ($interval->days*24);
            $day=$interval->days; 
            $last_days=$interval->d;
            $seconds=$dateTwo->getTimestamp() - $dateOne->getTimestamp();
            if($return=="hour"){
                return $hours;
            }elseif($return=="day"){
                return $day;
            }elseif($return=="seconds"){
                return $seconds;
            }elseif($return=="minutes"){               
                return $minutes;
            }elseif($return=="last days"){
                return $last_days;
            }elseif($return=="equality"){
                
                if ($dateOne < $dateTwo)
                   return -1;  // lt
                 else if ($dateOne == $dateTwo)
                   return 0;  // eq
                 else if ($dateOne > $dateTwo)
                   return 1;  // gt
                 else
                   return "Nothing";
            }
            else{
                return $interval;
            }        
    }
    
    function roominformation(){
        ob_start();
        $rooms = $this->getPost('room'); 
        include get_template_directory() . '/inc/partials/room.php';
        return ob_get_clean();
    }
    function eventinformation(){
        ob_start();
        $rooms = $this->getPost('room'); 
        include get_template_directory() . '/inc/partials/events.php';
        return ob_get_clean();
    }
    function about_us_information(){
        ob_start();
        $about = $this->getPost('about_us');        
        include get_template_directory() . '/inc/partials/about_us.php';
        return ob_get_clean();
    }
    
    function about_us_information_plugin($id=0){       
        $post_information = get_post($id);           
        include get_template_directory() . '/inc/partials/about_us.php';
    }
    function eat_information_plugin(){
        $post_information = $this->getPost("eat");       
        include get_template_directory() . '/inc/partials/eat.php';
    }
    
}
$cpt_obj = new Wp_Common();

