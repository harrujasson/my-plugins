<?php 
$prodcucts = shopify_call($token,$shop_url,'/admin/api/2020-07/products.json',array(),'GET');
$prodcucts = json_decode($prodcucts['response'],JSON_PRETTY_PRINT);

?>
<div class="row mt-5 mb-5 ml-2">

    <?php foreach ($prodcucts as $product): ?>
        <?php foreach($product as $p): ?>
            <div class="col-3 mt-2 mb-2">
<!--                <div class="card " data-toggle="modal" data-target="#productModal">-->
                <div class="card products" data-id="<?=$p['id']?>">    
                  <img class="card-img-top" src="<?=$p['image']['src']?>" alt="<?=$p['title']?>">
                  <div class="card-body">
                    <h5 class="card-title"><?=$p['title']?></h5>
                  </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>

</div>



<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form method="post" id="productForm">
            <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" id="title">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea  name="description" class="form-control" id="description"></textarea>
                </div>
                <div class="form-group">
                    <label>Collection</label>
                    <select class="form-control" name="collections" id="collections" multiple="">
                        <?php 
                        $custom_collections = shopify_call($token,$shop_url,'/admin/api/2020-07/custom_collections.json',array(),'GET');
                        $custom_collections = json_decode($custom_collections['response'],JSON_PRETTY_PRINT);
                        foreach($custom_collections as $custom_collection){
                            foreach($custom_collection as $key=>$value){
                                echo "<option value='".$value['id']."'>".$value['title']."</option>";
                            }
                        }
                        ?>
                        <?php 
                        $smart_collections = shopify_call($token,$shop_url,'/admin/api/2020-07/smart_collections.json',array(),'GET');
                        $smart_collections = json_decode($smart_collections['response'],JSON_PRETTY_PRINT);
                        foreach($smart_collections as $smart_collection){
                            foreach($smart_collection as $key=>$value){
                                echo "<option value='".$value['id']."'>".$value['title']."</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submitProduct" data-id="">Save changes</button>
      </div>
    </div>
  </div>
</div>