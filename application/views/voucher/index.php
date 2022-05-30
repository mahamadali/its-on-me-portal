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
              <li class="breadcrumb-item active"><a href="#"><i class="fas fa-home"></i></a>&nbsp; Voucher list</li>
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
                  <h3 class="mb-0">Vouchers </h3>
                </div>
                  <span id="status" class="pull-right btn btn-primary" style="display:none;"></span>
                <div class="col-4 text-right">
                  <a href="<?php echo base_url('voucher/add') ?>" class="btn btn-sm btn-primary">Add Voucher</a>
                </div>
              </div>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="merchant-bank-list">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort">Voucher Photo</th>
                    <th scope="col" class="sort">Voucher Name</th>
                    <th scope="col" class="sort">Voucher Price</th>
                    <th scope="col" class="sort">Status</th>
                    <th scope="col" class="sort">Action</th>
                  </tr>
                </thead>
                 <tbody class="list">
                  <?php if(!empty($AllVouchers)): ?>

                    <?php foreach ($AllVouchers as $key => $voucher) { ?>
                  <tr>

                     <td class="voucher_name">
                       <?php if(!empty($voucher->voucher_photo)): ?>
                        <img src="<?php echo $voucher->voucher_photo ?>" height="100" width="100">
                      <?php endif; ?>
                    </td>
                    
                     <td class="voucher_name">
                      <?php echo $voucher->voucher_name ?>
                    </td>

                     <td class="voucher_price">
                      <?php echo $voucher->voucher_price ?>
                    </td>

                    <td class="voucher_status">
                      <?php echo $voucher->status ?>
                    </td>

                    <td >
                      <a href="<?php echo base_url('voucher/delete') ?>/<?php echo $voucher->id ?>" class="btn btn-sm btn-danger">Delete</a>
                      <a href="<?php echo base_url('voucher/edit') ?>/<?php echo $voucher->id ?>" class="btn btn-sm btn-primary">Edit</a> 
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
 