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
              <li class="breadcrumb-item active"><a href="#"><i class="fas fa-home"></i></a>&nbsp;All Advertisement</li>
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
                  <h3 class="mb-0">Advertise Listing </h3>
                </div>
                  <span id="status" class="pull-right btn btn-primary" style="display:none;"></span>
             <div class="col-4 text-right">
                  <a href="<?php echo base_url('advertise/add') ?>" class="btn btn-sm btn-primary">Add Banner</a>
                </div> 
              </div>
            </div>
       
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="product_list">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="banner_path">Banner Image</th>
                    <th scope="col" class="sort" data-sort="banner_link">Link</th>
                    <th scope="col" class="sort" data-sort="status">Status</th>
                    <th scope="col" class="sort" data-sort="action">Action</th>
                  </tr>
                </thead>
                <tbody class="list">
                  <?php foreach ($AllAdvertisement as $key => $advertise) {?>
                    <tr>
                     <td class="banner_path">
                       <?php if(!empty($advertise->banner_path)): ?>
                        <img src="<?php echo $advertise->banner_path ?>" height="100" width="100">
                      <?php endif; ?>
                    </td>

                    <td class="banner_link">
                      <?php echo $advertise->banner_link?>
                    </td>

                    <td class="status">
                      <?php echo ($advertise->status == 1) ? 'Active' : 'Inactive'; ?>
                    </td>

                    <td class="status">
                      <a href="<?php echo base_url('advertise/delete') ?>/<?php echo $advertise->id ?>" class="btn btn-sm btn-danger">Delete</a>
                      <a href="<?php echo base_url('advertise/edit') ?>/<?php echo $advertise->id ?>" class="btn btn-sm btn-primary">Edit</a>
                       <?php if($advertise->status == 0): ?>
                        <a href="<?php echo base_url().'advertise/status-change/'.$advertise->id.'/1' ?>" class="btn btn-sm btn-success">Active</a>
                      <?php else: ?>
                        <a href="<?php echo base_url().'advertise/status-change/'.$advertise->id.'/0' ?>" class="btn btn-sm btn-danger">Inactive</a>
                      <?php endif; ?>  
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
 