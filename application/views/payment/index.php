<?php 
//CHECKSUM Request GET
        $data['CHECKSUM'] = explode('&', $getOrdersData['payment_request'])[3];
        $data['CHECKSUM'] = explode('=', $data['CHECKSUM'])[1];
       
        //payment Request ID GET
         $data['PAY_REQUEST_ID'] = explode('&', $getOrdersData['payment_request'])[1];
        $data['PAY_REQUEST_ID'] = explode('=', $data['PAY_REQUEST_ID'])[1];
        
      $htmlForm = '<form action="https://secure.paygate.co.za/payweb3/process.trans"  method="POST" >
                    <input type="hidden" name="PAY_REQUEST_ID" value=\''.$data['PAY_REQUEST_ID'].'\'>
                    <input type="hidden" name="CHECKSUM"  value=\''.$data['CHECKSUM'].'\'>';
    
        $htmlForm .= '<input type="submit" class="btn btn-success btnpayment" value="Pay Now" style="display:none" ></form>';
        

          echo $htmlForm;


 ?>

 <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
<script type="text/javascript">

  $(document).ready(function(){
 $('.btnpayment').click();
});

</script>