 <!-- Header -->
<!-- Page content -->
    <div class="container-fluid mt-6">
      <div class="row">
        <div class="col-xl-12 order-xl-1">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Edit Admin Detail </h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form method="post" action="<?php echo base_url('admin-list/update') ?>" enctype="multipart/form-data">
                <input type="hidden" name="edit_admin_id" value="<?php echo $admin_data->id ?>">
                <h6 class="heading-small text-muted mb-4">Admin information</h6>
                <div class="row">
                <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="email">Email</label>
                  <input type="email" id="email" class="form-control" placeholder="Enter Admin Email" name="email" required="" autocomplete="off" value="<?php echo $admin_data->email ?>">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="password">Password</label>
                  <input type="password" id="password" class="form-control" placeholder="Enter Admin Password" name="password"  autocomplete="off" >
                </div>
              </div>
              </div>
              <div class="col-4">
                 <input type="submit" class="btn btn-primary my-4" value="Update">
                  <a href="<?php echo base_url('admin-list') ?>" class="btn btn-info pull-right">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>