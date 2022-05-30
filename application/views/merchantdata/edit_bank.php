 <!-- Header -->
<!-- Page content -->
    <div class="container-fluid mt-6">
      <div class="row">
        <div class="col-xl-12 order-xl-1">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Update Bank</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form method="post" action="<?php echo base_url('merchant/update-bank') ?>" enctype="multipart/form-data">
                <input type="hidden" name="edit_bank_id" value="<?php echo $merchant_bank_data->id ?>">
                <input type="hidden" name="merchant_id" value="<?php echo $merchant_bank_data->merchant_id ?>">
              <div class="row">
                <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="bank_name">Bank Name</label>
                  <input type="text" id="bank_name" class="form-control" placeholder="Enter bank name" name="bank_name" required="" autocomplete="off" value="<?php echo $merchant_bank_data->bank_name ?>">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="account_type">Account Type</label>
                  <input type="text" id="account_type" class="form-control" placeholder="Enter account type" name="account_type" required="" autocomplete="off" value="<?php echo $merchant_bank_data->account_type ?>">
                </div>
              </div>
              </div>

              <div class="row">
                <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="branch_code">Branch Code</label>
                  <input type="text" id="branch_code" class="form-control" placeholder="Enter branch code" name="branch_code" required="" autocomplete="off" value="<?php echo $merchant_bank_data->branch_code ?>">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="account_number">Account Number</label>
                  <input type="number" id="account_number" class="form-control" placeholder="Enter account number" name="account_number" required="" autocomplete="off" value="<?php echo $merchant_bank_data->account_number ?>">
                </div>
              </div>
              </div>

              
              
              <div class="col-4">
                 <input type="submit" class="btn btn-primary my-4" value="Update">
                  <a href="<?php echo base_url('merchant/list-bank/'.$merchant_bank_data->merchant_id) ?>" class="btn btn-info pull-right">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>


      