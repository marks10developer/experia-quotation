<?php global $base_url; ?>
<?php global $user; ?>
<html>
  <head>
    <style type="text/css">
      .quotation-html{
        width: 600px;
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
    </style>
  </head>
<body>
<div class="quotation-html">
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
  Dear Sir/Madam, <br /><br />
  To comply with your requirements, we are herewith submitting our proposal for the above subject as follows:<br />
  <br />
  <h4>ITEM I: SUPPLY</h4>
  <table border="1" class="supply-items" width="100%">
    <tr>
      <th>QTY</th>
      <th>DESCRIPTION</th>
      <th>MODEL</th>
      <th>SRP</th>
      <th>DISCOUNTED PRICE</th>
      <th>TOTAL</th>
    </tr>
  <?php
    $grand_total = 0;
    foreach($_POST['aircon_quantity'] as $id => $quantity){
      $aircon_details = node_load($id);
      $model = isset($aircon_details->field_model_number['und']) ? $aircon_details->field_model_number['und'][0]['value'] : '';
      $brand_id = isset($aircon_details->field_brand['und']) ? $aircon_details->field_brand['und'][0]['value'] : '';
      $brand_load = node_load($brand_id);
      $price = (float) $aircon_details->field_price['und'][0]['value'];
      $discount = (float) $brand_load->field_discount['und'][0]['value'];
      $discount_price = $price - ($price * ($discount / 100));
      $total = $discount_price * intval($quantity);
      $grand_total += $total;
  ?>
    <tr>
      <td><?php echo $quantity; ?></td>
      <td><?php echo $aircon_details->title; ?></td>
      <td><?php echo $model; ?></td>
      <td><?php echo number_format($price,2); ?></td>
      <td><?php echo number_format($discount_price,2); ?></td>
      <td><?php echo number_format($total,2); ?></td>
    </tr>
  <?php } ?>
  </table>
  <table>
    <tr>
      <td width="700" style="text-align: right;">
        <h4>SUPPLY COST: <?php echo number_format($grand_total ,2); ?></h4>
      </td> 
    </tr>
  </table>

  <br /> 
  <?php if(!empty($_POST['installation_total'][0])){ ?>
  <h4>ITEM I: INSTALLATION</h4>
  <table border="1" class="installation-items">
    <tr>
      <th>LOCATION</th>
      <th>DESCRIPTION</th>
      <th>UNIT</th>
      <th>TOTAL</th> 
    </tr>
  <?php
    $installation_cost = 0;
    foreach($_POST['installation_location'] as $key => $value){
    $installation_cost += (float) $_POST['installation_total'][$key];
    $grand_total += (float) $_POST['installation_total'][$key];
    
  ?>
    <tr>
      <td><?php echo $value; ?></td>
      <td><?php echo $_POST['installation_description'][$key]; ?></td>
      <td><?php echo $_POST['installation_unit'][$key]; ?></td>
      <td><?php echo number_format($_POST['installation_total'][$key],2); ?></td> 
    </tr>
  <?php } ?>
  </table>
  <table>
    <tr>
      <td width="700" style="text-align: right;">
        <h4>INSTALLATION COST: <?php echo number_format($installation_cost ,2); ?></h4>
      </td> 
    </tr>
  </table>
  <?php } ?>
  
  <table>
    <tr>
      <td width="700" style="text-align: right;">
        <h3>TOTAL COST: <?php echo number_format($grand_total,2); ?></h3>
      </td> 
    </tr>
  </table>
  
  <?php if(!empty($_POST['work_scope']['value'])){ ?>
    <h4>SCOPE OF WORK:</h4>
    <?php echo $_POST['work_scope']['value']; ?>
  <?php } ?>
  <br />
  <?php if(!empty($_POST['terms_and_conditions']['value'])){ ?>
    <h4>TERMS AND CONDITIONS:</h4>
    <?php echo $_POST['terms_and_conditions']['value']; ?>
  <?php } ?>
  
  <?php if(!empty($_POST['exclusion']['value'])){ ?>
    <h4>EXCLUSION:</h4>
    <?php echo $_POST['exclusion']['value']; ?>
  <?php } ?>
  
  <?php if(!empty($_POST['warranty']['value'])){ ?>
  <h4>WARRANTY:</h4>
  <?php echo $_POST['warranty']['value']; ?>
  <?php } ?>
  
  <?php if(!empty($_POST['conclusion']['value'])){ ?>
  <?php echo $_POST['conclusion']['value']; ?>
  <?php } ?>
</div>
<br /> <br /> <br /> <br /> 

<table>
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
</body>
</html>