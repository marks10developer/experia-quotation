<?php
function quotation_step_2($form, &$form_state, $params){
  global $base_url;
  $form = array();
  //$form['#action'] = $base_url . '/experia/quotation/step-3';

  $form['customer'] = array(
    '#type' => 'select',
    '#title' => 'Customer',
    '#options' => experia_get_customers_list(), 
    '#attributes' => array(
      'class' => array("custom-select"),  
      'id' => 'customer',
    ),
    '#suffix' => '<div><a href="'.$base_url.'/node/add/customers">+ Add new Customer</a></div><br />'
  );

  $form['header'] = array(
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => 'Header',
      '#wysiwyg' => true,
      '#value' => variable_get('header',''),
      '#prefix' => '<p>',
      '#suffix' => '</p>',
  );
  
    $form['the_contents'] = array(
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => 'Contents',
      '#wysiwyg' => true,
      '#value' => variable_get('the_contents',''),
      '#prefix' => '<p>',
      '#suffix' => '</p>',
    );
  
  if(isset($params['aircons']) && !empty($params['aircons'])){
    $form['table'] =  array(
      '#type' => 'markup',
      '#markup' => '<div class="form-item form-type-select form-item-supply-items">
          <label for="">Item I. Supply:</label>
        </div>
      <table class="views-table sticky-enabled cols-7 tableheader-processed sticky-table supply-table">
      <tr>
        <th>Quantity</th>
        <th>Discount %</th>
        <th>Description</th>
        <th>Model</th>
        <th>SRP</th>
        <th>Discounted Price</th>
        <th>Total</th>
      </tr>'
    );

    foreach($params['aircons'] as $key => $aircon){
      $aircon_details = node_load($aircon);
      $model = isset($aircon_details->field_model_number['und']) ? $aircon_details->field_model_number['und'][0]['value'] : '';
      $item_code = isset($aircon_details->field_item_code['und']) ? $aircon_details->field_item_code['und'][0]['value'] : '';
      $brand_id = isset($aircon_details->field_brand['und']) ? $aircon_details->field_brand['und'][0]['value'] : '';
      $brand_load = node_load($brand_id);
      $price = (float) $aircon_details->field_price['und'][0]['value'];
      
      $form['markup_start_' . $key ] =  array(
         '#type' => 'markup',
         '#markup' => '<tr>'
      );
      
      $form['aircon_quantity['.$aircon_details->nid.']'] = array(
        '#type' => 'select',
        //'#title' => 'Quantity',
        '#options' => array_combine( range(1,30), range(1,30)),
        '#attributes' => array(
          'class' => array("custom-select"),  
          'id' => 'aircon-quantity',

        ),
        '#prefix' => '<td>',
        '#suffix' => '</td>',
      );
      /*$form['aircon_discount_percentage['.$aircon_details->nid.']'] = array(
        '#type' => 'textfield',
        //'#title' => 'Quantity',
        '#attributes' => array(
          'class' => array("custom-select"),  
          'id' => 'aircon-discount-percentage',
          'size' => 2,
          'maxlength' => 2,
          'maxvalue' => $brand_load->field_discount['und'][0]['value']
        ),
        '#value' => $aircon['aircon_discount_percentage'],  
        '#prefix' => '<td>',
        '#suffix' => '</td>',
      );*/
      
      $form['aircon_discount_percentage['.$aircon_details->nid.']'] = array(
        '#type' => 'select',
        //'#title' => 'Quantity',
        '#attributes' => array(
          'class' => array("custom-select"),
          'id' => 'aircon-discount-percentage',
        ),
        '#options' => range(0,$brand_load->field_discount['und'][0]['value']), 
        '#prefix' => '<td>',
        '#suffix' => '</td>',
      );
      $form['markup_customer_title_' . $key ] =  array(
         '#type' => 'markup',
         '#markup' => '<span>'.$aircon_details->title.'</span>',
          '#prefix' => '<td>',
          '#suffix' => '</td>',
      );

      $form['markup_model_' . $key ] =  array(
         '#type' => 'markup',
         '#markup' => '<span>'.$item_code.'</span>',
          '#prefix' => '<td>',
          '#suffix' => '</td>',
      );
      
      $form['markup_srp_' . $key ] =  array(
         '#type' => 'markup',
         '#markup' => '<span id="srp" data="'.$price.'">'. number_format($price,2) .'</span>',
          '#prefix' => '<td>',
          '#suffix' => '</td>',
      );
      //$discount = (float) $brand_load->field_discount['und'][0]['value'];
      //$discount_price = $price - ($price * ($discount / 100));
      $discount_price = $price;
      $form['markup_discounted_' . $key ] =  array(
         '#type' => 'markup',
         '#markup' => '<span id="discounted" data="'.$discount_price.'">'. number_format($discount_price,2) .'</span>',
          '#prefix' => '<td>',
          '#suffix' => '</td>',
      );
      
      $form['markup_total_' . $key ] =  array(
         '#type' => 'markup',
         '#markup' => '<span id="total" data="'.$discount_price.'">'. number_format($discount_price,2) .'</span>',
          '#prefix' => '<td>',
          '#suffix' => '</td>',
      ); 
      
      
      $form['markup_end_' . $key ] =  array(
         '#type' => 'markup',
         '#markup' => '</tr>'
      ); 
    }
    $form['table_end'] =  array(
       '#type' => 'markup',
       '#markup' => '</table>'
    );
    $form['supply_cost'] =  array(
       '#type' => 'markup',
       '#markup' => '<div class="supply-cost"><h2>Total Supply Amount</h2><h2 class="total-cost" id="supply_cost"></h2></div>'
    );
    $form['equipment_note'] = array(
      '#type' => 'textfield',
      '#title' => 'Equipment Note',
      '#size' => 100,
      '#attributes' => array(
        'class' => array("custom-select"),  
        'id' => 'equipment-note',
        'name' => 'equipment_note',
        'maxlength' => '2000',
      ),
      '#prefix' => '<p>',
      '#suffix' => '</p>',
    );
  }else{
    drupal_goto('experia/quotation/step-1');
  }

  
  $form['table_2'] =  array(
     '#type' => 'markup',
     '#markup' => '<div class="form-item form-type-select form-item-installation-items">
          <label for="">Item II. Installation:</label>
        </div>
        <table class="views-table sticky-enabled cols-7 tableheader-processed sticky-table" id="installation-table">'
  );
  $form['table_2_head'] =  array(
     '#type' => 'markup',
     '#markup' => '<tr>
        <th>Location</th>
        <th>Description</th>
        <th>Qty</th>
        <th>Amount</th>
        <th>Total</th>
        <th>&nbsp;</th>
      </tr>'
  ); 
  
  $form['table_2_items'] =  array(
     '#type' => 'markup',
     '#markup' => '<tr id="installation-items">'
  );
  $form['installation_location'] = array(
    '#type' => 'textfield',
    '#size' => 25,
    '#attributes' => array(
      'class' => array("custom-select"),  
      'id' => 'installation-location',
      'name' => 'installation_location[]'
    ),
    '#prefix' => '<td>',
    '#suffix' => '</td>',
  );
  
 
  $form['installation_description'] = array(
    '#type' => 'textfield',
    '#size' => 60,
    '#attributes' => array(
      'class' => array("custom-select"),  
      'id' => 'installation-quantity',
      'name' => 'installation_description[]'
    ),
    '#prefix' => '<td>',
    '#suffix' => '</td>',
  );
  
  $form['installation_qty' . $key] = array(
    '#type' => 'select', 
    '#attributes' => array(
      'class' => array("custom-select"),  
      'id' => 'installation-qty',
      'name' => 'installation_qty[]'
    ),
    '#prefix' => '<td>',
    '#options' => array_combine( range(1,100), range(1,100)),
    '#suffix' => '</td>', 
  );
  
  $form['installation_unit'] = array(
    '#type' => 'textfield',
    '#size' => 15,
    '#attributes' => array(
      'class' => array("custom-select"),  
      'id' => 'installation-unit',
      'name' => 'installation_unit[]',
      'onkeyup' => 'restrictNumberOnly(this);'
    ),
    '#prefix' => '<td>',
    '#suffix' => '</td>',
  );
  
  $form['installation_total'] = array(
    '#type' => 'textfield',
    '#size' => 15,
    '#attributes' => array(
      'class' => array("custom-select"),  
      'id' => 'installation-total',
      'name' => 'installation_total[]',
      'onkeyup' => 'installationTotalAction(this);',
      'readonly' => 'true',
    ),
    '#prefix' => '<td><span id="installation-total-item">0.00</span>',
    '#suffix' => '</td>',
  );
  
  $form['installation_remove'] =  array(
     '#type' => 'markup',
     '#markup' => '<td><a href="#" id="remove-installation" onclick="return removeInstallationItem(this);">Remove</a></td>'
  );
  
  $form['table_2_items_end'] =  array(
     '#type' => 'markup',
     '#markup' => '</tr>'
  );
  
  $form['table_2_end'] =  array(
     '#type' => 'markup',
     '#markup' => '</table>'
  );
  
  $form['installation_add'] =  array(
     '#type' => 'markup',
     '#markup' => '<a href="#" id="add-installation">Add Installation</a>'
  );
  
  
  $form['installation_cost'] =  array(
     '#type' => 'markup',
     '#markup' => '<div class="installation-cost"><h2>Total Installation Amount</h2><h2 class="total-cost">0.0</h2></div>'
  );
  
  $form['installation_note'] = array(
    '#type' => 'textfield',
    '#title' => 'Installation Note',
    '#size' => 100, 
    '#attributes' => array(
      'class' => array("custom-select"),  
      'id' => 'installation-note', 
      'maxlength' => '2000',
      'name'=>'installation_note'
    ),
    '#prefix' => '<p>',
    '#suffix' => '</p>',
  );
  
  $form['grand_total_cost'] =  array(
     '#type' => 'markup',
     '#markup' => '<div class="grand-total-cost"><h2>Total Contract Amount</h2><h2 class="total-cost">0.0</h2></div>'
  );
    
  $form['work_scope'] = array(
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => 'Scope of Work',
      '#wysiwyg' => true,
      '#value' => variable_get('work_scope',''),
      '#prefix' => '<p>',
      '#suffix' => '</p>',
    );
    $form['show_work_scope'] = array(
      '#type' => 'checkbox', 
      '#title' => 'Show Scope of Work', 
      '#default_value' => '1'
    );
    
    $form['terms_and_conditions'] = array(
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => 'Terms and Conditions',
      '#wysiwyg' => true,
      '#value' => variable_get('terms_and_conditions',''),
      '#prefix' => '<p>',
      '#suffix' => '</p>',
    );
    $form['show_terms_and_conditions'] = array(
      '#type' => 'checkbox', 
      '#title' => 'Show Terms and Conditions', 
      '#default_value' => '1'
    );
    
    $form['exclusion'] = array(
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => 'Exclusion',
      '#wysiwyg' => true,
      '#value' =>  variable_get('exclusion',''),
      '#prefix' => '<p>',
      '#suffix' => '</p>',
    );
    
    $form['show_exclusion'] = array(
      '#type' => 'checkbox', 
      '#title' => 'Show Exclusion', 
      '#default_value' => '1'
    );
    
    $form['warranty'] = array(
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => 'Warranty',
      '#wysiwyg' => true,
      '#value' => variable_get('warranty',''),
      '#prefix' => '<p>',
      '#suffix' => '</p>',
    );
    
    $form['show_warranty'] = array(
      '#type' => 'checkbox', 
      '#title' => 'Show Warranty', 
      '#default_value' => '1'
    );
    
    $form['conclusion'] = array(
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => 'Conclusion',
      '#wysiwyg' => true,
      '#value' => variable_get('conclusion',''),
      '#prefix' => '<p>',
      '#suffix' => '</p>',
    );
    
    $form['show_conclusion'] = array(
      '#type' => 'checkbox', 
      '#title' => 'Show Conclusion', 
      '#default_value' => '1'
    );
  

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => 'Request Approval',  
  );
  return $form;
}


