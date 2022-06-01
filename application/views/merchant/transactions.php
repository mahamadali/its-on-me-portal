<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <!-- <h6 class="h2 text-white d-inline-block mb-0">Products</h6> -->
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item active"><a href="<?php echo base_url('merchants') ?>"><i class="fas fa-arrow-left"></i></a>&nbsp;<?php echo ucfirst($merchant->username) ?> Transactions</li>
            </ol>
          </nav>
        </div>
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
                  <h3 class="mb-0">Transactions </h3>
                </div>
              </div>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="merchant-transactions">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort">#</th>
                    <th scope="col" class="sort">User</th>
                    <th scope="col">Receiver Name</th>
                    <th scope="col">Receiver Email</th>
                    <th scope="col">Receiver CellNumber</th>
                    <th scope="col">Price</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">Created</th>
                    <th scope="col" class="sort">Status</th>
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
 