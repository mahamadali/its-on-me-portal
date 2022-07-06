<!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <!-- <h6 class="h2 text-white d-inline-block mb-0">Products</h6> -->
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item active"><a href="#"><i class="fas fa-home"></i></a>&nbsp;All Brands</li>
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
                  <h3 class="mb-0">Brands Listing </h3>
                </div>
                <div class="col-4 text-right">
                  <a href="<?php echo base_url('brands/add') ?>" class="btn btn-sm btn-primary">Add Brand</a>
                </div>
              </div>
            </div>

            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="cat_list">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">Name</th>
                    <th scope="col" class="sort" data-sort="created_at">Created At</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody class="list">
                  <?php foreach ($AllBrands as $key => $item) {?>
                  <tr>
                    <td class="name">
                      <?php echo $item->name ?>
                    </td>
                    <td class="created_at">
                     <?php if(!empty($item->created_at)): ?>
                      <?php echo date('Y-m-d H:i:s',strtotime($item->created_at)); ?>
                    <?php endif; ?>
                    </td>
                    <td >
                      <a href="<?php echo base_url('brands/delete') ?>/<?php echo $item->id ?>" class="btn btn-sm btn-danger">Delete</a>
                      <a href="<?php echo base_url('brands/edit') ?>/<?php echo $item->id ?>" class="btn btn-sm btn-primary">Edit</a>
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
      
      