<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - The Shop Admin</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('wh/admin/assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('wh/admin/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('wh/admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('wh/admin/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('wh/admin/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('wh/admin/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('wh/admin/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('wh/admin/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('wh/admin/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('wh/admin/assets/css/style.css') }}" rel="stylesheet">
   
  <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="/AdminPage" class="logo d-flex align-items-center">
        <img src="{{ asset('wh/admin/assets/img/logo.png') }}" alt="">
        <span class="d-none d-lg-block">The Shop</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->


    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{ asset('wh/admin/assets/img/loginphoto.jpg') }}" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li class="dropdown-header">
                <h6>User Name : {{ Auth::user()->name }}</h6>
                </li>

                <li>
                <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="/products"><i class="bi bi-box-arrow-right"></i><span>Customer</span></a>
                </li>
                <li>
                <hr class="dropdown-divider">
                </li>
                <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Sign Out</span>
                </a>
                </li>
          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link @if($uri =='AdminPage') {} @else{ collapsed } @endif" href="/AdminPage">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->


      <li class="nav-item"> 
        <a class="nav-link @if($uri =='ListProducts') {} @else{ collapsed } @endif" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#" aria-expanded="true"> 
        <i class="bi bi-gem"></i>
          <span>Products</span>
        <i class="bi bi-chevron-down ms-auto"></i> 
        </a>
          <ul id="icons-nav" class="nav-content collapse @if($uri =='ListProducts') { show } @else{ } @endif" data-bs-parent="#sidebar-nav" style="">
            <li> 
            <a href="/ListProducts" @if($uri =='ListProducts') { class="active" } @else{ } @endif > 
            <i class="bi bi-circle"></i>
            <span>List Product</span> </a>
            </li>

            <li> 
            <a href="#"> 
            <i class="bi bi-circle"></i>
            <span>Category</span> </a>
            </li>

          </ul>
      </li> 

      <li class="nav-item">
        <a class="nav-link @if($uri =='ListCart') {} @else{ collapsed } @endif" href="/ListCart">
          <i class="bi bi-hand-thumbs-up"></i>
          <span>List Cart</span>
        </a>
      </li><!-- End CART Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">
	@yield('content')
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>The Shop</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('wh/admin/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('wh/admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('wh/admin/assets/vendor/chart.js/chart.min.js') }}"></script>
  <script src="{{ asset('wh/admin/assets/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('wh/admin/assets/vendor/quill/quill.min.js') }}"></script>
  <script src="{{ asset('wh/admin/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('wh/admin/assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('wh/admin/assets/vendor/php-email-form/validate.js') }}"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('wh/admin/assets/js/main.js') }}"></script>

</body>

</html>