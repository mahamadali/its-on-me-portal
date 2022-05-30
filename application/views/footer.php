<!-- Footer -->
<footer class="footer pt-0 ">
  <div class="row align-items-center justify-content-lg-between">
    <div class="col-lg-12">
      <div class="copyright text-center  text-muted">
        &copy; <?php echo date('Y') ?> <a href="javascript:void(0)" class="font-weight-bold ml-1"><?php echo config_item('app_name'); ?></a>
      </div>
    </div>
  </div>
</footer>
</div>
</div>
<!-- Argon Scripts -->
<!-- Core -->
<script src="<?php echo base_url('assets/vendor/jquery/dist/jquery.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/js-cookie/js.cookie.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') ?>"></script>
<!-- Optional JS -->
<script src="<?php echo base_url('assets/vendor/chart.js/dist/Chart.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/chart.js/dist/Chart.extension.js') ?>"></script>
<!-- Argon JS -->
<script src="<?php echo base_url('assets/js/argon.js?v=1.2.0') ?>"></script>
<script src="<?php echo base_url('assets/js/toastr.min.js') ?>"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script type="text/javascript">
  toastr.options = {
      toastClass: 'alert',
      iconClasses: {
          error: 'alert-error',
          info: 'alert-info',
          success: 'alert-success',
          warning: 'alert-warning'
      }
  };
  <?php if($this->session->flashdata('success')){ ?>

    toastr.success("<?php echo $this->session->flashdata('success'); ?>");

  <?php unset($_SESSION['success']); }else if($this->session->flashdata('error')){  ?>

    toastr.error("<?php echo $this->session->flashdata('error'); ?>");

  <?php unset($_SESSION['error']); }else if($this->session->flashdata('warning')){  ?>

    toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");

  <?php unset($_SESSION['warning']); }else if($this->session->flashdata('info')){  ?>

    toastr.info("<?php echo $this->session->flashdata('info'); ?>");

  <?php unset($_SESSION['info']); } ?>

</script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">

  $(document).ready(function(){  
    var client_datatable = $('#user-list').DataTable({  
      "processing":true,  
      "serverSide":true,  
      "order":[],  
      "ajax":{  
           url:"<?php echo base_url(); ?>users/ajax_list",
           type:"POST"  
      },  
    });

     var merchant_datatable = $('#merchant-list').DataTable({  
      "processing":true,  
      "serverSide":true,  
      "order":[],  
      "ajax":{  
           url:"<?php echo base_url(); ?>merchants/ajax_list",
           type:"POST"  
      },  
    });

    var notifications_datatable = $('#notifications-list').DataTable({  
      "processing":true,  
      "serverSide":true,  
      "order":[],  
      "ajax":{  
           url:"<?php echo base_url(); ?>push-notifications/ajax_list",
           type:"POST"  
      },  
    });

    /*const datatablesSimple = document.getElementById('merchant-bank-list');
    if (datatablesSimple) {
     new simpleDatatables.DataTable(datatablesSimple, {
      'paging': true
     });
   }*/

    const datatablesSimple = document.getElementById('product_list');
    if (datatablesSimple) {
     new simpleDatatables.DataTable(datatablesSimple, {
      'paging': true
     });
   }
   const datatablesCat = document.getElementById('cat_list');
   if (datatablesCat) {
     new simpleDatatables.DataTable(datatablesCat, {
      'paging': true
     });
   }
   const datatablesColor = document.getElementById('color_list');
   if (datatablesColor) {
     new simpleDatatables.DataTable(datatablesColor, {
      'paging': true
     });
   }
   const datatablesTopics = document.getElementById('topic_list');
   if (datatablesTopics) {
     new simpleDatatables.DataTable(datatablesTopics, {
      'paging': true
     });
   }

 });
