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
      .brand-total{ 
        text-align: right;
      }
      .signatures p{
        line-height: 0px;
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
      <td style="vertical-align: middle;"> 
        <img src="<?php echo $base_url . '/' . drupal_get_path('module','experia') . '/images/front-logo.jpg' ?>" width="270" height="50"  />
      </td>
      <td> 
          <?php echo $_POST['header']['value']; ?>
      </td>
    </tr>
  </table>
  <br /> 
   
  <table width="720">
    <tr>
      <th width="120">DATE:</th>
      <td><?php echo date('d-M-Y'); ?></td>
    </tr>
    <tr>
      <th width="120">COMPANY NAME :</th>
      <td><?php echo $customer_details->title; ?></td>
    </tr>
    <tr>
      <th width="120">ADDRESS :</th>
      <td><?php echo $customer_details->field_address['und'][0]['value']; ?></td>
    </tr>
    <tr>
      <th width="120">TEL NO. :</th>
      <td><?php echo $customer_details->field_contact_number['und'][0]['value']; ?></td>
    </tr>
    <tr>
      <th width="120">SUBJECT :</th>
      <td>Proposal for Supply and Installation of Airconditioning Units for</td>
    </tr>
  </table>
  
  <br />
 
  <table width="720"> 
    <tr>
      <td> <?php echo $_POST['the_contents']['value']; ?></td>
    </tr>
  </table>
  <br />
  
  <table border="1" class="supply-items" width="720">
    <tr>
      <th colspan="100" class="table-header">ITEM I: EQUIPMENTS</th>
    </tr>
    <?php
      $grand_total = 0;
      $aircons_list = array();
      foreach($_POST['aircon_quantity'] as $id => $quantity){
        $aircon_details = node_load($id);
        $brand_id = isset($aircon_details->field_brand['und']) ? $aircon_details->field_brand['und'][0]['value'] : '';
        $brand_load = node_load($brand_id);
        $price = (float) $aircon_details->field_price['und'][0]['value'];  
        $discount = (int) $_POST['aircon_discount_percentage'][$id]; 
        $discount_price = $price - ($price * ($discount / 100));
        $total = $discount_price * intval($quantity);
        $grand_total += $total;
        $aircon_details->_quantity = $quantity;
        $aircons_list[$brand_load->title][] = array(
          'aircon_details' => $aircon_details              
        );
      }
    ?>
      
      <?php
      if(!empty($aircons_list)){
        $index = 0;
        foreach($aircons_list as $brand => $aircons){ $index++;
      ?>
      <tr><th colspan="20">OPTION <?php echo $index; ?> : <?php echo strtoupper($brand); ?></th></tr>
      <tr>
        <th style="width:20px">QTY</th>
        <th style="width:110px">DESCRIPTION</th>
        <th style="width:160px">MODEL</th>
        <th style="width:90px">SRP</th>
        <th style="width:90px">DISCOUNTED<br/>CASH PRICE</th>
        <th style="width:90px">TOTAL</th>
      </tr>
      
      <?php
      $brand_total = 0;
      foreach($aircons as $aircon) {
        $aircon_details = $aircon['aircon_details']; 
        $model = isset($aircon_details->field_model_number['und']) ? $aircon_details->field_model_number['und'][0]['value'] : '';
        $item_code = isset($aircon_details->field_item_code['und']) ? $aircon_details->field_item_code['und'][0]['value'] : '';
        $price = (float) $aircon_details->field_price['und'][0]['value'];  
        $discount = (int) $_POST['aircon_discount_percentage'][$id]; 
        $discount_price = $price - ($price * ($discount / 100));
        $total = $discount_price * intval($aircon_details->_quantity);
        $brand_total += $total;
      ?>
      <tr>
        <td style="width:20px;word-wrap: break-word;"><?php echo $aircon_details->_quantity; ?></td>
        <td style="width:110px;word-wrap: break-word;"><?php echo (stristr($aircon_details->title, ' ') === FALSE) ? chunk_split($aircon_details->title,20,'<br >') : $aircon_details->title; ?></td>
        <td style="width:160px;word-wrap: break-word;"><?php echo chunk_split($item_code,20,'<br >'); ?></td>
        <td style="width:90px;word-wrap: break-word;"><?php echo number_format($price,2); ?></td>
        <td style="width:90px;word-wrap: break-word;"><?php echo number_format($discount_price,2); ?></td>
        <td style="width:90px;word-wrap: break-word;"><?php echo number_format($total,2); ?></td>
      </tr> 
      <?php } ?>  
      <tr><th colspan="20" class="brand-total">TOTAL SUPPLY AMOUNT: <?php echo number_format($brand_total,2);?></th></tr>
    <?php } ?>
      <?php if(isset($_POST['equipment_note']) && !empty($_POST['equipment_note'])) { ?>
      <tr>
        <td colspan="100"><?php echo $_POST['equipment_note']; ?></td>
      </tr>
      <?php } ?>
  <?php } ?>

  </table>
  
  <?php /* <table>
    <tr>
      <td width="700" style="text-align: right;">
        <h4>TOTAL SUPPLY AMOUNT: <?php echo number_format($grand_total ,2); ?></h4>
      </td> 
    </tr>
  </table> */ ?>

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
      <th style="width:110px">TOTAL</th> 
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
      <td style="width:110px;word-wrap: break-word;"><?php echo number_format($_POST['installation_total'][$key],2); ?></td> 
    </tr>
  <?php } ?>
    <?php if(isset($_POST['installation_note']) && !empty($_POST['installation_note'])) { ?>
    <tr>
      <td colspan="100"><?php echo $_POST['installation_note']; ?></td>
    </tr>
    <?php } ?>
    <tr>
      <th colspan="20" style="text-align: right;">
        TOTAL INSTALLATION AMOUNT: <?php echo number_format($installation_cost ,2); ?> 
      </th> 
    </tr>
  </table>
 
  <?php } ?>
  
  <?php /* <table>
    <tr>
      <td width="700" style="text-align: right;">
        <h3>TOTAL CONTRACT AMOUNT: <?php echo number_format($grand_total,2); ?></h3>
      </td> 
    </tr>
  </table> */ ?> 
  <br /> 
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
  <div class="signatures">
   <?php echo variable_get('signatures',''); ?>
  </div>
</div>



</body>
</html>