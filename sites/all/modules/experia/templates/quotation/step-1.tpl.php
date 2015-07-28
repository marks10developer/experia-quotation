<?php
global $base_url;
?>
<form action="" method="get">

  <div id="edit-title-wrapper" class="views-exposed-widget views-widget-filter-title">
    <label for="edit-title">Title</label>
    <div class="views-widget">
      <div class="form-item form-type-textfield form-item-title">
        <input  value="<?php echo isset($_GET['title']) ? $_GET['title'] : '' ; ?>" type="text" id="edit-title" name="title" value="" size="22" maxlength="128" class="form-text">
      </div>
    </div>
  </div>
  

  <div id="edit-title-wrapper" class="views-exposed-widget views-widget-filter-title">
    <label for="edit-brand">Brand</label>
    <div class="views-widget">
      <div class="form-item form-type-textfield form-item-title">
        <select id="edit-brand" name="brand" class="form-select">
          <option value="">All</option>
          <?php foreach(experia_get_brands_list() as $id => $brand){
          $brand_value = isset($_GET['brand']) ? $_GET['brand'] : '' ;
          $selected = ($id == $brand_value) ? 'selected="selected"' : '';
          ?>
            <option <?php echo $selected; ?> value="<?php echo $id; ?>"><?php echo $brand; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
  </div>
  
  <div id="edit-title-wrapper" class="views-exposed-widget views-widget-filter-title">
    <label for="edit-item-code">Item Code</label>
    <div class="views-widget">
      <div class="form-item form-type-textfield form-item-title">
        <input  value="<?php echo isset($_GET['item_code']) ? $_GET['item_code'] : '' ; ?>" type="text" id="edit-item-code" name="item_code" value="" size="20" maxlength="128" class="form-text">
      </div>
    </div>
  </div>
  
  <div id="edit-title-wrapper" class="views-exposed-widget views-widget-filter-title">
    <label for="edit-model-number">Model Number</label>
    <div class="views-widget">
      <div class="form-item form-type-textfield form-item-title">
        <input  value="<?php echo isset($_GET['model_number']) ? $_GET['model_number'] : '' ; ?>" type="text" id="edit-model-number" name="model_number" value="" size="20" maxlength="128" class="form-text">
      </div>
    </div>
  </div>
  
  <div id="edit-title-wrapper" class="views-exposed-widget views-widget-filter-title">
    <label for="edit-capacity">Capacity (HP)</label>
    <div class="views-widget">
      <div class="form-item form-type-textfield form-item-title">
        <input  value="<?php echo isset($_GET['capacity']) ? $_GET['capacity'] : '' ; ?>" type="text" id="edit-capacity" name="capacity" value="" size="5" maxlength="128" class="form-text">
      </div>
    </div>
  </div>
  
<?php
$price_range = array(
  1000,
  5000,
  10000,
  20000,
  30000,
  50000,
  100000,
  250000,
  500000,
  1000000,
  2000000
);
?>
  <div id="edit-title-wrapper" class="views-exposed-widget views-widget-filter-title">
    <label for="edit-price-range-min">Price Range</label>
    <div class="views-widget">
      <div class="form-item form-type-textfield form-item-title">
        <select id="edit-price-range-min" name="price_range_min" class="form-select">
          <option value="">Min Price</option>
          <?php
          foreach($price_range as $price){
            $min_value = isset($_GET['price_range_min']) ? $_GET['price_range_min'] : '' ;
            $selected = ($min_value == $price) ? 'selected="selected"' : '';
          ?>
            <option <?php echo $selected; ?> value="<?php echo $price; ?>"><?php echo number_format($price,0,'',','); ?></option>
          <?php } ?>
        </select>
        -
        <select id="edit-price-range-max" name="price_range_max" class="form-select">
          <option value="">Max Price</option>
          <?php
          foreach($price_range as $price){
            $max_value = isset($_GET['price_range_max']) ? $_GET['price_range_max'] : '' ;
            $selected = ($max_value == $price) ? 'selected="selected"' : '';
          ?>
            <option <?php echo $selected; ?> value="<?php echo $price; ?>"><?php echo number_format($price,0,'',','); ?></option>
          <?php } ?>
        </select> 
      </div>
    </div>
  </div>
 
  
  <div id="edit-title-wrapper" class="views-exposed-widget views-widget-filter-title">
    <label for="edit-title">&nbsp;</label>
    <div class="views-widget">
      <div class="form-item form-type-textfield form-item-title">
        <input type="submit" value="Filter" class="form-submit" />
      </div>
    </div>
  </div>
</form>

<br /> <br /><br /> <br /><br /> <br />
<a href="<?php echo $base_url; ?>/node/add/aircons">+ Add New Aircons</a>
<form action="<?php echo $base_url; ?>/experia/quotation/step-2" method="get">
<?php
  $view = views_get_view('aircons');	 
  $view->set_display('default');
  $view->pre_execute();
  $view->execute();
  if($view->total_rows > 0){
    echo $view->render();
    echo '<input type="submit" id="edit-submit" value="Continue >" class="form-submit">';
  }else{
    echo '<center><h1>No Result</h1></center>';
  }
 
?>
  
</form>