function quotation_step_2_submit($form, &$form_state){
    global $base_url;
    global $user;
    $input = $form_state['input'];
    
    
    $aircon_details_array = array();
    $installation_details = array();
    foreach($input['aircon_quantity'] as $key => $data){
      $aircon_details_array[$key]['aircon_quantity'] = $data;
      $aircon_details_array[$key]['aircon_discount_percentage'] = $input['aircon_discount_percentage'][$key];
    }
    foreach($input['installation_location'] as $key => $data){
      $installation_details[$key]['installation_location'] = $data;
      $installation_details[$key]['installation_description'] = $input['installation_description'][$key];
      $installation_details[$key]['installation_qty'] = $input['installation_qty'][$key];
      $installation_details[$key]['installation_unit'] = $input['installation_unit'][$key];
      $installation_details[$key]['installation_total'] = $input['installation_total'][$key];
    }
     
    
    ob_start();
    require_once(dirname(__FILE__).'/../templates/quotation/quotation-html.tpl.php');
    $content = ob_get_contents();
    ob_clean();
    $customer_load = node_load($input['customer']);
    
    $node = new stdClass();
    $node->title = 'Quotation for ' . $customer_load->title;
    $node->status = 1;
    if(in_array('manager',$user->roles) || in_array('administrator',$user->roles)){
      $node->field_status['und'][0]['value'] = 'Approved';
    }else{
      $node->field_status['und'][0]['value'] = 'Waiting Approval';
    }
    
    
    $node->body['und'][0]['value'] = $content;
    $node->field_aircons_details['und'][0]['value'] = serialize($aircon_details_array);
    $node->field_installation_details['und'][0]['value'] = serialize($installation_details);
    $node->field_scope_of_work['und'][0]['value'] = $input['work_scope']['value'];  
    $node->field_header['und'][0]['value'] = $input['header']['value'];
    $node->field_the_contents['und'][0]['value'] = $input['the_contents']['value'];
    $node->field_terms_and_conditions['und'][0]['value'] = $input['terms_and_conditions']['value'];
    $node->field_exclusion['und'][0]['value'] = $input['exclusion']['value'];
    $node->field_warranty['und'][0]['value'] = $input['warranty']['value'];
    $node->field_conclusion['und'][0]['value'] = $input['conclusion']['value']; 
    $node->body['und'][0]['value'] = $content;
   
    $node->field_show_work_scope['und'][0]['value'] = $input['show_work_scope'];
    $node->field_show_terms_and_conditions['und'][0]['value'] = $input['show_terms_and_conditions'];
    $node->field_show_exclusion['und'][0]['value'] = $input['show_exclusion'];
    $node->field_show_warranty['und'][0]['value'] = $input['show_warranty'];
    $node->field_show_conclusion['und'][0]['value'] = $input['show_conclusion'];
    $node->field_installation_note['und'][0]['value'] = $input['installation_note'];
    $node->field_equipment_note['und'][0]['value'] = $input['equipment_note'];
    $node->created = time();
    $node->type = 'quotation';
    
    $node->uid = $user->uid;
    node_save($node);
    drupal_set_message('Approval Request has been sent to Quotation Approver');
    drupal_goto($base_url . '/experia/quotation?field_status_value=All');
     
}