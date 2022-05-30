<!-- Header -->
    <div class="container mt-3">
  <div id="accordion">
    <div class="card">
      <div class="card-header text-center">
        <a class="card-link" data-toggle="collapse" href="#shipping">
         Member Information
        </a>
      </div>
      <div id="shipping" class="collapse show" data-parent="#accordion">
        <div class="card-body">
          <div class="row col-md-12">
                <?php if(!empty($MemberInfo->profile_picture)):?>
                  <div class="col-lg-12 text-center">
                     <h3 class="mt-2"><a target="_blank" href="<?php echo config_item('FRONT_BASE_URL')."assets/img/members/profile_pictures/".$MemberInfo->profile_picture ?>"><img src="<?php echo config_item('FRONT_BASE_URL')."assets/img/members/profile_pictures/".$MemberInfo->profile_picture ?>" height="150" width="150"></a></h3>
                  </div>
                <?php endif; ?>
                  <div class="col-lg-4 mt-2">
                     <h3>Full name :  <?php echo $MemberInfo->first_name." ".$MemberInfo->last_name ?></h3>
                  </div>
                  <div class="col-lg-4 mt-2">
                     <h3>Email :  <?php echo $MemberInfo->email?></h3>
                  </div>
                  <div class="col-lg-4 mt-2">
                     <h3>Country :  <?php echo !empty($MemberInfo->country) ?  $this->Members_model->getCountryName($MemberInfo->country) : 'N/A'?></h3>
                  </div>
                  <div class="col-lg-4">
                     <h3>State :  <?php echo !empty($MemberInfo->state) ? $MemberInfo->state : 'N/A'?></h3>
                  </div>
                  <div class="col-lg-4">
                     <h3>City :  <?php echo !empty($MemberInfo->city) ? $MemberInfo->city : 'N/A'?></h3>
                  </div>
                  <div class="col-lg-4">
                     <h3>ZipCode :  <?php echo !empty($MemberInfo->zipcode) ? $MemberInfo->zipcode : 'N/A'?></h3>
                  </div>
                  <div class="col-lg-4">
                     <h3>Street Address :  <?php echo !empty($MemberInfo->street_address) ? $MemberInfo->street_address : 'N/A'?></h3>
                  </div>
                  <div class="col-lg-4">
                     <h3>Favourite Team :  <?php echo !empty($MemberInfo->favourite_team) ? $MemberInfo->favourite_team : 'N/A'?></h3>
                  </div>
                </div>
        </div>
      </div>
    </div>
  </div>
</div>

      
      