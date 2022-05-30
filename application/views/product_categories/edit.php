 <!-- Header -->
<!-- Page content -->
    <div class="container-fluid mt-6">
      <div class="row">
        <div class="col-xl-12 order-xl-1">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Edit Product Category </h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form method="post" action="<?php echo base_url('product-categories/update') ?>" enctype="multipart/form-data">
                <input type="hidden" name="cat_id" value="<?php echo $cat_data->id ?>">
                <h6 class="heading-small text-muted mb-4">Category information</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-name">Name</label>
                        <input type="text" id="name" class="form-control" placeholder="Enter Category Name" name="name" required="" value="<?php echo $cat_data->name ?>">
                      </div>
                    </div>
                  </div>
                </div>
              <div class="col-4">
                 <input type="submit" class="btn btn-primary my-4" value="Update">
                  <a href="<?php echo base_url('product-categories') ?>" class="btn btn-info pull-right">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>