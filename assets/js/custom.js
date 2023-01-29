    // ====DECREMENT PRODUCTS====
    $('.product_qty').click(function(e) {
      e.preventDefault();

      var qty = $(this).closest('.cart-form').find('.product_qty').val();

      var value = parseInt(qty, 10);
        value = isNaN(value) ? 0 : value;
        if (value < 101) {
            value++;
          $(this).closest('.cart-form').find('.product_qty').val(value);
      }
  });

  $('.product_qty').click(function(e) {
   e.preventDefault();

   var qty = $(this).closest('.cart-form').find('.product_qty').val();

   var value = parseInt(qty, 10);
   value = isNaN(value) ? 0 : value;
   if (value > 1) {
       value--;
       $(this).closest('.cart-form').find('.product_qty').val(value);
   }
});