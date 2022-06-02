<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <!-- <h6 class="h2 text-white d-inline-block mb-0">Products</h6> -->
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item active"><a href="<?php echo base_url('merchants') ?>"><i class="fas fa-arrow-left"></i></a>&nbsp;<?php echo ucfirst($merchant->username) ?> Transactions</li>
            </ol>
          </nav>
        </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <!-- Total Amount Section -->
          <?php if(!empty($total_amount)) { ?>
            <div class="col-xl-4 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Total Amount</h5>
                      <span class="h2 font-weight-bold mb-0" id="total_pre_register_members">R<?php echo $total_amount ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                        <i class="ni ni-circle-08"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
         <!-- Total Amount Section -->
      </div>
      <div class="row">
         
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-3">
                  <h3 class="mb-0">Transactions </h3>
                </div>
              </div>
              <form method="post" action="<?php echo base_url('merchants/transactions/'.$merchant->id) ?>">
                <div class="row align-items-center">
                <div class="col-3"></div>
                <div class="col-3">
                   <select  name="transaction_month" id="transaction_month" class="form-control">
                    <option <?php echo ($month == 1) ? 'selected' : '' ?> value="1">January</option>
                    <option <?php echo ($month == 2) ? 'selected' : '' ?> value="2">February</option>
                    <option <?php echo ($month == 3) ? 'selected' : '' ?> value="3">March</option>
                    <option <?php echo ($month == 4) ? 'selected' : '' ?> value="4">April</option>
                    <option <?php echo ($month == 5) ? 'selected' : '' ?> value="5">May</option>
                    <option <?php echo ($month == 6) ? 'selected' : '' ?> value="6">June</option>
                    <option <?php echo ($month == 7) ? 'selected' : '' ?> value="7">July</option>
                    <option <?php echo ($month == 8) ? 'selected' : '' ?> value="8">August</option>
                    <option <?php echo ($month == 9) ? 'selected' : '' ?> value="9">September</option>
                    <option <?php echo ($month == 10) ? 'selected' : '' ?> value="10">October</option>
                    <option <?php echo ($month == 11) ? 'selected' : '' ?> value="11">November</option>
                    <option <?php echo ($month == 12) ? 'selected' : '' ?> value="12">December</option>
                </select>
                </div>
                <div class="col-3">
                    <select  name="transaction_year" id="transaction_year" class="form-control">
                   </select>
                </div>
                <div class="col-3">
                   <input type="submit" name="submit_filter_transaction" class="btn btn-primary">
                </div>
              </div>
              </form>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="merchant-transactions">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort">#</th>
                    <th scope="col" class="sort">User</th>
                    <th scope="col">Receiver Name</th>
                    <th scope="col">Receiver Email</th>
                    <th scope="col">Receiver CellNumber</th>
                    <th scope="col">Price</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">Created</th>
                    <th scope="col" class="sort">Status</th>
                  </tr>
                </thead>
                <tbody class="list">
                  
              </tbody>
            </table>
          </div>        
      </div>
    </div>
  </div>
  <!-- Dark table -->
 <script>
  let dateDropdown = document.getElementById('transaction_year'); 
       
  let currentYear = new Date().getFullYear();    
  let earliestYear = 1995;     
  while (currentYear >= earliestYear) {      
    let dateOption = document.createElement('option');          
    dateOption.text = currentYear;      
    dateOption.value = currentYear;        
    dateDropdown.add(dateOption);
    if(currentYear == '<?php echo $year ?>') {
      dateOption.selected = currentYear;
    }      
    currentYear -= 1;    
  }
</script>