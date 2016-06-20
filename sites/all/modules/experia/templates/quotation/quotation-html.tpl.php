<?php global $base_url; ?>
<?php global $user; ?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
      .quotation-html{
        width: 100%;
      }
      table{
        width: 100%;
      }
      table.header{
        margin: 0 auto; 
      }

      table.header span{ 
        margin-left: 15px;
        margin-bottom: 15px;
      }
      table.supply-items, table.installation-items{
        text-align: center;
      }
      table.supply-items td,
      table.supply-items th,
      table.installation-items td,
      table.installation-items th{
        padding: 5px;
        word-wrap: break-word;
        word-break: break-all;
      }
      .header ul{
        list-style-type: none;
      }
      .table-header{
        background: #538dd5;
        text-align: center;
        padding: 10px 0;
      }
    </style>
  </head>
<body>
<div class="quotation-html">
  <div class="cover">
    <img src="<?php echo $base_url . '/' . drupal_get_path('module','experia') . '/images/cover.jpg' ?>" width="720" height="960"  />
  </div>
  
 <?php $customer_details = node_load($_POST['customer']); ?>
  <table class="header">
    <tr>
      <td> 
        <img src="<?php echo $base_url . '/' . drupal_get_path('module','experia') . '/images/front-logo.jpg' ?>" width="100" height="100"  />
      </td>
      <td> 
          <?php echo $_POST['header']['value']; ?>
      </td>
    </tr>
  </table>
  <br />
  
  <b>DATE: <?php echo date('d-M-Y'); ?></b> <br />
  <b>ATTENTION:</b> <?php echo $customer_details->field_contact_person['und'][0]['value']; ?><br />
  <b>COMPANY:</b> <?php echo $customer_details->title; ?><br />
  <b>ADDRESS:</b> <?php echo $customer_details->field_address['und'][0]['value']; ?><br />
  <b>TEL NO.:</b> <?php echo $customer_details->field_contact_number['und'][0]['value']; ?><br />
  <b>SUBJECT: </b> Proposal for the Supply and Installation of Air-conditioning Units. <br />
  <br />
  <br />
  <table width="720"> 
    <tr>
      <td> <?php echo $_POST['the_contents']['value']; ?></td>
    </tr>
  </table>
  <br /> 
  <table border="1" class="supply-items" width="720">
    <tr>
      <th colspan="100" class="table-header">ITEM I: SUPPLY</th>
    </tr>
    <tr>
      <th style="width:20px">QTY</th>
      <th style="width:200px">DESCRIPTION</th>
      <th style="width:70px">MODEL</th>
      <th style="width:90px">SRP</th>
      <th style="width:90px">DISCOUNTED PRICE</th>
      <th style="width:90px">TOTAL</th>
    </tr>
  <?php
    $grand_total = 0;
    foreach($_POST['aircon_quantity'] as $id => $quantity){
      $aircon_details = node_load($id);
      $model = isset($aircon_details->field_model_number['und']) ? $aircon_details->field_model_number['und'][0]['value'] : '';
      $item_code = isset($aircon_details->field_item_code['und']) ? $aircon_details->field_item_code['und'][0]['value'] : '';
      //$brand_id = isset($aircon_details->field_brand['und']) ? $aircon_details->field_brand['und'][0]['value'] : '';
      //$brand_load = node_load($brand_id);
      $price = (float) $aircon_details->field_price['und'][0]['value']; 
      //$discount = (float) $brand_load->field_discount['und'][0]['value'];
      $discount = (int) $_POST['aircon_discount_percentage'][$id]; 
      $discount_price = $price - ($price * ($discount / 100));
      $total = $discount_price * intval($quantity);
      $grand_total += $total;
  ?>
    <tr>
      <td style="width:20px;word-wrap: break-word;"><?php echo $quantity; ?></td>
      <td style="width:200px;word-wrap: break-word;"><?php echo $aircon_details->title; ?></td>
      <td style="width:70px;word-wrap: break-word;"><?php echo chunk_split($item_code,7,'<br >'); ?></td>
      <td style="width:90px;word-wrap: break-word;"><?php echo number_format($price,2); ?></td>
      <td style="width:90px;word-wrap: break-word;"><?php echo number_format($discount_price,2); ?></td>
      <td style="width:90px;word-wrap: break-word;"><?php echo number_format($total,2); ?></td>
    </tr>
  <?php } ?>
  </table>
  <table>
    <tr>
      <td width="700" style="text-align: right;">
        <h4>TOTAL SUPPLY AMOUNT: <?php echo number_format($grand_total ,2); ?></h4>
      </td> 
    </tr>
  </table>

  <br /> 
  <?php if(!empty($_POST['installation_total'][0])){ ?>
  
  <table border="1" class="installation-items">
    <tr>
      <th colspan="100" class="table-header">ITEM I: INSTALLATION</th>
    </tr>
    <tr>
      <th style="width:200px">LOCATION</th>
      <th style="width:200px">DESCRIPTION</th>
      <th style="width:100px">UNIT</th>
      <th style="width:100px">TOTAL</th> 
    </tr>
  <?php
    $installation_cost = 0;
    foreach($_POST['installation_location'] as $key => $value){
    $installation_cost += (float) $_POST['installation_total'][$key];
    $grand_total += (float) $_POST['installation_total'][$key];
    
  ?>
    <tr>
      <td style="width:200px;word-wrap: break-word;"><?php echo $value; ?></td>
      <td style="width:200px;word-wrap: break-word;"><?php echo $_POST['installation_description'][$key]; ?></td>
      <td style="width:100px;word-wrap: break-word;"><?php echo $_POST['installation_unit'][$key]; ?></td>
      <td style="width:100px;word-wrap: break-word;"><?php echo number_format($_POST['installation_total'][$key],2); ?></td> 
    </tr>
  <?php } ?>
  </table>
  <table>
    <tr>
      <td width="700" style="text-align: right;">
        <h4>TOTAL INSTALLATION AMOUNT: <?php echo number_format($installation_cost ,2); ?></h4>
      </td> 
    </tr>
  </table>
  <?php } ?>
  
  <table>
    <tr>
      <td width="700" style="text-align: right;">
        <h3>TOTAL CONTRACT AMOUNT: <?php echo number_format($grand_total,2); ?></h3>
      </td> 
    </tr>
  </table>
  
  <?php if(!empty($_POST['work_scope']['value']) && isset($_POST['show_work_scope'])){ ?> 
    <table width="720">
      <tr>
        <th border="1" colspan="100" class="table-header">SCOPE OF WORK:</th>
      </tr>
      <tr>
        <td><?php echo $_POST['work_scope']['value']; ?></td>
      </tr>
    </table>
    
  <?php } ?>
  <br />
  <?php if(!empty($_POST['terms_and_conditions']['value']) && isset($_POST['show_terms_and_conditions'])){ ?>
    
    <table width="720">
      <tr>
        <th border="1" colspan="100" class="table-header">TERMS AND CONDITIONS:</th>
      </tr>
      <tr>
        <td><?php echo $_POST['terms_and_conditions']['value']; ?></td>
      </tr>
    </table>
    
  <?php } ?>
  
  <?php if(!empty($_POST['exclusion']['value']) && isset($_POST['show_exclusion'])){ ?> 
    <table width="720">
      <tr>
        <th border="1" colspan="100" class="table-header">EXCLUSION:</th>
      </tr>
      <tr>
        <td><?php echo $_POST['exclusion']['value']; ?></td>
      </tr>
    </table>
    
  <?php } ?>
  
  <?php if(!empty($_POST['warranty']['value']) && isset($_POST['show_warranty'])){ ?>
  <table width="720">
    <tr>
      <th border="1" colspan="100" class="table-header">WARRANTY:</th>
    </tr>
    <tr>
      <td><?php echo $_POST['warranty']['value']; ?></td>
    </tr>
  </table>
  
  <?php } ?>
  
  <?php if(!empty($_POST['conclusion']['value']) && isset($_POST['show_conclusion'])){ ?>
  <table width="720"> 
    <tr>
      <td><?php echo $_POST['conclusion']['value']; ?></td>
    </tr>
  </table>
  
  <?php } ?>
  
<br /> <br /> <br /> <br /> <br /> 
<table width="720">
  <tr>
    <td width="520">
      <p>Very Truly Yours,</p> 
      <p>
        <?php
          $firstname = isset($user->data['firstname']) ? $user->data['firstname'] : '';
          $lastname = isset($user->data['lastname']) ? $user->data['lastname'] : '';
          $position = isset($user->data['position']) ? $user->data['position'] : '';
        ?><br> 
        <b><?php echo $firstname; ?> <?php echo $lastname; ?></b><br><br>
        <?php echo $position; ?>
      </p>
    
    </td>
    <td>
      <p>Conforme:</p><br>
      <p>Signature Over Printed Name:</p> 
    </td>
  </tr>
</table>

</div>



</body>
</html>