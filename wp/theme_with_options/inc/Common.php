<?php

trait MWPL_Theme_Common{
    
    function __construct() {
    }
    function load_view($file,$data = array()){       
        $var=array();        
        if(!empty($data)){
            extract($data);
        }        
        require  MWPL_PARTIALS.$file.'.php';
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
}


