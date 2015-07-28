<?php
  global $base_url;
?>
<div>
  <?php
    $params = array(
      'aircons' => $aircons,                
    );
    $form = drupal_get_form('quotation_step_2', $params);
    echo drupal_render($form);
  ?>
 
</div>