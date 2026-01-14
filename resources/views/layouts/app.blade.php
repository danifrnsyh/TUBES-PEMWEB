<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>THREE D - Toko Furniture Online Terpercaya</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="{{ asset('css/carousel.css') }}" rel="stylesheet">
  <style>
    :root {
      --primary-blue: #0051BA;
      --secondary-yellow: #FFCC00;
      --accent-gray: #F5F5F5;
      --dark-gray: #1A1A1A;
      --light-gray: #EBEBEB;
      --text-dark: #2C2C2C;
    }

    * {
      font-family: 'Poppins', sans-serif;
    }

    html, body {
      height: 100%;
    }

    body {
      background-color: #FFFFFF;
      color: var(--text-dark);
      display: flex;
      flex-direction: column;
    }

    main {
      flex: 1;
      padding: 3rem 0 2rem 0;
    }

    /* Navbar - IKEA Style */
    .navbar {
      background-color: #FFFFFF;
      border-bottom: 1px solid var(--light-gray);
      padding: 1rem 0;
      box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }

    .navbar-brand {
      font-weight: 700;
      font-size: 1.8rem;
      color: var(--primary-blue) !important;
      letter-spacing: -1px;
    }

    .navbar-brand i {
      margin-right: 0.5rem;
      color: var(--secondary-yellow);
    }

    .nav-link {
      color: var(--text-dark) !important;
      font-weight: 500;
      font-size: 0.95rem;
      transition: color 0.2s ease;
      margin: 0 0.8rem;
    }

    .nav-link:hover {
      color: var(--primary-blue) !important;
    }

    .dropdown-menu {
      border: none;
      box-shadow: 0 4px 12px rgba(0,0,0,0.12);
      border-radius: 6px;
    }

    .dropdown-item {
      font-weight: 500;
      color: var(--text-dark);
      transition: background-color 0.2s;
    }

    .dropdown-item:hover {
      background-color: var(--accent-gray);
      color: var(--primary-blue);
    }

    /* Cards - IKEA Minimalist */
    .card {
      border: none;
      background-color: #FFFFFF;
      box-shadow: 0 1px 3px rgba(0,0,0,0.08);
      border-radius: 8px;
      transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    .card:hover {
      box-shadow: 0 4px 12px rgba(0,0,0,0.12);
      transform: translateY(-2px);
    }

    .card-header {
      background-color: var(--primary-blue);
      color: white;
      border: none;
      border-radius: 8px 8px 0 0;
      font-weight: 600;
      padding: 1.2rem;
    }

    .card-body {
      padding: 1.5rem;
    }

    /* Buttons - IKEA Bold */
    .btn-primary {
      background-color: var(--primary-blue);
      border: none;
      font-weight: 600;
      padding: 0.7rem 1.5rem;
      border-radius: 4px;
      transition: background-color 0.2s ease;
    }

    .btn-primary:hover {
      background-color: #003D99;
      border-color: #003D99;
    }

    .btn-secondary {
      background-color: var(--light-gray);
      color: var(--text-dark);
      border: none;
      font-weight: 600;
      padding: 0.7rem 1.5rem;
      border-radius: 4px;
      transition: background-color 0.2s ease;
    }

    .btn-secondary:hover {
      background-color: #DCDCDC;
      color: var(--text-dark);
    }

    /* Product Cards */
    .product-card {
      border: none;
      background: #FFFFFF;
      border-radius: 8px;
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .product-card:hover {
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      transform: translateY(-4px);
    }

    .product-image {
      width: 100%;
      height: 280px;
      object-fit: cover;
      background: var(--accent-gray);
    }

    .product-info {
      padding: 1.5rem;
    }

    .product-name {
      font-weight: 600;
      font-size: 1.1rem;
      color: var(--text-dark);
      margin-bottom: 0.8rem;
      min-height: 2.4rem;
    }

    .product-sku {
      font-size: 0.85rem;
      color: #999;
      margin-bottom: 0.8rem;
    }

    .product-price {
      font-weight: 700;
      font-size: 1.4rem;
      color: var(--primary-blue);
      margin-bottom: 1rem;
    }

    .stock-badge {
      display: inline-block;
      padding: 0.4rem 0.8rem;
      border-radius: 4px;
      font-size: 0.8rem;
      font-weight: 600;
      margin-bottom: 1rem;
    }

    .stock-badge.in-stock {
      background-color: #E8F5E9;
      color: #2E7D32;
    }

    .stock-badge.low-stock {
      background-color: #FFF3E0;
      color: #E65100;
    }

    .stock-badge.out-of-stock {
      background-color: #FFEBEE;
      color: #C62828;
    }

    /* Footer - IKEA Clean */
    footer {
      background-color: var(--dark-gray);
      color: #FFFFFF;
      padding: 3rem 0 0;
      margin-top: auto;
      border-top: 1px solid var(--light-gray);
    }

    footer h5 {
      font-weight: 700;
      font-size: 1.1rem;
      margin-bottom: 1.5rem;
      color: var(--secondary-yellow);
    }

    footer a {
      color: rgba(255,255,255,0.7);
      text-decoration: none;
      transition: color 0.2s;
    }

    footer a:hover {
      color: var(--secondary-yellow);
    }

    footer p {
      color: rgba(255,255,255,0.7);
      font-size: 0.95rem;
      line-height: 1.6;
    }

    .footer-bottom {
      background-color: #0D0D0D;
      padding: 1.5rem 0;
      text-align: center;
      color: rgba(255,255,255,0.6);
      font-size: 0.9rem;
    }

    /* Alerts */
    .alert {
      border: none;
      border-radius: 6px;
      font-weight: 500;
    }

    .alert-success {
      background-color: #E8F5E9;
      color: #2E7D32;
      border-left: 4px solid #4CAF50;
    }

    .alert-danger {
      background-color: #FFEBEE;
      color: #C62828;
      border-left: 4px solid #F44336;
    }

    /* Headings */
    h1, h2, h3, h4, h5, h6 {
      font-weight: 700;
      color: var(--text-dark);
    }

    h1 {
      font-size: 2.5rem;
      margin-bottom: 1.5rem;
    }

    h2 {
      font-size: 2rem;
      margin-bottom: 1.5rem;
    }

    h3 {
      font-size: 1.5rem;
      margin-bottom: 1rem;
    }

    /* Links */
    a {
      color: var(--primary-blue);
      text-decoration: none;
      transition: color 0.2s;
    }

    a:hover {
      color: #003D99;
      text-decoration: underline;
    }

    /* Form controls */
    .form-control, .form-select {
      border: 1px solid var(--light-gray);
      border-radius: 4px;
      padding: 0.7rem 1rem;
      font-weight: 500;
      transition: border-color 0.2s;
    }

    .form-control:focus, .form-select:focus {
      border-color: var(--primary-blue);
      box-shadow: 0 0 0 3px rgba(0,81,186,0.1);
    }

    .form-label {
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 0.5rem;
    }

    /* Tables */
    .table {
      border: none;
    }

    .table thead {
      background-color: var(--accent-gray);
      font-weight: 600;
      color: var(--text-dark);
    }

    .table tbody tr {
      border-bottom: 1px solid var(--light-gray);
    }

    .table tbody tr:hover {
      background-color: #FAFAFA;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .product-image {
        height: 200px;
      }

      h1 {
        font-size: 1.8rem;
      }

      h2 {
        font-size: 1.5rem;
      }

      .nav-link {
        margin: 0.5rem 0;
      }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="{{ route('home') }}"><i class="bi bi-sofa"></i> THREE D</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="navMain">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="{{ route('shop.index') }}"><i class="bi bi-shop"></i> Produk</a></li>
          @auth
            @if(auth()->user()->isPegawai())
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Kelola</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('pegawai.produk.index') }}">Produk</a></li>
                  <li><a class="dropdown-item" href="{{ route('pegawai.orders.index') }}">Pesanan</a></li>
                </ul>
              </li>
            @else
              <li class="nav-item"><a class="nav-link" href="{{ route('orders.buyer.index') }}"><i class="bi bi-bag"></i> Pesanan Saya</a></li>
            @endif
          @endauth
        </ul>

        <ul class="navbar-nav ms-auto">
          @guest
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Masuk</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}"><i class="bi bi-person-plus"></i> Daftar</a></li>
          @else
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-person-circle"></i> {{ auth()->user()->nama ?? auth()->user()->name }}</a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('dashboard.index') }}">Dashboard</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}">@csrf
                    <button class="dropdown-item">Keluar</button>
                  </form>
                </li>
              </ul>
            </li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>

  <div class="container my-4">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @yield('content')
  </div>

  <footer>
    <div class="container py-5">
      <div class="row">
        <div class="col-md-3 mb-4">
          <h5><i class="bi bi-sofa"></i> THREE D</h5>
          <p>Toko furnitur online terpercaya dengan koleksi lengkap dan harga bersaing.</p>
        </div>
        <div class="col-md-3 mb-4">
          <h5>Belanja</h5>
          <ul class="list-unstyled">
            <li><a href="{{ route('shop.index') }}">Semua Produk</a></li>
            <li><a href="{{ route('shop.index') }}?kategori=sofa">Sofa</a></li>
            <li><a href="{{ route('shop.index') }}?kategori=meja">Meja</a></li>
            <li><a href="{{ route('shop.index') }}?kategori=lemari">Lemari</a></li>
          </ul>
        </div>
        <div class="col-md-3 mb-4">
          <h5>Akun</h5>
          <ul class="list-unstyled">
            @auth
              <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
              <li><a href="{{ route('orders.buyer.index') }}">Pesanan Saya</a></li>
            @else
              <li><a href="{{ route('login') }}">Masuk</a></li>
              <li><a href="{{ route('register') }}">Daftar</a></li>
            @endauth
          </ul>
        </div>
        <div class="col-md-3 mb-4">
          <h5>Kontak</h5>
          <p>Email: info@furniturestore.com<br>
          Telepon: +62 812 3456 7890</p>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p class="mb-0">&copy; 2025 THREE D. Semua hak dilindungi.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
