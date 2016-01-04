<?php
function experia_quotation(){
  $params = array();
  $_SESSION['selected-aircons'] = array();
  return theme('experia_quotation',$params);
}

function experia_quotation_step_1(){
  $params = array();
  return theme('experia_quotation_step_1',$params);
}

function experia_quotation_step_2(){ 
  if(isset($_POST)){
    $selected_aircons = array();
    if(isset($_SESSION['selected-aircons'])){
       $selected_aircons = $_SESSION['selected-aircons'];
    }
    $params = array(
      'aircons' => $selected_aircons,
    );
    return theme('experia_quotation_step_2',$params);
    
  } 
}

function experia_quotation_update_content(){ 
  if(isset($_POST)){
    $params = array(
      'nid' => isset($_REQUEST['nid']) ? $_REQUEST['nid'] : array(),
    );
    return theme('experia_quotation_update_content',$params);
  } 
}

function experia_quotation_step_3(){

    ob_start();
    require_once(dirname(__FILE__).'/../templates/quotation/quotation-html.tpl.php');
    $content = ob_get_contents();
    ob_clean();
    
   require_once(dirname(__FILE__).'/../library/html2pdf/html2pdf.class.php');
    try
    { 
      $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(10, 10, 10, 10));
      //$html2pdf->setModeDebug();
      $html2pdf->setDefaultFont('Arial');
      $html2pdf->writeHTML($content);
      $html2pdf->Output('exemple00.pdf');
    }
    catch(HTML2PDF_exception $e) {
      echo $e;
      exit;
    }
    
}


function experia_quotation_preview_pdf($node){
  global $user; 
  if(in_array('administrator',$user->roles)
     || in_array('manager', $user->roles)
     || "Approved" == $node->field_status['und'][0]['value']){
    require_once(dirname(__FILE__).'/../library/html2pdf/html2pdf.class.php');
    try
    {
      
      $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(10, 10, 10, 10));
      //$html2pdf->setModeDebug();
      $html2pdf->setDefaultFont('Arial');
      $html2pdf->writeHTML($node->body['und'][0]['value']);
      $html2pdf->Output($node->title .'.pdf');
      //echo $node->body['und'][0]['value'];
    }
    catch(HTML2PDF_exception $e) {
      echo $e;
      exit;
    }
  }else{
    echo '';
  }
}

function experia_selected_aircons(){ 
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['selected']) && isset($_POST['nid'])){ 
      if($_POST['selected'] == "true"){
         if(($key = array_search($_POST['nid'], $_SESSION['selected-aircons'])) === false) {
          $_SESSION['selected-aircons'][] = $_POST['nid'];
         }
      }else{ 
        if(($key = array_search($_POST['nid'], $_SESSION['selected-aircons'])) !== false) {
            unset($_SESSION['selected-aircons'][$key]);
        }
      }
    }
  }
  var_dump($_SESSION);
}


 