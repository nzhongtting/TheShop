/* Set rates + misc */
var taxRate = 0.05;
var shippingRate = 25.00; 
var fadeTime = 300;


/* Assign actions */
$('.product-quantity input').change( function() {
  updateQuantity(this);
});

$('.product-removal button').click( function() {
  removeItem(this);
});


/* Recalculate cart */
function recalculateCart()
{
  var subtotal = 0;
  
  /* Sum up row totals */
  $('.product').each(function () {
    subtotal += parseFloat($(this).children('.product-line-price').text());
  });

  /* Init form data  */
  $("#finalyCartlist").val('');
  $("#grandTotal").val('');
  $("#shippingPrice").val('');
  $("#tAx").val('');
  $("#subTotal").val('');     

  /* Calculate totals */
  var tax = subtotal * taxRate;
  var shipping = (subtotal > 0 ? shippingRate : 0);
  var total = subtotal + tax + shipping;
  
  /* Update totals display */
  $('.totals-value').fadeOut(fadeTime, function() {
    $('#cart-subtotal').html(subtotal.toFixed(2));
    $('#cart-tax').html(tax.toFixed(2));
    $('#cart-shipping').html(shipping.toFixed(2));
    $('#cart-total').html(total.toFixed(2));
    if(total == 0){
      $('.checkout').fadeOut(fadeTime);
    }else{
      $('.checkout').fadeIn(fadeTime);
    }
    $('.totals-value').fadeIn(fadeTime);
  });
}


/* Update quantity */
function updateQuantity(quantityInput)
{
  /* Calculate line price */
  var productRow = $(quantityInput).parent().parent();
  var price = parseFloat(productRow.children('.product-price').text());
  var quantity = $(quantityInput).val();

  // Apply a 20% discount when ordering 2 or more - by Thomas Hong
  var linePrice = 0 ;  
  if( quantity >= 2 ) 
  {  
    linePrice = (price - (price * 0.2)) * quantity;
  }
  else
  {
    linePrice = price * quantity;
  }
  
  /* Update line price display and recalc cart totals */
  productRow.children('.product-line-price').each(function () {
    $(this).fadeOut(fadeTime, function() {
      $(this).text(linePrice.toFixed(2));
      recalculateCart();
      $(this).fadeIn(fadeTime);
    });
  });
}


/* Remove item from cart */
function removeItem(removeButton)
{

    ans = confirm("Do you really want to remove this?");			
    if( ans == true )
    {    

        removeCart();
        /* Remove row from DOM and recalc cart total */
        var productRow = $(removeButton).parent().parent();
        
        productRow.slideUp(fadeTime, function() {
            productRow.remove();
            recalculateCart();
        });
        
        
    }
}