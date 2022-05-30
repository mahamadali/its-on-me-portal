 <!-- Header -->
<!-- Page content -->
    <div class="container-fluid mt-6">
      <div class="row">
        <div class="col-xl-12 order-xl-1">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Advertisement Detail </h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form method="post" action="<?php echo base_url('advertise/store') ?>" enctype="multipart/form-data">
                <h6 class="heading-small text-muted mb-4">Advertise information</h6>
                <div class="row">
                <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="username">Banner Image</label>
                  <input type="file" id="banner_path" class="form-control" name="banner_path" required="" autocomplete="off">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="email">Banner Link</label>
                  <input type="url" id="banner_link" class="form-control"  name="banner_link" required="" autocomplete="off">
                </div>
              </div>
              </div>

              <div class="col-4">
                 <input type="submit" class="btn btn-primary my-4" value="Save">
                  <a href="<?php echo base_url('advertising') ?>" class="btn btn-info pull-right">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>