</script>
<script type="text/javascript">
  $(document).ready(function(){

     var cat_id = $(this).find(':selected').attr('data-id');
      if(cat_id == 1)
      {
          $('#color_id').prop("required",true);
         $('.has_color_section').show();
         $('.has_color').show();
      }
      else
      {
         $('#color_id').prop("required",false);
         $('.has_color_section').hide();
         $('.has_color').hide();
      }

      var pro_cat_name = $(this).find(':selected').text();
         /*if(pro_cat_name == 'Golf Display CasesActive' || pro_cat_name == 'Football Display CasesActive' || pro_cat_name == 'Baseball Display CasesActive' || pro_cat_name == 'Boxing Display CasesActive')*/
         if(pro_cat_name.includes('Display Cases') || pro_cat_name.includes('Display Case') || pro_cat_name.includes('Display Solution') || pro_cat_name.includes('Display Box'))
      {
         $('.product_display_choices_section').css('display','block');
         $('.has_size').hide();
         $('.has_sizes_section').hide();
      }
      else
      {
         $('.product_display_choices_section').css('display','none');
      }
    

    $('.cat_id').on('change', function() {
      var cat_id = $(this).find(':selected').attr('data-id');
      if(cat_id == 1)
      {
         $('#color_id').prop("required",true);
         $('.has_color_section').show();
         $('.has_color').show();
      }
      else
      {
         $('#color_id').prop("required", false);
         $('#color_id').val('');
         $('.has_color_section').hide();
         $('.has_color').hide();
      }

      var pro_cat_name = $(this).find(':selected').text();
     /*if(pro_cat_name == 'Golf Display Cases' || pro_cat_name == 'Football Display Cases' || pro_cat_name == 'Baseball Display Cases'|| pro_cat_name == 'Boxing Display Cases')*/


      if(pro_cat_name.includes('Display Cases') || pro_cat_name.includes('Display Case') || pro_cat_name.includes('Display Solution') || pro_cat_name.includes('Display Box'))
      {
         $('.product_display_choices_section').css('display','block');
         $('.has_size').hide();
         $('.has_sizes_section').hide();
      }
      else
      {
         $('.product_display_choices_section').css('display','none');
      }
    });

  })
</script>
<script type="text/javascript">
   $(document).ready(function() {
    $('.member_status').change(function() {
      if ($(this).prop('checked')) {
          var status = 1;
          var member_id = $(this).data('member-id');
          $.ajax({  
           type:"POST",  
           dataType : 'json',
           url:"<?php echo base_url('products/update_member_status') ?>",  
           data:"status="+status+'&member_id='+member_id,  
           beforeSend: function(data){ 
              $('#status').css('display','block'); 
             $('#status').html('...');
          },  
          success: function(response){ 
             $('#status').html(response.msg);
             setTimeout(function(){
              $('#status').css('display','none');
               $('#status').html('');
             },4000);
          }  
        });
      }
      else 
      {
          var status = 0;
          var member_id = $(this).data('member-id');
          $.ajax({  
           type:"POST",  
           dataType : 'json',
           url:"<?php echo base_url('products/update_member_status') ?>",  
           data:"status="+status+'&member_id='+member_id,  
           beforeSend: function(data){  
            $('#status').css('display','block'); 
             $('#status').html('...');
          },  
          success: function(response){ 
             $('#status').html(response.msg);
             setTimeout(function(){
                $('#status').css('display','none');
               $('#status').html('');
             },4000);
          }  
        });
      }
    });
  });

 /* if($('#chart-line').length) {
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);
    
    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    new Chart(ctx1, {
      type: "line",
      data: {
        labels: <?php //echo json_encode($last_days_members) ?>,
        datasets: [{
          label: "Pre-Register-Count",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: <?php //echo json_encode($member_pre_registered_count) ?>,
          // data: [50,40],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#fbfbfb',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#ccc',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });      
  }
*/
  /* if($('#member-collection-chart-line').length) {
      var ctx2 = document.getElementById("member-collection-chart-line").getContext("2d");

    var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);
    
    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    new Chart(ctx2, {
      type: "line",
      data: {
        labels: <?php //echo json_encode($last_days_members) ?>,
        datasets: [{
          label: "Collection Count",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: <?php //echo json_encode($member_pre_registered_count) ?>,
          // data: [50,40],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#fbfbfb',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#ccc',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
   }*/
    

 

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
          $('#multiple').select2({
            allowClear: true
        });

         $('.multiple-selects').select2({
          multiple: true,
         });
       });
      </script>
</body>

</html>
