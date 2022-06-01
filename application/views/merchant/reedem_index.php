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
              <form method="post" action="<?php echo base_url('merchant/check_code') ?>" id="check_voucher">
                <h6 class="heading-small text-muted mb-4">Voucher Code Check</h6>
                <div class="pl-lg-4">
                 
                  <div class="row mt-3">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-name">Voucher Code</label>
                        <input type="text" id="voucher_code" class="form-control" placeholder="Enter Voucher Code" name="voucher_code" required="">
                      </div>
                    </div>
                   

                </div>
              <div class="col-4">
                 <input type="submit" class="btn btn-primary my-4" value="CHECK CODE">
                  <a href="<?php echo base_url('merchant/reedem') ?>" class="btn btn-info pull-right">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- SHOW PRODUCT LIST WHEN CODE CORRECT -->

        <?php if(!empty($GetProductItems)) {  ?>
        <div class="col-xl-12 order-xl-1">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Product List</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                   <thead>
                      <th>Product ID</th>
                      <th>Product Price</th>
                      <th>Product Qty</th>
                      <th>Product Total</th>
                   </thead>
                   <tbody>
                    <?php foreach ($GetProductItems as $key => $value) { ?>
                       <tr>
                          <?php $proName = $this->voucher->getProName($value->product_id); ?>
                          <td><?php echo !empty($proName->product_name) ? $proName->product_name : 'N/A'; ?></td>
                          <td><?php echo $value->price ?></td>
                          <td><?php echo $value->qty ?></td>
                          <td><?php echo $value->qty*$value->price ?></td>
                       </tr>
                     <?php } ?>

                   </tbody>
                </table>
                     <a href="<?php echo base_url().'merchant/reedem_code_success'.'/'.$user_id ?>" class="btn btn-primary col-4 col-lg-2 mt-3">Reedem</a>
          </div>
        </div>
      <?php }  ?>

      
