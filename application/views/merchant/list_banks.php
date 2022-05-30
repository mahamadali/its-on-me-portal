<style type="text/css">
.text-black
{
  color:black;
}
</style>
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <!-- <h6 class="h2 text-white d-inline-block mb-0">Products</h6> -->
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item active"><a href="#"><i class="fas fa-home"></i></a>&nbsp; Bank list</li>
            </ol>
          </nav>
        </div>
           <!--  <div class="col-lg-6 col-5 text-right">
              <a href="#" class="btn btn-sm btn-neutral">New</a>
              <a href="#" class="btn btn-sm btn-neutral">Filters</a>
            </div> -->
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Banks </h3>
                </div>
                  <span id="status" class="pull-right btn btn-primary" style="display:none;"></span>
                <div class="col-4 text-right">
                  <a href="<?php echo base_url('merchants') ?>" class="btn btn-sm btn-primary">Back to Merchant</a>
                  <a href="<?php echo base_url('merchants/add-bank/'.$merchant_id) ?>" class="btn btn-sm btn-primary">Add Bank</a>
                </div>
              </div>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="merchant-bank-list">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort">Bank Name</th>
                    <th scope="col" class="sort">Account Type</th>
                    <th scope="col" class="sort">Branch Code</th>
                    <th scope="col" class="sort">Acc No</th>
                    <th scope="col" class="sort">Action</th>
                  </tr>
                </thead>
                 <tbody class="list">
                  <?php if(!empty($merchant_bank_list)): ?>

                    <?php foreach ($merchant_bank_list as $key => $bank) { ?>
                  <tr>

                     <td class="bank_name">
                      <?php echo $bank['bank_name'] ?>
                    </td>
                    
                     <td class="account_type">
                      <?php echo $bank['account_type'] ?>
                    </td>

                     <td class="branch_code">
                      <?php echo $bank['branch_code'] ?>
                    </td>

                    <td class="account_number">
                      <?php echo $bank['account_number'] ?>
                    </td>

                    <td >
                      <a href="<?php echo base_url('merchants/delete-merchant-bank') ?>/<?php echo $bank['id'] ?>/<?php echo $bank['merchant_id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                      <a href="<?php echo base_url('merchants/edit-merchant-bank') ?>/<?php echo $bank['id'] ?>/<?php echo $bank['merchant_id'] ?>" class="btn btn-sm btn-primary">Edit</a> 
                    </td>
                  </tr>
                <?php } ?>

                  <?php endif; ?>
                </tbody>
            </table>
          </div>        
      </div>
    </div>
  </div>
  <!-- Dark table -->
 