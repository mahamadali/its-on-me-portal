 <!-- Header -->
<!-- Page content -->
    <div class="container-fluid mt-6">
      <div class="row">
        <div class="col-xl-12 order-xl-1">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Manage Profile</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form method="post" action="<?php echo base_url('profile/changepassword') ?>" enctype="multipart/form-data">
                <h6 class="heading-small text-muted mb-4">System Password</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-name">Old Password</label>
                          <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Enter Old Password" autocomplete="off">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-description">New Password</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter Old Password" autocomplete="off">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-description">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Enter Old Password" autocomplete="off">
                      </div>
                    </div>
                  </div>
                </div>
              <div class="col-4">
                 <input type="submit" class="btn btn-primary my-4" value="Update">
                  <a href="<?php echo base_url('dashboard') ?>" class="btn btn-info pull-right">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
