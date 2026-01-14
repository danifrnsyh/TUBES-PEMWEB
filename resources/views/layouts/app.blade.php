<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>THREE D - Toko Furniture Online Terpercaya</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="{{ asset('css/carousel.css') }}" rel="stylesheet">
  <style>
    :root {
      --primary-blue: #1A1A1A; /* Minimalist Charcoal */
      --accent-gold: #D4AF37;   /* Elegant Gold focus */
      --background-light: #FAFAFA;
      --text-main: #2D2D2D;
      --text-muted: #666666;
      --border-color: #EEEEEE;
      --card-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    * {
      font-family: 'Outfit', sans-serif;
    }

    html, body {
      height: 100%;
    }

    body {
      background-color: var(--background-light);
      color: var(--text-main);
      display: flex;
      flex-direction: column;
      -webkit-font-smoothing: antialiased;
    }

    main {
      flex: 1;
      padding: 0;
    }

    /* Navbar - Premium Minimalist */
    .navbar {
      background-color: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid var(--border-color);
      padding: 1.2rem 0;
      transition: all 0.3s ease;
    }

    .navbar-brand {
      font-weight: 700;
      font-size: 1.6rem;
      color: var(--primary-blue) !important;
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    .navbar-brand i {
      margin-right: 0.5rem;
      color: var(--accent-gold);
    }

    .nav-link {
      color: var(--text-main) !important;
      font-weight: 500;
      font-size: 0.9rem;
      transition: all 0.2s ease;
      margin: 0 1rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      opacity: 0.8;
    }

    .nav-link:hover {
      color: var(--accent-gold) !important;
      opacity: 1;
    }

    .dropdown-menu {
      border: 1px solid var(--border-color);
      box-shadow: var(--card-shadow);
      border-radius: 12px;
      padding: 0.8rem;
    }

    .dropdown-item {
      font-weight: 500;
      border-radius: 8px;
      padding: 0.6rem 1rem;
      margin-bottom: 2px;
    }

    /* Cards - Minimalist */
    .card {
      border: 1px solid var(--border-color);
      background-color: #FFFFFF;
      box-shadow: var(--card-shadow);
      border-radius: 16px;
      transition: transform 0.3s ease;
    }

    /* Buttons - Professional */
    .btn {
      padding: 0.8rem 1.8rem;
      border-radius: 100px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-primary {
      background-color: var(--primary-blue);
      border: none;
      color: white;
    }

    .btn-primary:hover {
      background-color: #333;
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .btn-secondary {
      background-color: white;
      color: var(--primary-blue);
      border: 1px solid var(--border-color);
    }

    /* Footer - Sleek */
    footer {
      background-color: #FFFFFF;
      color: var(--text-main);
      padding: 4rem 0 0;
      margin-top: auto;
      border-top: 1px solid var(--border-color);
    }

    footer h5 {
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 1.5rem;
      color: var(--primary-blue);
    }

    footer a {
      color: var(--text-muted);
      transition: color 0.2s;
    }

    footer a:hover {
      color: var(--accent-gold);
    }

    .footer-bottom {
      padding: 2rem 0;
      border-top: 1px solid var(--border-color);
      text-align: center;
      color: var(--text-muted);
      font-size: 0.85rem;
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
