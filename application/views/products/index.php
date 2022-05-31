<!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <!-- <h6 class="h2 text-white d-inline-block mb-0">Products</h6> -->
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item active"><a href="#"><i class="fas fa-home"></i></a>&nbsp;All Products</li>
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
                  <h3 class="mb-0">Item Listing </h3>
                </div>
                <div class="col-4 text-right">
                  <?php if(!$this->session->userdata('admin')): ?>
                    <a href="<?php echo base_url('merchant/products/add_item') ?>" class="btn btn-sm btn-primary">Add Item</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="product_list">
                <thead class="thead-light">
                  <tr>
                    <?php if($this->session->userdata('admin')): ?>
                      <th scope="col" class="sort" data-sort="name">Merchant</th>
                    <?php endif; ?>
                    <th scope="col" class="sort" data-sort="name">Image</th>
                    <th scope="col" class="sort" data-sort="photo">Product Name</th>
                    <th scope="col" class="sort" data-sort="cat">Prodcut Price</th>
                    <th scope="col" class="sort" data-sort="cat">Apply for Featured?</th>
                    <th scope="col" class="sort" data-sort="cat">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody class="list">
                  <?php foreach ($AllProducts as $key => $item) { 
                     //$getProductData = $this->Merchant_Product_model->get_product_cat_data($item->cat_id);
                    $merchant = $this->merchant->getOne($item->merchant_id);
                    ?>
                  <tr>
                    <?php if($this->session->userdata('admin')): ?>
                      <td><?php echo $merchant->username; ?></td>
                    <?php endif; ?>
                     <td class="price">
                      <?php
                      if(!empty($item->product_image)) {
                        $productImages = explode(',', $item->product_image);
                        $image = $productImages[0];
                      } else {
                        
                        $image = $merchant->profile_picture;
                      }
                      ?>
                      <img src="<?php echo base_url($image) ?>" height="70">
                    </td>

                     <td class="price">
                      <?php echo $item->product_name ?>
                    </td>
                     <td class="price">
                      R<?php echo $item->product_price ?>
                    </td>
                    <td class="price">
                      <?php echo $item->apply_featured ?>
                      <?php if($item->is_featured == 1): ?>
                        <br>
                        <span class="badge badge-success">FEATURED</span>
                      <?php else: ?>
                        <br>
                        <span class="badge badge-warning">Waiting for approval</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <span class="badge badge-dot mr-4">
                        <?php if($item->status == 1): ?>
                          <i class="bg-success"></i>
                        <span class="status">Active</span>
                      <?php else: ?>
                        <i class="bg-warning"></i>
                        <span class="status">InActive</span>
                      <?php endif; ?>
                      </span>
                    </td>
                    <td >
                      <?php if(!$this->session->userdata('admin')): ?>
                      <a href="<?php echo base_url('merchant/products/delete_item') ?>/<?php echo $item->id ?>" class="btn btn-sm btn-danger">Delete</a>
                      <a href="<?php echo base_url('merchant/products/edit_item') ?>/<?php echo $item->id ?>" class="btn btn-sm btn-primary">Edit</a>
                    <?php else: ?>
                      <?php if($item->apply_featured == 'YES' && $item->is_featured == 0): ?>
                      <a href="<?php echo base_url('products/approve_feature/'.$item->id) ?>" class="btn btn-sm btn-primary">Approve as Featured Product</a>
                    <?php endif; ?>
                    <?php endif; ?>
                    </td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- Card footer -->
            <!-- <div class="card-footer py-4">
              <nav aria-label="...">
                <ul class="pagination justify-content-end mb-0">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">
                      <i class="fas fa-angle-left"></i>
                      <span class="sr-only">Previous</span>
                    </a>
                  </li>
                  <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">
                      <i class="fas fa-angle-right"></i>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div> -->
          </div>
        </div>
      </div>
      <!-- Dark table -->
      
      