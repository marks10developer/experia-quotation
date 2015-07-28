<?php
/*
 * Implements hook_menu
 */
function experia_menu(){
  $items = array();

  $items['experia/quotation'] = array(
    'title' => 'Quotations',
    'page callback' => 'experia_quotation',
    'access arguments' => array('access quotation'),
    'type' => MENU_NORMAL_ITEM,
  );

  $items['experia/quotation/step-1'] = array(
    'title' => 'Select Aircon',
    'page callback' => 'experia_quotation_step_1',
    'access arguments' => array('access quotation'),
    'type' => MENU_NORMAL_ITEM,
  );
  
  $items['experia/quotation/step-2'] = array(
    'title' => 'Quotations Details',
    'page callback' => 'experia_quotation_step_2',
    'access arguments' => array('access quotation'),
    'type' => MENU_NORMAL_ITEM,
  );
  
  $items['experia/quotation/update-content'] = array(
    'title' => 'Quotations Details',
    'page callback' => 'experia_quotation_update_content',
    'access arguments' => array('access quotation'),
    'type' => MENU_NORMAL_ITEM,
  );
  
  $items['experia/quotation/step-3'] = array(
    'title' => 'Quotations Step 3',
    'page callback' => 'experia_quotation_step_3',
    'access arguments' => array('access quotation'),
    'type' => MENU_NORMAL_ITEM,
  );
  
  
  $items['experia/quotation/preview/pdf/%node'] = array(
    'title' => 'Quotations Preview PDF',
    'page callback' => 'experia_quotation_preview_pdf',
    'access arguments' => array('access quotation'),
    'page arguments' => array(4),
    'type' => MENU_NORMAL_ITEM,
  );
  
  $items['experia/quotation/default_values'] = array(
    'title' => 'Quotations Default Values',
    'page callback' => 'drupal_get_form',
    'page arguments' => array('quotation_default_values'),
    'access arguments' => array('access quotation'),
    'type' => MENU_NORMAL_ITEM,
  );
  return $items;
}

/*
 * Implements hook_theme
 */
function experia_theme(){
  return array(
    'experia_quotation' => array(
      'template' => 'main',
      'path' => drupal_get_path('module', 'experia') . '/templates/quotation'
    ),
    'experia_quotation_step_1' => array(
      'template' => 'step-1',
      'path' => drupal_get_path('module', 'experia') . '/templates/quotation'
    ),
    'experia_quotation_step_2' => array(
      'template' => 'step-2',
      'path' => drupal_get_path('module', 'experia') . '/templates/quotation'
    ),
    'experia_quotation_update_content' => array(
      'template' => 'update-content',
      'path' => drupal_get_path('module', 'experia') . '/templates/quotation'
    )
  );
}


/*
 * Implements hook_theme
 */
function experia_permission() {
  return array(
    'access quotation' => array(
      'title' => t('Access Quotation'),
      'description' => t('Perform Quotation Access.'),
    ),
  );
}

/**
 * Implements hook_form_alter
 */
function experia_form_alter(&$form, &$form_state, $form_id)  {
  
  if($form_id == 'user_profile_form' || $form_id == 'user_register_form'){
    $firstname = '';  $lastname = '';  $position = '';
    if(isset($form_state['user']->data)){
      if(isset($form_state['user']->data['firstname'])){
        $firstname = $form_state['user']->data['firstname'];
      }
      if(isset($form_state['user']->data['lastname'])){
        $lastname = $form_state['user']->data['lastname'];
      }
      if(isset($form_state['user']->data['position'])){
        $position = $form_state['user']->data['position'];
      }
    }
    
    $form['account']['firstname'] = array(
      '#type' => 'textfield',
      '#value' => $firstname,
      '#title' => 'Firstname',
      '#weight' => -2,
      
      '#attributes' => array(
        'class' => array("custom-select"),  
      ),
    );
    $form['account']['lastname'] = array(
      '#type' => 'textfield',
      '#value' => $lastname,
      '#title' => 'Lastname',
      '#weight' => -1, 
      '#attributes' => array(
        'class' => array("custom-select"),  
      ),
    );
    $form['account']['position'] = array(
      '#type' => 'textfield',
      '#value' => $position,
      '#title' => 'Position',
      '#weight' => 0, 
      '#attributes' => array(
        'class' => array("custom-select"),  
      ),
    );
    $form['#submit'][] = 'experia_user_data_update_submit';
  }else if($form_id == 'quotation_node_form'){
    drupal_add_css('.field-name-body,
                   .field-name-field-aircons-details,
                   .field-name-field-installation-details,
                   .vertical-tabs,#edit-preview,#edit-delete
                   {display:none;}','inline');
    $form_state['redirect'] = '/home';
  }
}

function experia_user_data_update_submit($form, &$form_state) {
  $input = $form_state['input'];
  $user = user_load($form_state['user']->uid);
  $edit['data']['firstname'] = $input['firstname'];
  $edit['data']['lastname'] = $input['lastname'];
  $edit['data']['position'] = $input['position'];
  user_save($user, $edit);
}
 