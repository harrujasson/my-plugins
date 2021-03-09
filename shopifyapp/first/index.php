<?php 
include_once 'inc/sql_connection.php';
include_once 'inc/functions.php';
include_once 'header.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
  
</head>
<body>
    <div class="container">
        <?php include_once 'product.php'; ?>
        <?php //include_once 'popup.php'; ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        
      $(document).ready(function(){
          
          var shopurl = '<?= $shop_url ?>';
          $(".products").on('click',function(){
            var $this = $(this);
            $("#collections option").removeAttr('selected');
            $("#submitProduct").attr("data-id",'');
            $.ajax({
                method:'POST',
                data:{
                    id:$this.attr('data-id'),
                    shopUrl:shopurl,
                    type:'GET',
                },
                dataType:'json',
                url:'ajax.php',
                success:function(json){
                    $("#title").val(json['title']);
                    $("#description").val(json['description']);
                    $("#submitProduct").attr("data-id",json['id']);

                    $("#collections option").each(function(i){
                        var optionvalue = $(this).val();
                        console.log("Optiosn value "+optionvalue)
                        json['collections'].forEach(function(productcollection){
                             if(productcollection['id'] == optionvalue){
                                 $("#collections option[value='"+optionvalue+"']").attr('selected','selected');
                             }
                         });
                    });
                    $("#productModal").modal('show');
                }
            });
         });
         
         
         $("#productModal").on('hide.bs.modal',function(){
             $("#submitProduct").attr("data-id",'');
         });
         
         $("#submitProduct").on("click",function(){
             var productId = $(this).attr('data-id');
             
             $.ajax({
                method:'POST',
                data:{
                    id:productId,
                    shopUrl:shopurl,
                    type:'PUT',
                    formdata:$("#productForm").serialize(),
                },
                dataType:'json',
                url:'ajax.php',
                success:function(json){
                    //$("#productModal").modal('hide');
                    window.location.reload();
                }
            });
         });
      }); 
      
        
        
        
        
        
    
    </script>
</body>
<body>