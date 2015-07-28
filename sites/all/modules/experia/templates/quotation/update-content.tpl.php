<?php
  global $base_url;
?>
<div>
  <?php
    $params = array(
      'nid' => $nid,                
    );
    $form = drupal_get_form('update_content', $params);
    echo drupal_render($form);
  ?>
 
</div>