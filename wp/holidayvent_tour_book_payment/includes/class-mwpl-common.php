<?php
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'Library/PHPMailer.php';
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.maansawebworld.com/
 * @since      1.0.0
 *
 * @package    Mwpl_tours_managment
 * @subpackage Mwpl_tours_managment/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Mwpl_tours_managment
 * @subpackage Mwpl_tours_managment/includes
 * @author     Talwinder Singh <maansawebworldphp@gmail.com>
 */

trait MWPL_Common{

    private $path;
    private $hostname='';
    private $port ='';
    private $username='';
    private $password= '';
    private $secure ='';
    private $fromemail ='';
    private $from ='';
    private $replyemail =''; 
    private $reply ='';
    private $mailtype='';
    
    /*For display the html file only for admin side*/
    function load_view_admin($file,$data = array()){
        //$key= "";
        $var=array();
        //echo "<pre>"; print_r($data); echo "</pre>"; 
        if(!empty($data)){
            extract($data);
        }
        require  PRD_ADMIN_PATH.$file;
    }
    
    function load_view($file,$data = array()){
        //$key= "";
        $var=array();
        //echo "<pre>"; print_r($data); echo "</pre>"; 
        if(!empty($data)){
            extract($data);
        }
        require  PRD_PUBLIC_PATH.$file;
    }

    /*For datatable*/
    function set_data_table($column = array()){
        $aColumns = $column;
        //Page Limit
        $sLimit = "";
        if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' ){
               $sLimit = "LIMIT ".$_REQUEST['iDisplayStart'] .", ".
                       $_REQUEST['iDisplayLength'] ;
        }

        /*
        * Ordering
        */
        $sOrder ="";
        if ( isset( $_REQUEST['iSortCol_0'] ) )
        {

                $sOrder = "ORDER BY ";
               for ( $i=0 ; $i<intval( $_REQUEST['iSortingCols'] ) ; $i++ )
               {
                       if ( $_REQUEST[ 'bSortable_'.intval($_REQUEST['iSortCol_'.$i]) ] == "true" )
                       {
                               $sOrder.= $aColumns[ intval( $_REQUEST['iSortCol_'.$i] ) ]." ".$_REQUEST['sSortDir_'.$i]  .", ";

                       }
               }

               $sOrder = substr_replace( $sOrder, "", -2 );

               if ( $sOrder == "ORDER BY" )
               {
                       $sOrder = "";
               }
        }
        //For keyword searching
        $sWhere = "";
        if ( $_REQUEST['sSearch'] != "" )
        {
                $sWhere = " WHERE  ";
                for ( $i=0 ; $i<count($aColumns) ; $i++ )
                {
                        $sWhere .= $aColumns[$i]." LIKE '%".$_REQUEST['sSearch']."%' OR ";
                }
                $sWhere = substr_replace( $sWhere, "", -3 );
                $sWhere .= '';
        }

