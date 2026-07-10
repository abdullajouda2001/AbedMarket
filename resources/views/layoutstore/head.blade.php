<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Abed Market</title>

  <!--
    - favicon
  -->
  <link rel="shortcut icon" href="{{asset('assets/images/logo/favicon.ico')}}" type="image/x-icon">

  <!--
    - custom css link
  -->
  <link rel="stylesheet" href="{{asset('assets/css/style-prefix.css')}}">

  <!--
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

</head>

<body>


  <div class="overlay" data-overlay></div>

  <!--
    - MODAL
  -->

  <!-- <div class="modal" data-modal>

    <div class="modal-close-overlay" data-modal-overlay></div>

    <div class="modal-content">

      <button class="modal-close-btn" data-modal-close>
        <ion-icon name="close-outline"></ion-icon>
      </button>

      <div class="newsletter-img">
        <img src="{{(asset('assets/images/newsletter.png'))}}" alt="subscribe newsletter" width="400" height="400">
      </div>

      <div class="newsletter">

        <form action="#">

          <div class="newsletter-header">

            <h3 class="newsletter-title">Subscribe Newsletter.</h3>

            <p class="newsletter-desc">
              Subscribe the <b>Anon</b> to get latest products and discount update.
            </p>

          </div>

          <input type="email" name="email" class="email-field" placeholder="Email Address" required>

          <button type="submit" class="btn-newsletter">Subscribe</button>

        </form>

      </div>

    </div>

  </div> -->





  <!--
    - NOTIFICATION TOAST
  -->
<!-- 
  <div class="notification-toast" data-toast>

    <button class="toast-close-btn" data-toast-close>
      <ion-icon name="close-outline"></ion-icon>
    </button>

    <div class="toast-banner">
      <img src="{{asset('assets/images/products/jewellery-1.jpg')}}" alt="Rose Gold Earrings" width="80" height="70">
    </div>

    <div class="toast-detail">

      <p class="toast-message">
        Someone in new just bought
      </p>

      <p class="toast-title">
        Rose Gold Earrings
      </p>

      <p class="toast-meta">
        <time datetime="PT2M">2 Minutes</time> ago
      </p>

    </div>

  </div> -->





  <!--
    - HEADER
  -->

  <header>

    <div class="header-top">

      <div class="container">


    </div>

    <div class="header-main">

      <div class="container">

        <a href="{{route('home')}}" class="header-logo">
            <h1>عابد ماركت </h1>   
      
      </a>

       <form action="{{ route('products.search.public') }}" method="GET" class="header-search-container">
    <input type="search" name="query" class="search-field" placeholder="ابحث عن منتج...">
    <button type="submit" class="search-btn">
        <ion-icon name="search-outline"></ion-icon>
    </button>
</form>

        <div class="header-user-actions">

          <a href="{{ auth()->check() ? route('client.dashboard') : route('client.login') }}" class="action-btn">
    <ion-icon name="person-outline"></ion-icon>
</a>
          <!-- <button class="action-btn">
            <ion-icon name="heart-outline"></ion-icon>
            <span class="count">0</span>
          </button> -->

       <a href="{{ route('cart.index') }}" class="action-btn" style="text-decoration: none; color: inherit; position: relative;">
    <ion-icon name="bag-handle-outline"></ion-icon>
    {{-- نحسب عدد المنتجات في السلة لعرضها في العداد --}}
    <span class="count">{{ count(session('cart', [])) }}</span>
</a>

        </div>

      </div>

    </div>



    </nav>

  </header>

