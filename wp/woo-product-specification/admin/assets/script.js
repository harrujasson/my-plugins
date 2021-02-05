jQuery(document).ready(function($){
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
    
    $( "#sortable_page" ).sortable();
    $( "#sortable_page" ).disableSelection();
    
    $("#more_record").click(function(){
        add_record();   
    });
    $("#more_record_page").click(function(){
        add_record_page();   
    });
    
    $("body").on("click",".remove_container",function(){
       var $this = $(this);       
       
       var x = confirm("Are you sure you want to delete ?");
       if(x == true){
          $this.parent().parent().remove();
       }
    });
    
    $(function(){
        add_record(); 
        add_record_page(); 
    });
    function add_record(){ 
        var $template = $(".mwpl_emptyContainer").children('.fieldsContainer');
        var $newPanel = $template.clone();
        $(".load_html").append($newPanel.fadeIn());
        $( "#sortable" ).sortable('refresh');  
    }
    function add_record_page(){ 
        var $template = $(".mwpl_emptyContainerPage").children('.fieldsContainerPage');
        var $newPanel = $template.clone();
        $(".load_html_page").append($newPanel.fadeIn());
        $( "#sortable_page" ).sortable('refresh');  
    }
    
    $('.mwpl_visible_down').click(function(){
        var $this = $(this);
        $this.parent().parent().parent().find('.mwpl_pannel_body').slideUp();
        $this.hide();
        $this.parent().find('.mwpl_visible_up').show();
    });
    $('.mwpl_visible_up').click(function(){
        var $this = $(this);
        $this.parent().parent().parent().find('.mwpl_pannel_body').slideDown();
        $this.hide();
        $this.parent().find('.mwpl_visible_down').show();
    });
    
    
});