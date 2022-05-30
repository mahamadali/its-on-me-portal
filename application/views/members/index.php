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
              <li class="breadcrumb-item active"><a href="#"><i class="fas fa-home"></i></a>&nbsp;All Members</li>
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
                  <h3 class="mb-0">Members Listing </h3>
                </div>
                  <span id="status" class="pull-right btn btn-primary" style="display:none;"></span>
                <!-- <div class="col-4 text-right">
                  <a href="<?php //echo base_url('products/add_item') ?>" class="btn btn-sm btn-primary">Add Item</a>
                </div> -->
              </div>
            </div>
            <?php if(empty($isset)): ?>
              <div class="card-body mt--4">
                <form method="post" action="<?php echo base_url('members/index') ?>" enctype="multipart/form-data">
                  <h6 class="heading-small text-muted mb-4">Member Access Password</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-name">Member Access Password</label>
                          <input type="text" name="member_access_password" id="member_access_password" class="form-control" placeholder="Enter Memeber Access Password" autocomplete="off">
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
           <?php endif; ?>	
           <?php if(!empty($isset) && $isset == 1): ?>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="product_list">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="first_name">FirstName</th>
                    <th scope="col" class="sort" data-sort="last_name">LastName</th>
                    <th scope="col">Email</th>
                    <th scope="col" class="sort" data-sort="date">Password</th>
                    <th scope="col" class="sort" data-sort="date">Total Invitation</th>
                    <th scope="col" class="sort" data-sort="date">Total Invitation Register</th>
                    <th scope="col" class="sort" data-sort="date">Action</th>
                  </tr>
                </thead>
                <tbody class="list">
                  <?php foreach ($AllMembers as $key => $order) {?>
                    <input type="hidden" name="dm_member_id" id="dm_member_id" value="<?php echo $order->id ?>">
                    <tr>
                     <td class="first_name">
                      <?php echo $order->first_name?>
                    </td>

                    <td class="last_name">
                      <?php echo $order->last_name?>
                    </td>

                    <td class="last_name">
                      <?php echo $order->email?>
                    </td>

                    <td class="last_name">
                      <?php echo General::decrypt($order->password)?>
                    </td>

                    <td class="last_name">
                      <?php echo $this->Members_model->getMemberInvitation($order->id); ?>
                    </td>

                    <td class="last_name">
                      <?php echo $this->Members_model->getMemberActiveInvitation($order->id); ?>
                    </td>
                    <td class="last_name">
                      <input type="checkbox" data-member-id="<?php echo $order
                      ->id ?>" class="member_status" id="member_status" <?php echo $order->can_do_gua_listing == '1' ? 'checked' : '' ?> data-toggle="toggle" data-size="xs"> &nbsp;
                      <a href="<?php echo base_url('view') ?>/<?php echo $order->id ?>" class="btn btn-sm btn-info">View</a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>	           
      </div>
    </div>
  </div>
  <!-- Dark table -->
 