        /* Individual column filtering */
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
                if ( $_REQUEST['bSearchable_'.$i] == "true" && $_REQUEST['sSearch_'.$i] != '' ){

                       if ( $sWhere == "" ){
                                $sWhere = "WHERE ";
                        }
                        else{
                                $sWhere .= " AND ";
                        }

                       $sWhere .= $aColumns[$i]." LIKE '%".$this->db->escape($_REQUEST['sSearch_'.$i])."%' ";
                }
        }

        $return_data['sLimit'] = $sLimit;
        $return_data['sOrder'] = $sOrder;
        $return_data['sWhere'] = $sWhere;
        return $return_data;

    }
    function set_data_table_condition($column = array(),$condition=''){

        $aColumns = $column;
        //Page Limit
        $sLimit = "";
        if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' ){
               $sLimit = "LIMIT ".$_REQUEST['iDisplayStart'] .", ".
                       $_REQUEST['iDisplayLength'] ;
        }

        /*
        * Ordering
        */
        $sOrder ="";
        if ( isset( $_REQUEST['iSortCol_0'] ) )
        {

                $sOrder = "ORDER BY ";
               for ( $i=0 ; $i<intval( $_REQUEST['iSortingCols'] ) ; $i++ )
               {
                       if ( $_REQUEST[ 'bSortable_'.intval($_REQUEST['iSortCol_'.$i]) ] == "true" )
                       {
                               $sOrder.= $aColumns[ intval( $_REQUEST['iSortCol_'.$i] ) ]." ".$_REQUEST['sSortDir_'.$i]  .", ";

                       }
               }

               $sOrder = substr_replace( $sOrder, "", -2 );

               if ( $sOrder == "ORDER BY" )
               {
                       $sOrder = "";
               }
        }
        //For keyword searching

        if($condition!=""){
             $sWhere = " WHERE ".$condition;
        }else{
            $sWhere = "";
        }

        if ( $_REQUEST['sSearch'] != "" )
        {
                for ( $i=0 ; $i<count($aColumns) ; $i++ )
                {
                        $sWhere .= $aColumns[$i]." LIKE '%".$_REQUEST['sSearch']."%' OR ";
                }
                $sWhere = substr_replace( $sWhere, "", -3 );
                $sWhere .= '';
        }

        /* Individual column filtering */
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
                if ( $_REQUEST['bSearchable_'.$i] == "true" && $_REQUEST['sSearch_'.$i] != '' ){
                       $sWhere .= " AND ";
                       $sWhere .= $aColumns[$i]." LIKE '%".$this->db->escape($_REQUEST['sSearch_'.$i])."%' ";
                }
        }

        $return_data['sLimit'] = $sLimit;
        $return_data['sOrder'] = $sOrder;
        $return_data['sWhere'] = $sWhere;


        return $return_data;

    }


    /*For all notifications*/
    function notice($text='',$type='success'){
        if($text!=""){
        ?>
        <div class="notice is-dismissible notice-<?=$type?>">
            <p><strong>Notification.</strong> <?=$text?></p>
            <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
        </div>
        <?php
        do_action( 'admin_notices', array($this,'notice' ));
        }
    }
    function notice_front($text='',$type='success'){
        if(!isset($_SESSION)) {
            session_start();
        }

        $_SESSION['notice']   = $type;
        $_SESSION['notice_text'] = $text;        
    }
    function notice_front_get($type='notice'){
        if(!isset($_SESSION)) {
            session_start();
        }
       
        if(isset($_SESSION[$type])){           
            return $_SESSION[$type];
        }
    }
    function notice_front_falsh_remove(){
        if(!isset($_SESSION)) {
            session_start();
        }
        unset($_SESSION['notice']);
        unset($_SESSION['notice_text']);
    }

    function upload_file($name='myfile'){
        $ret = array();
        $filename="";
        if ( ! function_exists( 'wp_handle_upload' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }
 
        if($_FILES[$name]['name']!=""){
          
           $temp = explode(".",$_FILES[$name]["name"]);
           $_FILES[$name]['name']=  md5(rand(1, 1000).date("d/m/y h:i:s").'multi').'.'.end($temp);
           $uploadedfile = $_FILES[$name];
           $upload_overrides = array( 'test_form' => false );
           $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
           if ( $movefile && !isset( $movefile['error'] ) ) {
               $filename=date("Y/m")."/".$_FILES[$name]['name'];
           }
          
           return $filename;
        }
    }

    /*DB Query*/

    /*Fetch Record*/
    function get_record_by_id($table,$filter=array()){
        global $wpdb;
        $condition=$this->extract_db_condition($filter);
        $result = $wpdb->get_row("SELECT *FROM {$table} {$condition} ");
        return $result;
    }
    function get_record_exist($table,$filter=array()){
        global $wpdb;
        $condition=$this->extract_db_condition($filter);
        $exist = $wpdb->get_var("SELECT COUNT(*) FROM {$table} {$condition} ");
        return $exist;
    }
    function get_records($table,$filter=array(),$order=array()){
        global $wpdb;
        $condition=$this->extract_db_condition($filter);
        $order_extend='';
        if(!empty($order)){
            $order_string = implode(", ", $order);
            $order_extend =' ORDER BY '.$order_string;
        }       
        $result = $wpdb->get_results("SELECT *FROM {$table} {$condition} {$order_extend} ",OBJECT);
        return $result;
    }
    function get_records_wildcard($table,$condition){
        global $wpdb;
        $result = $wpdb->get_results("SELECT *FROM {$table} WHERE {$condition} ",OBJECT);
        return $result;
    }
    function get_record_by_row($table,$filter=array(),$field=''){
       global $wpdb;
        $condition=$this->extract_db_condition($filter);
        $result = $wpdb->get_row("SELECT *FROM {$table} {$condition} ",OBJECT);
        if($field!=""){
            if(!empty($result)){
                return $result->$field;
            }
        }else{
          return $result;   
        }
        
    }


    /*Insert query*/
    function insert_record($table,$data=array(),$insert_id = 0){       
        global $wpdb;
        $insert = $wpdb->insert(
                $table,
                $data
        );
        if($insert_id){
            return $wpdb->insert_id;
        }else{
            return $insert;
        }
        
    }
    function update_record($table,$data=array(),$condition=array()){
        global $wpdb;
        $update = $wpdb->update(
                $table,
                $data,
                $condition
        );
        return $update;
    }
    function delete_record($table,$condition=array()){
        global $wpdb;
        return $wpdb->delete( $table, $condition );
    }

    function extract_db_condition($filter=array()){
        $where="";
        $condition=array();
        $condition_final="";
        if(!empty($filter)){
            foreach($filter as $key=>$value){
                $condition[]= $key."=". "'". $value ."'";
            }
            $condition_final= implode(" AND ", $condition);
            $where=" WHERE ".$condition_final;
        }
        return $where;
    }
    
    /*Posts*/
    function getPost($posttype,$number_post = -1,$order='ASC'){
        $args = array(
        'orderby'          => 'title',
        'order'            => $order,
        'post_type'        => $posttype,
        'post_status'      => 'publish',
        'numberposts'     => $number_post,
        'suppress_filters' => true );
        $posts = get_posts( $args );
        return $posts;
    }
    function getMetavalue($id,$key){
        return get_post_meta( $id, $key,  TRUE );     
    }
    function get_post_by_id($id=0,$fld='post_title'){
        $post = get_post($id);
        if(!empty($post)){
            return $post;
        }
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
    function get_upload_dir_path($type ="baseurl"){
        $upload_dir   = wp_upload_dir();
        if($type=="basedir"){
            return $upload_dir['basedir'].'/';
        }elseif($type =="baseurl"){
            return $upload_dir['baseurl'].'/';
        }
    }
    function get_tour_feature_meta($post_id=0,$find='Route:'){
        $value='';
        $feature = $this->getmetinfo($post_id,'cmsmasters_project_features');
        if(!empty($feature)){
            for($i=0;$i<count($feature);$i++){
                if($feature[$i][0] == $find){
                    $value =  $feature[$i][1];
                }
            }
        }
        return $value;
    }
    /*Notification ticket*/
   function notfication_ticket_action($to,$subject="",$content="",$attachment='',$attachment_name='attachment'){
       $this->setheader_information(); 
       return $this->sendSMTPSystem($to,$subject,$content,$attachment,$attachment_name);
   } 
   function sendSMTPSystem($to,$subject="",$content="",$attachment='',$attachment_name='attachment'){
      
      if($this->mailtype =="smtp"){
          $mail = new PHPMailerCst(true);
            try{

                // $mail->isSMTP();                                      // Set mailer to use SMTP
                 $mail->Host = $this->hostname;  // Specify main and backup SMTP servers
                 $mail->SMTPAuth = true;                               // Enable SMTP authentication
                 $mail->Username = $this->username;                 // SMTP username
                 $mail->Password = $this->password;                           // SMTP password
                 $mail->SMTPSecure = $this->secure;                            // Enable TLS encryption, `ssl` also accepted
                 $mail->Port = $this->port;
                 $mail->protocol = 'mail';

                 //Recipients
                 $mail->setFrom($this->fromemail, $this->from);         
                 $mail->addAddress($to);               // Name is optional 
                 $mail->addReplyTo($this->replyemail, $this->reply);

                 //Content
                 $mail->isHTML(true);                                  // Set email format to HTML
                 $mail->Subject = $subject;
                 $mail->Body    = $content;
                 $mail->AltBody = $content;  
                 if($attachment!=""){
                     $mail->addAttachment($attachment, $attachment_name);
                 }  
                 //echo "<pre>"; print_r($mail); echo "</pre>"; die();
                 $mail->send();
                 return '1';
             } catch (Exception $e) {
                 return 'Message could not be sent. Mailer Error: '. $e->getMessage();
             }
          
      }else{
            
            $header = "From: ".$this->fromemail."\r\n"; 
            $header.= "MIME-Version: 1.0\r\n"; 
            $header.= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $header.= "X-Priority: 1\r\n"; 
            $status = mail($to, $subject, $content, $header);
            return $status;
      }
       
   } 
   function setheader_information($role='administrator'){
       global $wpdb;
       $table= $wpdb->prefix."mwpl_settings";
       $result =  $this->get_record_by_row($table, array("type"=>"admin",'service'=>"email")) ;
       //echo "<pre>"; print_r($result); echo "</pre>"; die();
          if(!empty($result)){
              if($result->information!=""){
                  $info = json_decode($result->information);
                  
                  if(isset($info->hostname)){
                      $this->hostname = $info->hostname;
                  }
                  
                  if(isset($info->type_mail)){
                      $this->mailtype = $info->type_mail;
                  }
                  if(isset($info->username)){
                      $this->username = $info->username;
                  }
                  if(isset($info->password)){
                      $this->password = $info->password;
                  }
                  if(isset($info->security)){
                      $this->secure = $info->security;
                  }
                  if(isset($info->smtp_port)){
                      $this->port = $info->smtp_port;
                  }
                  if(isset($info->from_email)){
                      $this->fromemail = $info->from_email;
                  }
                  if(isset($info->from_name)){
                      $this->from = $info->from_name;
                  }
                  if(isset($info->reply_name)){
                      $this->reply = $info->reply_name;
                  }
                  if(isset($info->reply_email)){
                      $this->replyemail = $info->reply_email;
                  }
                  if(isset($info->mailtype)){
                      $this->mailtype = $info->mailtype;
                  }
              }
          }
   }
   
   function create_customer_user($name,$email,$first_name='',$last_name='',$phone='',$other_info = array()){
       
       
       
       
        $username = strtolower( $name.'-'. rand(14, 100000));
        $email = $email;
        $password = strtolower($name. rand(0, 1014));

        $user_id = username_exists( $username );
        if ( !$user_id) {
            $user_id = wp_create_user( $username, $password, $email );
            if( !is_wp_error($user_id) ) {
                $user = get_user_by( 'id', $user_id );
                $user->set_role( 'customer' );

                /*Profile Information*/                    
                  wp_update_user(
                    array(
                      'ID'          =>    $user_id,
                      'nickname'    =>    $first_name,
                      'first_name' =>     $first_name,
                      'last_name' =>      $last_name,
                      'display_name' =>   $first_name.' '.$last_name,
                       $other_info,
                    )
                  );
                update_user_meta( $user_id, 'billing_phone',$phone );
                if(!empty($other_info)){
                    foreach($other_info as $key=>$value){
                        update_user_meta( $user_id, $key,$value );                      
                    }
                }
                
                $content ="<h2>Now you are register successfully!.</h2>";
                $content.="<p>Username: ".$username." </p>";
                $content.="<p>Password: ".$password." </p>";
                $content.="<p>You can track your orders status on our dashboard pannel please <a href='". site_url('customer-account-login')."'>click here for login</a>  </p>";

                $this->notfication_ticket_action($email, "New Registration", $content);
                return $user_id;
            }
        }else{
             $this->create_customer_user($name,$email,$first_name='',$last_name='',$phone='');
        }
   } 
   
   
   
}
?>