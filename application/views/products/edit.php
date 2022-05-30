 <div class="container-fluid mt-6">
      <div class="row">
        <div class="col-xl-12 order-xl-1">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Edit Product </h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form method="post" action="<?php echo base_url('merchant/products/update_item') ?>" id="add_online_store_product" enctype="multipart/form-data">
                <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_data->id ?>">
                <h6 class="heading-small text-muted mb-4">Product information</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group"> 
                        <label class="form-control-label" for="input-name">Product Categories</label>
                          <select class="form-control cat_id multiple-selects" required="" id="categories" name="categories[]"  multiple="multiple">
                            <option value="">Select Category</option>
                             <?php if(!empty($categories)) {?> 
                        <?php foreach ($categories as $key => $value) { ?>
                               <option <?php if(in_array($value->id,explode(',',$product_data->categories))){ echo "selected"; }  ?> value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                        <?php } }?>
                          </select>
                      </div>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-name">Product Name</label>
                        <input type="text" id="product_name" class="form-control" placeholder="Enter Item Name" name="product_name" required="" value="<?php echo $product_data->product_name ?>">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-price">Price</label>
                        <input type="number" id="product_price" class="form-control" placeholder="Enter Item Price" name="product_price" required="" step=".01" value="<?php echo $product_data->product_price ?>">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="password">Product Image</label>
                        <input type="file" id="files" class="form-control"  name="files[]" multiple>
                      </div>
                      <?php $productImages = explode(",", $product_data->product_image); ?>
                      <?php foreach($productImages as $productImage): ?>
                        <img src="<?php echo base_url($productImage) ?>" height="70">
                      <?php endforeach; ?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-description">Description</label>
                        <textarea class="form-control" name="product_description" id="product_description" cols="5" rows="5" required=""><?php echo $product_data->product_description ?></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-description">Apply for feature product?</label>
                        <label><input type="radio" name="apply_featured" value="YES" <?php echo $product_data->product_description == 'YES' ? 'checked' : '' ?> required> YES</label>
                        <label><input type="radio" name="apply_featured" value="NO" <?php echo $product_data->product_description == 'NO' ? 'checked' : '' ?>> No</label>
                      </div>
                    </div>
                  </div>
                </div>
              <div class="col-4">
                 <input type="submit" class="btn btn-primary my-4" value="Update Item">
                  <a href="<?php echo base_url('merchant/products') ?>" class="btn btn-info pull-right">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

<script src="https://cdn.tiny.cloud/1/1oygzsxmj2z65b12oe2xsmopyeb339ctejhzi5fgpu8ftp4r/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
  selector:'textarea',
  menubar :false,
});
</script>