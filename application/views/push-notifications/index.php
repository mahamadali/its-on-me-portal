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
              <li class="breadcrumb-item active"><a href="#"><i class="fas fa-home"></i></a>&nbsp;Notifications</li>
            </ol>
          </nav>
        </div>
            <!-- <div class="col-lg-6 col-5 text-right">
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
                  <h3 class="mb-0">Notifications </h3>
                </div>
                  <span id="status" class="pull-right btn btn-primary" style="display:none;"></span>
                <div class="col-4 text-right">
                  <a href="<?php echo base_url('push-notifications/create') ?>" class="btn btn-sm btn-primary">Create</a>
                </div>
              </div>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="notifications-list">
                <thead class="thead-light">
                  <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Province</th>
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
 