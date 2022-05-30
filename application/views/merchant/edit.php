 <!-- Header -->
<!-- Page content -->
    <div class="container-fluid mt-6">
      <div class="row">
        <div class="col-xl-12 order-xl-1">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Edit Merchant Detail </h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form method="post" action="<?php echo base_url('merchants/update') ?>" enctype="multipart/form-data">
                <input type="hidden" name="merchant_edit_id" value="<?php echo $merchant_data->id ?>">
                <h6 class="heading-small text-muted mb-4">Merchant information</h6>
                <div class="row">
                <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="username">Username</label>
                  <input type="text" id="username" class="form-control" placeholder="Enter Username" name="username" required="" autocomplete="off" value="<?php echo $merchant_data->username ?>">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="email">Email</label>
                  <input type="email" id="email" class="form-control" placeholder="Enter Email" name="email" required="" autocomplete="off" value="<?php echo $merchant_data->email ?>">
                </div>
              </div>
              </div>

              <div class="row">
                <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="password">Password</label>
                  <input type="password" id="password" class="form-control" placeholder="Enter Password" name="password" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="bio">Bio</label>
                   <input type="text" id="bio" class="form-control" placeholder="Enter Bio" name="bio" required="" value="<?php echo $merchant_data->bio ?>">
                </div>
              </div>
              </div>

              <div class="row">
                <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="password">Profile Picture</label>
                  <input type="file" id="profile_picture" class="form-control"  name="profile_picture">
                </div>
              </div>
               
              <div class="col-lg-6">
                <?php if(!empty($merchant_data->profile_picture)): ?>
                    <img src='<?php echo base_url().$merchant_data->profile_picture ?>' style="height:100px;width:100px">
                <?php endif; ?> 
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="province">Province</label>
                  <select id="province" class="form-control" name="province" required="">
                    <option value="">Choose</option>
                    <?php foreach($provinces as $province): ?>
                      <option value="<?php echo $province->id ?>" <?php echo ($province->id == $merchant_data->province) ? 'selected' : '' ?>><?php echo $province->name ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              </div>


               <div class="row">
                <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label" for="bio">Physical Address</label>
                   <input type="text" id="physical_address" class="form-control" placeholder="Enter physical address" name="physical_address" required="" value="<?php echo $merchant_data->physical_address ?>">
                </div>
              </div>
              </div>

               <div class="row">
                <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label" for="categories">Categories</label>
                  <select id="multiple"  name="categories[]" multiple="multiple">
                    <option value="">Choose</option>
                    <?php foreach($categories as $category): ?>
                      <option <?php if(in_array($category->id,explode(',',$merchant_data->categories))){ echo "selected"; }  ?> value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              </div>
              <div class="col-4">
                 <input type="submit" class="btn btn-primary my-4" value="Update">
                  <a href="<?php echo base_url('merchants') ?>" class="btn btn-info pull-right">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>