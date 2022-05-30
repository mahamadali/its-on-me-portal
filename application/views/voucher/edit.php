 <!-- Header -->
<!-- Page content -->
    <div class="container-fluid mt-6">
      <div class="row">
        <div class="col-xl-12 order-xl-1">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Add Voucher </h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form method="post" action="<?php echo base_url('voucher/update') ?>" id="update_voucher" enctype="multipart/form-data">
                <input type="hidden" name="edit_voucer_id" id="edit_voucer_id" value="<?php echo $voucher_data->id ?>">
                <h6 class="heading-small text-muted mb-4">Voucher information</h6>
                <div class="pl-lg-4">
                  <div class="row mt-3">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-name">Voucher Name</label>
                        <input type="text" id="voucher_name" class="form-control" placeholder="Enter Voucher Name" name="voucher_name" required="" value="<?php echo (!empty($voucher_data->voucher_name) ? $voucher_data->voucher_name : '') ?>">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-price">Voucher Price</label>
                        <input type="number" id="voucher_price" class="form-control" placeholder="Enter Voucher Price" name="voucher_price" required="" step=".01" value="<?php echo (!empty($voucher_data->voucher_price) ? $voucher_data->voucher_price : '') ?>">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="password">Voucher Image</label>
                        <input type="file" id="voucher_photo" class="form-control"  name="voucher_photo" >
                      </div>
                      <?php if(!empty($voucher_data->voucher_photo)): ?>
                        <img src="<?php echo base_url().$voucher_data->voucher_photo ?>" height="100" width="100">
                    <?php endif; ?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-description">Voucher Description</label>
                        <textarea class="form-control" name="voucher_description" id="voucher_description" cols="5" rows="5"><?php echo (!empty($voucher_data->voucher_description) ? $voucher_data->voucher_description : '') ?></textarea  required="">
                      </div>
                    </div>
                  </div>

                </div>
              <div class="col-4">
                 <input type="submit" class="btn btn-primary my-4" value="Add Voucher">
                  <a href="<?php echo base_url('vouchers') ?>" class="btn btn-info pull-right">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
