<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <!-- <h6 class="h2 text-white d-inline-block mb-0">Products</h6> -->
          <!-- <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item active"><a href="#"><i class="fas fa-home"></i></a>&nbsp;All Corporate Members</li>
            </ol>
          </nav> -->
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
                  <h3 class="mb-0">Add Corporate Members </h3>
                </div>
                  <span id="status" class="pull-right btn btn-primary" style="display:none;"></span>
              </div>
            </div>
              <div class="card-body mt--4">
                <form method="post" action="<?php echo base_url('members/store') ?>" enctype="multipart/form-data">
                  <h6 class="heading-small text-muted mb-4"></h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-name">Name</label>
                          <input type="text" name="member_first_name" id="member_first_name" class="form-control" placeholder="Enter Memeber Name" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-name">Email</label>
                          <input type="email" name="member_email" id="member_email" class="form-control" placeholder="Enter Memeber Email" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-name">Password</label>
                          <input type="password" name="member_password" id="member_password" class="form-control" placeholder="Enter Memeber Password" autocomplete="off">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-4">
                   <input type="submit" class="btn btn-primary my-4" value="Submit">
                   <a href="<?php echo base_url('dashboard') ?>" class="btn btn-info pull-right">Cancel</a>
                 </div>
               </form>
             </div>
          
                 
      </div>
    </div>
  </div>
  <!-- Dark table -->
 