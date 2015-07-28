<?php
  global $base_url;
  global $user;
?>
<div>
  
  <ul class="action-links">
    <li>
      <a href="<?php echo $base_url; ?>/experia/quotation/step-1">Create Quotation</a>
    </li>
    
    <?php if(in_array('administrator',$user->roles)){ ?>
    <li>
      <a href="<?php echo $base_url; ?>/experia/quotation/default_values">Change Quotation Variable Values</a>
    </li>
    <?php } ?>
  </ul> 
<?php
if(in_array('manager',$user->roles) || in_array('administrator',$user->roles)){
  $view = views_get_view('all_quotation');	 
  $view->set_display('default');
  $view->pre_execute();
  $view->execute();
  echo $view->render();
}else{
  $view = views_get_view('my_quotation');	 
  $view->set_display('default');
  $view->pre_execute();
  $view->execute();
  echo $view->render();
} 
?>
</div>