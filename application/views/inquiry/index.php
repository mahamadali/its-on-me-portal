<style type="text/css">
.text-black
{
  color:black;
}
#InquiryModal .modal-header .close
{
   margin: 0;
   padding: 0;
}
#InquiryModal #InquiryModalTitle
{
   font-size:30px;
   text-align: center;
   margin: 0 auto;
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
              <li class="breadcrumb-item active"><a href="#"><i class="fas fa-home"></i></a>&nbsp;All Inquiries</li>
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
                  <h3 class="mb-0">Inquiry Listing </h3>
                </div>
                  <span id="status" class="pull-right btn btn-primary" style="display:none;"></span>
                <!-- <div class="col-4 text-right">
                  <a href="<?php //echo base_url('admin-list/add') ?>" class="btn btn-sm btn-primary">Add Admin</a>
                </div>  -->
              </div>
            </div>
          
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="product_list">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="fullname">Fullname</th>
                    <th scope="col" class="sort" data-sort="email">Email</th>
                    <th scope="col" class="sort" data-sort="username">Username</th>
                    <th scope="col" class="sort" data-sort="subject">Subject</th>
                    <th scope="col" class="sort" data-sort="message">Message</th>
                    <th scope="col" >Created At</th>
                    <th scope="col" class="sort" data-sort="view">Action</th>
                    
                  </tr>
                </thead>
                <tbody class="list">
                  <?php foreach ($AllInquries as $key => $value) {?>
                    <tr>
                       <td class="fullname">
                      <?php echo $value->full_name?>
                    </td>

                    <td class="email">
                      <?php echo $value->email?>
                    </td>

                     <td class="username">
                      <?php $getUsername = $this->inquiry->getUsername($value->user_id)?>
                      <?php echo $getUsername->first_name." ".$getUsername->last_name ?>
                    </td>

                    <td class="subject">
                      <?php echo $value->subject?>
                    </td>

                    <td class="message">
                      <?php 
                          $length = strlen($value->message);
                          if($length > 20)
                          {
                             echo  substr($value->message,'0','50');
                          }
                          else
                          {
                             echo $value->message;
                          }

                          
                       ?>
                     
                    </td>

                    <td class="message">
                      <?php echo $value->created_at;?>
                    </td>

                     <td class="message">
                       <a href="#" class="btn btn-primary btn-sm show_full_info" data-id="<?php echo $value->id ?>">View</a>
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
 <div class="modal fade" id="InquiryModal" tabindex="-1" role="dialog" aria-labelledby="InquiryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="InquiryModalTitle">First Inquiry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           <table class="table table-bordered inquiry_info_table" style="width:50%">
              
           </table>
           <div class="row" style="border:1px solid black;">
              <div class="col-md-6">
                <label>Username</label>
              </div>
              <div class="col-md-6">
                <label id="Inquiry_username"></label>
              </div>
           </div>
           <div class="row" style="border:1px solid black;">
              <div class="col-md-6">
                <label>Email</label>
              </div>
              <div class="col-md-6">
                <label id="Inquiry_email"></label>
              </div>
           </div>
           <div class="row" style="border:1px solid black;">
              <div class="col-md-6">
                <label>Full Name</label>
              </div>
              <div class="col-md-6">
                <label id="Inquiry_fullname"></label>
              </div>
           </div>
           <div class="row" style="border:1px solid black;">
              <div class="col-md-6">
                <label>Subject</label>
              </div>
              <div class="col-md-6">
                <label id="Inquiry_subject"></label>
              </div>
           </div>
           <div class="row" style="border:1px solid black;">
              <div class="col-md-6">
                <label>Message</label>
              </div>
              <div class="col-md-6">
                <label id="Inquiry_message"></label>
              </div>
           </div>
            <div class="row" style="border:1px solid black;">
              <div class="col-md-6">
                <label>Created At</label>
              </div>
              <div class="col-md-6">
                <label id="Inquiry_created_at"></label>
              </div>
           </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
