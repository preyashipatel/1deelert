require(["jquery"], function(jQuery) {

  jQuery(document).ready(function(){
    jQuery("input[name='product_val']").val(0);
    var productArraywords = jQuery('#flashsale_productArray').attr('name');
    jQuery('#flashsale_product_selected_value').val(productArraywords);
  })
   // jQuery Solution for the checking checked radio for solving update issue - Bhupendra
  jQuery(document).on('change', '[type=checkbox]', function() {
        var productArray = JSON.parse(jQuery('#flashsale_productArray').attr('name'));
        var checked_value = jQuery(this).val();
        
        if (jQuery(this).prop('checked') == true) {
          productArray.push(checked_value); 
        }else{
          productArray = jQuery.grep(productArray, function(value) {
            return value != checked_value;
          });
        }
        
        productArray = productArray.filter(function(elem, index, self) {
          return index === self.indexOf(elem);
        });
        productArray =  JSON.stringify(productArray);
        jQuery('#flashsale_productArray').attr('name',productArray);
        jQuery('#flashsale_product_selected_value').val(productArray);
        jQuery("input[name='product_val']").val(1);
  });
});
