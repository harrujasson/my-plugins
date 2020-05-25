<div class="col-12 col-sm-10 col-md-8">
    <div class="inner">
        <h1>Tour Information</h1>
        <?php $this->load_view_admin('customer/view/notifications.php'); ?>
        <form action="" method="post">            

            <div class="form-row">
                <div class="form-group col-md-12">
                    <p>How many peoples are going for trip ?</p>
                </div>
                <div class="form-group col-md-6">      
                    <label>No of Person</label>
                    <input type="number" class="form-control no_person" id="number_of_person"  required="" name="number_of_person" value="1" min="1">
                </div>                
                <div class="form-group col-md-6">
                    <label>No of Infant</label>
                    <input type="number" class="form-control no_infant" id="number_of_infant" required="" name="number_of_infant" value="0" min="0">                    
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <p>Select a Tour Date</p>
                </div>
                <div class="form-group col-md-12">
                    <input type="text" class="form-control datepicker" name="date_of_tour" value="<?=date('F d, Y')?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <p>Summery</p>
                </div>
                <div class="form-group col-md-12">
                    <textarea class="form-control" name="description"></textarea>
                </div>
            </div>

            

            <div class="form-row">
                <div class="form-group col-12 text-center">  
                    <input type="hidden" name="customer_tour_book">
                    <input type="hidden" id="tour_id" name="tour_id" value="<?=$tour_id?>">
                    <button class="btn submitBtn">Pay</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="col-12 col-sm-10 col-md-4">
    <div class="inner paymentSideBar">
        <h5 class="tourName"><?=$package_name?></h5>
        <p>No of Person  <span id="no_of_person_total">1</span></p>       
        <p>No of Infant  <span id="no_of_adult_infant_total">0</span></p>
        <p>Tour Date  <span id="tour_date"> <?=date('F d, Y')?></span></p>
        
        <h5 class="subtotal">Sub Total : <span>Rs <b id="total_amount"> <?=$package_price?></b> </span></h5>
        <p>GST 5% <span>Rs <b id="gst"><?= $gst = $package_price * 5 /100; ?></b> </span></p>
        <h6 class="total">Grand Total : <span>Rs <b id="grand_total_amount"><?=$gst+$package_price?></b>/-</span></h6>
    </div>
</div>
