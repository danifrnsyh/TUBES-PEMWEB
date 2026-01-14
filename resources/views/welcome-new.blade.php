<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PropertyHub - Jual Beli Property Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
        }

        * {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero-section p {
            font-size: 1.3rem;
            margin-bottom: 30px;
            opacity: 0.95;
        }

        .cta-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-buttons .btn {
            padding: 12px 35px;
            font-size: 1.1rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .cta-buttons .btn-light:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        /* Features */
        .features-section {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .feature-card {
            text-align: center;
            padding: 40px 25px;
            border-radius: 10px;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .feature-icon {
            font-size: 3.5rem;
            color: var(--secondary-color);
            margin-bottom: 20px;
        }

        .feature-card h3 {
            color: var(--primary-color);
            font-weight: bold;
            margin-bottom: 15px;
        }

        /* User Type Section */
        .user-type-section {
            padding: 80px 0;
            background: white;
        }

        .user-type-card {
            padding: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(52, 152, 219, 0.1) 0%, rgba(52, 152, 219, 0.05) 100%);
            border: 2px solid var(--secondary-color);
            text-align: center;
            min-height: 350px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .user-type-card h3 {
            color: var(--primary-color);
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .user-type-card .icon {
            font-size: 4rem;
            color: var(--secondary-color);
            margin-bottom: 20px;
        }

        .user-type-card ul {
            text-align: left;
            margin: 20px 0;
            list-style: none;
            padding: 0;
        }

        .user-type-card li {
            padding: 10px 0;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .user-type-card li:last-child {
            border-bottom: none;
        }

        .user-type-card li:before {
            content: "✓ ";
            color: var(--secondary-color);
            font-weight: bold;
            margin-right: 10px;
        }

        /* Stats */
        .stats-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 60px 0;
            text-align: center;
        }

        .stat {
            margin: 30px 0;
        }

        .stat h2 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        /* CTA Section */
        .cta-final-section {
            background: white;
            padding: 80px 0;
            text-align: center;
        }

        .cta-final-section h2 {
            color: var(--primary-color);
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 30px;
        }

        /* Footer */
        footer {
            background: var(--primary-color);
            color: white;
            padding: 40px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: var(--primary-color);">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="/">
                <i class="bi bi-houses"></i> PropertyHub
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="/properties">Browse Property</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ auth()->user()->isSeller() ? route('seller.dashboard') : route('buyer.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="nav-link btn btn-link">Logout</button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1><i class="bi bi-houses"></i> PropertyHub</h1>
            <p>Platform Terpercaya untuk Jual Beli Property Online</p>
            <p style="font-size: 1.1rem; opacity: 0.9;">Temukan properti impian Anda atau jual properti dengan mudah dan aman</p>
            
            <div class="cta-buttons">
                @auth
                    <a href="/properties" class="btn btn-light btn-lg">
                        <i class="bi bi-search"></i> Browse Property
                    </a>
                    @if (auth()->user()->isSeller())
                        <a href="{{ route('properties.create') }}" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-plus-circle"></i> Jual Property
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-person-plus"></i> Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="text-center mb-5" style="color: var(--primary-color); font-weight: bold;">
                <i class="bi bi-star"></i> Kenapa Memilih PropertyHub?
            </h2>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                        <h3>Aman & Terpercaya</h3>
                        <p>Transaksi yang aman dengan verifikasi lengkap untuk pembeli dan penjual</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-lightning"></i></div>
                        <h3>Mudah & Cepat</h3>
                        <p>Proses pembelian yang sederhana dan transaksi yang cepat tanpa ribet</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-globe"></i></div>
                        <h3>Jangkauan Luas</h3>
                        <p>Akses properti dari seluruh Indonesia dengan pilihan yang beragam</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- User Type Section -->
    <section class="user-type-section">
        <div class="container">
            <h2 class="text-center mb-5" style="color: var(--primary-color); font-weight: bold;">
                <i class="bi bi-people"></i> Untuk Siapa PropertyHub?
            </h2>

            <div class="row g-4">
                <!-- Buyer -->
                <div class="col-md-6">
                    <div class="user-type-card">
                        <div class="icon"><i class="bi bi-bag-check"></i></div>
                        <h3>Pembeli</h3>
                        <p>Cari dan beli properti yang sesuai dengan kebutuhan Anda</p>
                        <ul>
                            <li>Browse properti dari berbagai penjual</li>
                            <li>Lihat detail lengkap setiap properti</li>
                            <li>Buat pesanan dan kelola transaksi</li>
                            <li>Cetak invoice resmi pesanan Anda</li>
                            <li>Pantau status pesanan secara real-time</li>
                        </ul>
                    </div>
                </div>

                <!-- Seller -->
                <div class="col-md-6">
                    <div class="user-type-card">
                        <div class="icon"><i class="bi bi-shop"></i></div>
                        <h3>Penjual</h3>
                        <p>Jual properti Anda dengan mudah ke calon pembeli</p>
                        <ul>
                            <li>Tambah dan kelola inventory properti</li>
                            <li>Atur harga dan stok property</li>
                            <li>Lihat semua pesanan dari pembeli</li>
                            <li>Konfirmasi dan kelola pesanan</li>
                            <li>Pantau total penjualan dan pendapatan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat">
                        <h2>500+</h2>
                        <p>Property Terdaftar</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat">
                        <h2>1000+</h2>
                        <p>Pengguna Aktif</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat">
                        <h2>5000+</h2>
                        <p>Transaksi Berhasil</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat">
                        <h2>99%</h2>
                        <p>Kepuasan Pelanggan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final Section -->
    <section class="cta-final-section">
        <div class="container">
            <h2>Siap Memulai?</h2>
            <p class="lead mb-4">Bergabunglah dengan ribuan pengguna PropertyHub yang telah berhasil bertransaksi</p>
            
            <div class="cta-buttons">
                @auth
                    <a href="/properties" class="btn btn-primary btn-lg">
                        <i class="bi bi-search"></i> Jelajahi Sekarang
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-person-plus"></i> Daftar Gratis
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-4">
                    <h5>PropertyHub</h5>
                    <p>Platform jual beli property terpercaya dan mudah digunakan</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="/properties" class="text-white-50 text-decoration-none">Browse Property</a></li>
                        @auth
                            <li><a href="{{ auth()->user()->isSeller() ? route('seller.dashboard') : route('buyer.dashboard') }}" class="text-white-50 text-decoration-none">Dashboard</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <p class="text-white-50 mb-1">Email: info@propertyhub.com</p>
                    <p class="text-white-50">Phone: +62 8xx xxxx xxxx</p>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2);">
            <p class="text-white-50 mb-0">&copy; 2025 PropertyHub. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
