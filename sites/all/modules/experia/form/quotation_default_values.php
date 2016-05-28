<?php
function quotation_default_values($form, &$form_state){
  global $base_url;
  $form = array();
  $form['work_scope'] = array(
    '#type' => 'text_format',
    '#format' => 'full_html',
    '#title' => 'Scope of Work',
    '#wysiwyg' => true,
    '#value' => variable_get('work_scope',''),
    '#prefix' => '<p>',
    '#suffix' => '</p>',
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
  
  $form['terms_and_conditions'] = array(
    '#type' => 'text_format',
    '#format' => 'full_html',
    '#title' => 'Terms and Conditions',
    '#wysiwyg' => true,
    '#value' => variable_get('terms_and_conditions',''),
    '#prefix' => '<p>',
    '#suffix' => '</p>',
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
  
  $form['warranty'] = array(
    '#type' => 'text_format',
    '#format' => 'full_html',
    '#title' => 'Warranty',
    '#wysiwyg' => true,
    '#value' => variable_get('warranty',''),
    '#prefix' => '<p>',
    '#suffix' => '</p>',
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
  
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => 'Save',  
  );
  return $form;
}

function quotation_default_values_submit($form, &$form_state) {
  $input = $form_state['input'];
  variable_set('work_scope', $input['work_scope']['value']);
  variable_set('header', $input['header']['value']);
  variable_set('terms_and_conditions', $input['terms_and_conditions']['value']);
  variable_set('exclusion', $input['exclusion']['value']);
  variable_set('warranty', $input['warranty']['value']);
  variable_set('conclusion', $input['conclusion']['value']);
  variable_set('the_contents', $input['the_contents']['value']);
  drupal_set_message('Default Values Saved');
}