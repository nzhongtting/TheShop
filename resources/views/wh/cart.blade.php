<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>The Shop</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicons -->
  <link href="{{ asset('wh/assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('wh/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('wh/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('wh/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('wh/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('wh/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('wh/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('wh/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('wh/assets/css/style.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: MeFamily - v4.3.0
  * Template URL: https://bootstrapmade.com/family-multipurpose-html-bootstrap-template-free/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="/products">The Shop</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="{{ asset('wh/assets/img/logo.png') }}" alt="" class="img-fluid"></a>-->
      <?php
      $activateMenu = ['activate' => "gallery"]
      ?>
      @include('wh.theshop_topmenu',$activateMenu)

    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

      <div class="d-flex justify-content-between align-items-center">
          
        <h2>Cart</h2>

          <ol>
            <li><a href="/products">Home</a></li>
            <li>Cart</li>
          </ol>

      </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section id="Cart" class="gallery">
    <div class="container" id="gallery_list_box">


    <table class="table ">
  <thead class="table-dark">
    <tr>
      <th scope="col">Product</th> 
      <th scope="col">Price</th>
      <th scope="col">Quantity</th>
      <th scope="col">Remove</th>     
      <th scope="col">Total</th>

    </tr>
  </thead>
  <tbody class="table-group-divider">


  @if(!empty($test) && $test->count())

  @foreach($test as $column)
    <tr class="product">
      <th scope="row">{{$column->name}}</th>
      <td class="product-price">{{$column->amount}}</td>
      <td class="product-quantity"><input type="number" class="list-item {{$column->id}}" id="list-item-number" value="{{$column->quantity}}" min="1" style="width:50px"></td>
      <td class="product-removal">

        <button class="remove-product btn btn-warning"  onclick="tmpRemove({{$column->id}})" >
            Remove
          </button>        
      </td>
      @php
      // Apply a 20% discount when ordering 2 or more - by Thomas Hong
        $amount = 0 ;
        if($column->quantity >=2) { $amount = $column->amount - ( $column->amount * 0.2 ) ; }
        else { $amount = $column->amount; }
      @endphp

      <td class="product-line-price">{{number_format($amount * $column->quantity,2)}}</td>
    </tr>
    @endforeach
    @else

    @endif

    <tr class="totals">
      <td class="table-primary"> Grand Total  </td>
      <td class="totals-item table-primary" >
        <div class="totals-value" id="cart-total">0</div>
      </td>

      <td class="totals-item">
        <label>Shipping</label>
        <div class="totals-value" id="cart-shipping">25.00</div>
      </td>
      
      <td class="totals-item table-info">
      <label>Tax (5%)</label>
      <div class="totals-value" id="cart-tax">0</div>
      </td>

      <td class="totals-item totals-item-total">
        <label>Subtotal</label>
        <div class="totals-value" id="cart-subtotal">0</div> 
      </td>

    </tr>
  </tbody>
</table>

<iframe name="hiddenZone" src="" width="0" height="0" style="display:none"></iframe>
<form class="form-inline" id="checkOutFrm" name="checkOutFrm" action="{{ route('Cart.checkout') }}">
@csrf
@method('PATCH')


  <div class="form-group">
    <label for="firstname">First name</label>
    <input type="text" class="form-control" id="firstname" name="firstname">
  </div>
  <div class="form-group">
    <label for="lastname">Last name</label>
    <input type="text" class="form-control" id="lastname" name="lastname">
  </div>
  <div class="form-group">
    <label for="inputemail">Email</label>
    <input type="email" class="form-control" id="inputemail" name="inputemail" placeholder="test@test.com">
  </div>
   
  <div style="padding-top: 20px;">
  <button type="button" class="btn btn-success" style="float:right;" onclick="checkoutRun()">Checkout</button>
  </div>
  <input type=hidden id="finalyCartlist" name="finalyCartlist">
  <input type=hidden id="grandTotal" name="grandTotal">
  <input type=hidden id="shippingPrice" name="shippingPrice">
  <input type=hidden id="tAx" name="tAx">
  <input type=hidden id="subTotal" name="subTotal">

</form>

<input type=hidden id="tmpid" name="tmpid">
</div>
    </section><!-- End Gallery Section -->

</main><!-- End #main -->

@include('wh.theshop_footer')  
<script src="{{ asset('wh/assets/js/cart.js?var=03032023') }}"></script>
<script>
    $( document ).ready(function() {
    recalculateCart();
});

function tmpRemove(id)
{
    $('#tmpid').val(id);
}

function removeCart()
{
                // console.log( "run removecart()" );

                $.ajaxSetup({
                headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });

                var cartobj = {};
                cartobj.id = $('#tmpid').val();
                $.ajax({
                type:'POST',
                dataType:"json",
                url:'{{ route('Cart.removeCart') }}',
                data:cartobj,
                success:function(data) {
                  $("#result_cnt").html("("+data.result_cnt+")");
                }
                });
}

function checkoutRun()
{

    F	= document.checkOutFrm ;

    var email = F.inputemail.value ;
	var exptext = /^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/;


    if( $("#cart-total").html()    !='0.00')
    {

        if( F.firstname.value == '' )
        {
            alert('Input the First Name');
            F.firstname.focus();
        }
        else if( F.lastname.value == '' )
        {
            alert('Input the Last Name');
            F.lastname.focus();
        }
        else if(exptext.test(email)==false)
        {
            alert('Please enter a valid email')
            F.inputemail.focus();
        }
        else
        {

            var action_choice = [];
            $.makeArray($(".list-item").map(function(){
            var class_list 	= $(this).attr("class") ;
            var id_list     = $(this).val();
            var cutlist		= class_list.split(" ");
            var sumValue		= cutlist[1] + "/" + id_list ;
            action_choice.push(sumValue);
        }));
        
        $("#finalyCartlist").val(action_choice);
        $("#grandTotal").val($("#cart-total").html());
        $("#shippingPrice").val($("#cart-shipping").html());
        $("#tAx").val($("#cart-tax").html());
        $("#subTotal").val($("#cart-subtotal").html());


        F.target = "hiddenZone";
        F.submit();

        }

    } else { alert('There are no items in cart'); }




}
</script>
</body>
</html>