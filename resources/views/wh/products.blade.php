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
          
        <h2>Product > test</h2>

          <ol>
            <li><a href="/products">Home</a></li>
            <li>Products</li>
          </ol>

      </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery">
      <div class="container" id="gallery_list_box">

    <div class="row">
      <div class="col-md-10">{!! $test->appends(request()->all())->links() !!}</div>
      <div class="col-md-2">

      </div>
    </div>

		<div class="row gallery-container">

        @if(!empty($test) && $test->count())

        @foreach($test as $column)
        <div class="col-lg-4 col-md-6 gallery-item filter-{{$column->title}}">
        <div class="gallery-wrap">
          <img src="/wh/assets/img/sample_img_red.jpg" class="img-fluid" alt="">
          <div class="gallery-info">
            <p>SKU : {{$column->sku}}</p>

            <div class="gallery-links">
                <a href="javascript:addtocart({{$column->sku}})" title="{{$column->name}}"><i class="bx bx-cart" style="font-size:100px"></i></a>
            </div>

          </div>
        </div>

        <div class="course-content">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>{{$column->name}}</h4>
            <p class="price">${{$column->amount}}</p>
          </div>
          <p>
          @php
          $SLen = strlen($column->description);
          @endphp
          {{ \Illuminate\Support\Str::substr($column->description,0,40) }}  
          @if( $SLen > 40 )
          <i class="bx bx-comment-add" data-bs-toggle="modal" data-bs-target="#smallModal_{{$column->sku}}" style="color: red;"></i>
          <div class="modal fade" id="smallModal_{{$column->sku}}" tabindex="-1" aria-hidden="true" style="display: none;">
          <div class="modal-dialog modal-sm"><div class="modal-content"><div class="modal-header">
            <h3 class="modal-title">Description</h3> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <div class="modal-body"><h5>{{$column->name}}</h5> <br> {{$column->description}}</div><div class="modal-footer"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> 
            </div></div></div></div>          
          @else
          @endif
          </p>
          <div class="trainer d-flex justify-content-between align-items-center">
          </div>
        </div>        

        </div>
        @endforeach
        @else
        No Data !
        @endif

		</div>
        {!! $test->appends(request()->all())->links() !!}
    </section><!-- End Gallery Section -->

  </main><!-- End #main -->

  @include('wh.theshop_footer')  

</body>
<style>
.moretip {
    position: relative;
    display: inline-block;
}

.moretip .tip {
    visibility: hidden;
    width: 200px;
    background: #333;
    color: #fff;
    font-weight: bold;
    text-align: center;
    padding: 5px;
    border-radius: 7px;
 
    position: absolute;
    z-index: 10;
    top: -10px;
    left: 120%;

    opacity: 0;
}

.moretip .tip::after {
    content: "";
    position: absolute;
    border-top: 6px solid transparent;
    border-right: 6px solid #333;
    border-bottom: 6px solid transparent;
    border-left: 6px solid transparent;
    top: 31%;
    right: 100%;
}

.moretip:hover .tip {
    visibility: visible;
    opacity: 1;
    transition: opacity 0.7s;
}
</style>
<script>
function addtocart(sku)
{
    $.ajaxSetup({
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

    var productsobj = {};
    productsobj.sku = sku;
    $.ajax({
               type:'POST',
               dataType:"json",
               url:'/addCartByPro',
               data:productsobj,
               success:function(data) {
                  $("#result_cnt").html("("+data.result_cnt+")");
                  alert(data.msg);
               }
            });

}
</script>
</html>
