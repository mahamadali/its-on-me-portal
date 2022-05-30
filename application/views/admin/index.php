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
              <li class="breadcrumb-item active"><a href="#"><i class="fas fa-home"></i></a>&nbsp;All Admins</li>
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
                  <h3 class="mb-0">Admin Listing </h3>
                </div>
                  <span id="status" class="pull-right btn btn-primary" style="display:none;"></span>
                <div class="col-4 text-right">
                  <a href="<?php echo base_url('admin-list/add') ?>" class="btn btn-sm btn-primary">Add Admin</a>
                </div> 
              </div>
            </div>
          
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="product_list">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="admin_email">Email</th>
                    <th scope="col" class="sort" data-sort="admin_pass">Password</th>
                    <th scope="col" class="sort" data-sort="date">Action</th>
                  </tr>
                </thead>
                <tbody class="list">
                  <?php foreach ($AllAdmin as $key => $value) {?>
                    <tr>
                     <td class="admin_email">
                      <?php echo $value->email?>
                    </td>

                    <td class="admin_pass">
                      <?php echo $value->password?>
                    </td>

                   <td>
                      <a href="<?php echo base_url('admin-list/delete') ?>/<?php echo $value->id ?>" class="btn btn-sm btn-danger">Delete</a>
                      <a href="<?php echo base_url('admin-list/edit') ?>/<?php echo $value->id ?>" class="btn btn-sm btn-primary">Edit</a> 
                   </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
      
      </div>
    </div>
  </div>
  <!-- Dark table -->
 