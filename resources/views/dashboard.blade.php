<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>UniClim Dashboard</title>

  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('style.css') }}" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <div class="d-flex">
    <div class="sidebar bg-dark text-white p-3">
      <img src="{{ asset('images/Logo UniCLim.png') }}" alt="UniClim Logo" class="img-fluid mb-4" style="max-width: 150px;" />
      <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link active text-success" href="/dashboard">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/databarang">Data Barang</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/barangmasuk">Barang Masuk</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/barangkeluar">Barang Keluar</a></li>
        <hr class="bg-light" />
        <li class="nav-item"><a class="nav-link text-white" href="/account">Account</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/settings">Settings</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/logout">Log Out</a></li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 bg-light">
      <!-- Header -->
      <div class="bg-success text-white p-4 d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-1">Welcome back, {{ $userName ?? 'User' }}</h5>
          <p class="mb-0" style="font-size: 0.9rem;">Let’s take a detailed look at your financial situation today</p>
        </div>
        <div class="d-flex align-items-center gap-3">
          <input type="text" class="form-control" placeholder="Search here" />
          <div class="bg-white rounded-circle text-success fw-bold text-center" style="width: 40px; height: 40px; line-height: 40px;">
            {{ strtoupper(substr($userName ?? 'U', 0, 1)) }}
          </div>
        </div>
      </div>

      <!-- Stats -->
      <div class="container py-4">
        <div class="row text-center mb-4">
          <div class="col-md-3">
            <div class="bg-white p-3 rounded shadow-sm stat-card">
              <h4>Total Sales</h4>
              <h2 class="text-success">{{ $totalSales }}</h2>
              <small class="text-success">+18% • 3.8k this month</small>
            </div>
          </div>
          <div class="col-md-3">
            <div class="bg-white p-3 rounded shadow-sm stat-card">
              <h4>Sales Revenue</h4>
              <h2 class="text-warning fs-5">Rp {{ number_format($salesRevenue, 0, ',', '.') }}</h2>
              <small class="text-success">+18% • 2.8k this month</small>
            </div>
          </div>
          <div class="col-md-3">
            <div class="bg-white p-3 rounded shadow-sm stat-card">
              <h4>Total Orders</h4>
              <h2 class="text-primary">{{ $totalOrders }}</h2>
              <small class="text-success">+18% • 7.8k this month</small>
            </div>
          </div>
          <div class="col-md-3">
            <div class="bg-white p-3 rounded shadow-sm stat-card">
              <h4>Refunded</h4>
              <h2 class="text-danger">{{ $refunded }}</h2>
              <small class="text-danger">-18% • 100 this month</small>
            </div>
          </div>
        </div>

        <!-- Charts -->
        <div class="row">
          <div class="col-md-6 mb-4">
            <div class="bg-white p-3 rounded shadow-sm stat-card">
              <div class="d-flex justify-content-between">
                <h5>Sales Revenue</h5>
                <select class="form-select form-select-sm w-auto">
                  <option>January</option>
                </select>
              </div>
              <canvas id="revenueChart" height="200"></canvas>
            </div>
          </div>
          <div class="col-md-6 mb-4">
            <div class="bg-white p-3 rounded shadow-sm stat-card">
              <div class="d-flex justify-content-between">
                <h5>Total Sales</h5>
                <select class="form-select form-select-sm w-auto">
                  <option>Best Product</option>
                </select>
              </div>
              <canvas id="salesChart" height="200"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('script.js') }}"></script>
</body>
</html>
