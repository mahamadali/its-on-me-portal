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
              <li class="breadcrumb-item active"><a href="#"><i class="fas fa-home"></i></a>&nbsp;All Merchants</li>
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
                  <h3 class="mb-0">Merchants </h3>
                </div>
                  <span id="status" class="pull-right btn btn-primary" style="display:none;"></span>
                <div class="col-4 text-right">
                  <a href="<?php echo base_url('merchants/create') ?>" class="btn btn-sm btn-primary">Create merchant account</a>
                </div>
              </div>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="merchant-list">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort">Profile Picture</th>
                    <th scope="col" class="sort">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col" class="sort">Status</th>
                    <th scope="col" class="sort">Action</th>
                  </tr>
                </thead>
                <tbody class="list">
                  
              </tbody>
            </table>
          </div>        
      </div>
    </div>
  </div>
  <!-- Dark table -->
 