 <!-- Header -->
<!-- Page content -->
    <div class="container-fluid mt-6">
      <div class="row">
        <div class="col-xl-12 order-xl-1">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Advertisement Edit Detail </h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form method="post" action="<?php echo base_url('advertise/update') ?>" enctype="multipart/form-data">
                <input type="hidden" name="edit_advt_id" id="edit_advt_id" value="<?php echo $banner_data->id ?>">
                <h6 class="heading-small text-muted mb-4">Edit information</h6>
                <div class="row">
                <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="username">Banner Image</label>
                  <input type="file" id="banner_path" class="form-control" name="banner_path" autocomplete="off">
                </div>
                <?php if(!empty($banner_data->banner_path)): ?>
                   <img src="<?php echo base_url().$banner_data->banner_path ?>" height="100" width="100">
                <?php endif; ?>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="email">Banner Link</label>
                  <input type="url" id="banner_link" class="form-control"  name="banner_link" required="" autocomplete="off" value="<?php echo (!empty($banner_data->banner_link) ? $banner_data->banner_link : '') ?>">
                </div>
              </div>
              </div>

              <div class="col-4">
                 <input type="submit" class="btn btn-primary my-4" value="Update">
                  <a href="<?php echo base_url('advertising') ?>" class="btn btn-info pull-right">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>