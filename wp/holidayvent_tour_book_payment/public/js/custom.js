jQuery(document).ready(function($){
    
    var slug='';
    
    $( ".datepicker" ).datepicker({
        dateFormat:'MM dd, yy',
        minDate: -0, 
        maxDate: "+1M +10D"
    });
    
    
    var basic_price = 0;
    var no_person=0;    
    var number_of_infant =0;
    
    load_basic_price();
    
    function load_basic_price(){
        $.ajax({
            type:'post',
            data:{
                action:'tourprice',
                tour_id:$('#tour_id').val()
            },
            url:slug+'/wp-admin/admin-ajax.php',
            success:function(data){
                if(data !=''){
                    basic_price = data;                    
                }else{
                    alert('Something went, Please try after some time.');
                }

            },
            error:function(data){
                alert('Something went, Please try after some time.');
            }
        });
    }
    /*Payment page*/
    $("#number_of_person,  #number_of_infant").change(function(){
        price_set();
    });    
    function price_set(){
        no_person = $("#number_of_person").val();        
        number_of_infant = $("#number_of_infant").val();
        
        console.log("Person "+no_person+" Infant "+number_of_infant);
        
        /*Adults*/
        number_of_person_final = get_price_persion(no_person);
        //console.log("Total Person  "+number_of_person_final);
        $("#no_of_person_total").text(no_person);
        
        /*Add adult member*/
        number_of_infant_final = get_price_infant(number_of_infant);
        //console.log("Total Infant  "+number_of_infant_final);
        $("#no_of_adult_infant_total").text(number_of_infant);
        
        var sub_total = parseInt(number_of_person_final) + parseInt(number_of_infant_final);
        var gst_tax = parseInt(sub_total) * 18 /100;
        var grand_total = parseFloat(sub_total) + parseFloat(gst_tax);
        
        $("#total_amount").text(sub_total);
        $("#gst").text(gst_tax);
        $("#grand_total_amount").text(grand_total);
        
        
        
    }
    function get_price_persion(no_person){
        if(parseInt(no_person) > 0){
            return parseInt(no_person)  * parseInt(basic_price);
        }else{
            return 0;
        }
    }
    function get_price_infant(no_person){
        if(parseInt(no_person) > 0){
            return parseInt(no_person)  * parseInt(parseInt(basic_price)/2);
        }else{
            return 0;
        }
    }
    $(".datepicker").change(function(){       
       $("#tour_date").text($(this).val());
    });
    
});