<?php
function experia_get_brands(){
  $list = db_select('node','n')
  ->fields('n',array('nid','title'))
  ->condition('type', 'brands')
  ->condition('status', '1')
  ->execute();
  return $list; 
}

function experia_get_brands_list(){
  $list = array();
  foreach(experia_get_brands() as $brand){
    $list[$brand->nid] = $brand->title;
  }
  return $list; 
}

function experia_get_aircon_types(){
  $list = db_select('node','n')
  ->fields('n',array('nid','title'))
  ->condition('type', 'aircon_types')
  ->condition('status', '1')
  ->execute();
  return $list; 
}

function experia_get_aircon_types_list(){
  $list = array();
  foreach(experia_get_aircon_types() as $type){
    $list[$type->nid] = $type->title;
  }
  return $list; 
}

function experia_get_customers(){
  $list = db_select('node','n')
  ->fields('n',array('nid','title'))
  ->condition('type', 'customers')
  ->condition('status', '1')
  ->orderBy('title', 'ASC') 
  ->execute();
  return $list; 
}

function experia_get_customers_list(){
  $list = array();
  foreach(experia_get_customers() as $type){
    $list[$type->nid] = $type->title;
  }
  return $list; 
}
