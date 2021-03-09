<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'inc/common.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Product Specifications</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
  
</head>
<body>
    <div class="container">
        
        
        <div class="col-12 itinerary-repeater">
                    
                    <div data-repeater-list="itinerary">
                        <div class="row mb-2">
                          <div class="col-12 mb-2">
                            <button class="btn btn-icon rounded-circle btn-primary" type="button" data-repeater-create>
                              <i class="bx bx-plus"></i>
                            </button>
                            <span class="ml-1 font-weight-bold text-primary">ADD NEW</span>
                          </div>
                          
                        </div>
                        <div class="row justify-content-between mb-2" data-repeater-item>
                          <div class="col-md-6 col-12 form-group d-flex align-items-center">
                              <input type="text" class="form-control" placeholder="Title" name="title">
                          </div>
                          <div class="col-md-6 col-12 form-group">
                              <input type="text" class="form-control" placeholder="Sub Title" name="subtitle">
                          </div>
                          <div class="col-md-11 col-12 form-group">
                              <textarea  class="form-control" placeholder="Description" name="description"></textarea>
                          </div>
                          <div class="col-md-1 col-12 form-group">
                            <button class="btn btn-icon btn-danger rounded-circle" type="button" data-repeater-delete>
                              <i class="bx bx-x"></i>
                            </button>
                          </div>
                           
                        </div>
                        
                      </div>
                </div>
        
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!--    <script src="asset/repeater.js"></script>
    <script src="asset/init.js"></script>-->
    <script src="asset/jquery.repeater.min.js"></script>
    <script src="asset/form-repeater.js"></script>
</body>
<body>