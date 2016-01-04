var $ = jQuery;
$(document).ready(function(){
  
  updateTotalCost(); 
  if ($('a#remove-installation').length == 1) {
    $('a#remove-installation').hide();
  }else{
    $('a#remove-installation').show();
  }
  
  $('select#aircon-quantity').change(function(){
    calculateSubTotalAction(this);
  });
  
  $('select#installation-qty').change(function(){
      var index = $(this).index('select#installation-qty');
      var amount = $('#installation-table #installation-unit').eq(index).val();
      calculateInstallationQtyAndAmt($(this).val(),amount,index);
  });
  
  $('input#installation-unit').keyup(function(){
      var index = $(this).index('input#installation-unit'); 
      var qty = $('#installation-table select#installation-qty').eq(index).val();
      calculateInstallationQtyAndAmt(qty,$(this).val(),index);
  });
  
  $('select#aircon-discount-percentage').on('change',function(){
    /*var value = 0;
    if (!isNaN($(this).val())) {
      value = parseInt($(this).val());
    }
    
    if (value > parseInt($(this).attr('maxvalue'))) {
      $(this).val($(this).attr('maxvalue'));
    }*/
    //restrictNumberOnly(this);
    calculateSubTotalAction(this);
  });
  
  $('select#aircon-quantity').trigger('change');
  $('select#aircon-discount-percentage').trigger('change');
  
  $('#add-installation').on('click',function(e){
    e.preventDefault();
    var new_item = '<tr id="installation-items">' + $('#installation-items:first').html() + '</tr>';
    
    $('#installation-table').append( new_item );
    if ($('form').attr('id') == 'quotation-step-2') {
      $('#installation-table').find('span#installation-total-item:last').html('0.00');
    }
    
    
    $('select#installation-qty').change(function(){
      var index = $(this).index('select#installation-qty');
      var amount = parseInt($('#installation-table #installation-unit').eq(index).val());
      calculateInstallationQtyAndAmt($(this).val(),amount,index);
    });
    
    $('input#installation-unit').keyup(function(){
        var index = $(this).index('input#installation-unit');
       
        var qty = $('#installation-table select#installation-qty').eq(index).val();
        calculateInstallationQtyAndAmt(qty,$(this).val(),index);
    });
    
    $('#installation-table #installation-total').trigger('keyup'); 
    $('a#remove-installation').show(); 
  });
  
  
  $('form#views-exposed-form-all-quotation-default').attr('action','');
  
  //$('.views-widget select#edit-type option[value="quotation"]').remove();
  //$('.views-widget select#edit-type option[value="All"]').remove();
  $('a[href="/node/add/quotation"]').parents('li').hide();
  
  $('select#edit-price-range-min').change(function(){
    var min_value = 0;
    if (!isNaN($(this).val()) && $(this).val() != '') {
      min_value = parseInt($(this).val());
    }
    
    $('select#edit-price-range-max option').each(function(i,o){
      var max_value = 0;
      if (!isNaN($(o).attr('value')) && $(o).attr('value') != '') {
        max_value = parseInt($(o).attr('value'));
      }
      if (max_value < min_value) {
        $(o).hide();
      }else {
        $(o).show();
      }
      $(this).parents('select').val(max_value);
      if ($(o).attr('value') == '') {
        $(o).show();
      }
    });
  });
  
  $('input#aircons-item').change(function(){
    alert($(this).is(':checked'));
    
  });
});

function calculateInstallationQtyAndAmt(qty,amount,index) {
  var quantity = parseFloat(qty);
  var item_amount = parseFloat(amount);
  var total = quantity * item_amount; 
  
  $('#installation-table #installation-total').eq(index).val(total);
  $('#installation-table #installation-total-item').eq(index).text(total.formatMoney(2,'.',','));
  $('#installation-table #installation-total').eq(index).trigger('keyup');
}  


function calculateSubTotalAction(elem) {
    var quantity = parseInt($(elem).parents('tr').find('select#aircon-quantity').val());
    var discount_pct = 0;
    var price = parseFloat($(elem).parents('tr').find('span#srp').attr('data'));
    
    if (!isNaN($(elem).parents('tr').find('select#aircon-discount-percentage').val()) && $(elem).parents('tr').find('select#aircon-discount-percentage').val() != '') {
      discount_pct = parseInt($(elem).parents('tr').find('select#aircon-discount-percentage').val());
    }

    var discounted_price = price - (price * (discount_pct / 100));
    var total = discounted_price * quantity;
    $(elem).parents('tr').find('span#discounted').text(discounted_price.formatMoney(2,'.',','));
    $(elem).parents('tr').find('span#discounted').attr('data',discounted_price);
    
    $(elem).parents('tr').find('span#total').text(total.formatMoney(2,'.',',')); 
    $(elem).parents('tr').find('span#total').attr('data',total);
    updateTotalCost();
}

function installationTotalAction(elem) {
  restrictNumberOnly(elem);
  updateTotalCost();
}

function restrictNumberOnly(elem){
  var text = '';
  for(var i=0;i<$(elem).val().length;i++){
    var value = $(elem).val();
    if (isFloat(value[i]) !== null) {
      text += value[i];
    }
  }
  
  if (isFloat($(elem).val()) === null) {
    $(elem).val(text); 
  } 
}

function updateTotalCost() {
  var total = 0;
  var supply_cost = 0;
  var installation_cost = 0;
  $('span#total').each(function(i,o){
    total += parseFloat($(o).attr('data'));
    supply_cost += parseFloat($(o).attr('data'));
  });
  
  $('input#installation-total').each(function(i,o){
    if ($(o).val() != "") {
      total += parseFloat($(o).val());
      installation_cost += parseFloat($(o).val());
    } 
  });
  
  $('.supply-cost .total-cost').text( supply_cost.formatMoney(2,'.',',') );
  $('.installation-cost .total-cost').text( installation_cost.formatMoney(2,'.',',') );
  $('.grand-total-cost .total-cost').text( total.formatMoney(2,'.',',') );
}

function removeInstallationItem(elem){
  $(elem).parents('tr#installation-items').remove();
  $('#installation-table #installation-total').trigger('keyup');
  if ($('a#remove-installation').length == 1) {
    $('a#remove-installation').hide();
  }else{
    $('a#remove-installation').show();
  }
  return false;
}

Number.prototype.formatMoney = function(c, d, t){
var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

function isFloat(value) { 
  var regExp ="^\\d+(\\.\\d+)?$";
  return value.match(regExp); 
}