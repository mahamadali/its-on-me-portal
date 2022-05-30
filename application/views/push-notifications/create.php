 <!-- Header -->
<!-- Page content -->
    <div class="container-fluid mt-6">
      <div class="row">
        <div class="col-xl-12 order-xl-1">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Send Notification</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form method="post" action="<?php echo base_url('push-notifications/store') ?>" enctype="multipart/form-data">
              <div class="row">
                <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label" for="title">Title</label>
                  <input type="text" id="title" class="form-control" placeholder="Enter Title" name="title" required="" autocomplete="off">
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label" for="message">Message</label>
                  <textarea id="message" class="form-control" placeholder="Enter Message" name="message" required="" autocomplete="off"></textarea>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label" for="website_link">Website Link (optional)</label>
                   <input type="text" id="website_link" class="form-control" placeholder="Enter Website link" name="link">
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label" for="province">Province</label>
                  <select id="province" class="form-control multiple-selects" name="province[]" required="">
                    <option value="All">All</option>
                    <?php foreach($provinces as $province): ?>
                      <option value="<?php echo $province->id ?>"><?php echo $province->name ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              

              
              <div class="col-4">
                 <input type="submit" class="btn btn-primary my-4" value="Submit">
                  <a href="<?php echo base_url('push-notifications') ?>" class="btn btn-info pull-right">Cancel</a>
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>


      