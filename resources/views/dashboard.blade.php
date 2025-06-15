<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>UniClim Dashboard</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('style.css') }}" />

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar bg-dark text-white p-3" style="width: 220px; min-height: 100vh;">
      <img src="{{ asset('images\Logo_UniClim.png') }}" alt="UniClim Logo" class="img-fluid mb-4" style="max-width: 150px;" />
      <ul class="nav flex-column">
    @php
        $allowedUsers = ['Chandra', 'Angelique'];
    @endphp

    @if (auth()->check() && in_array(auth()->user()->username, $allowedUsers))
    <li class="nav-item"><a class="nav-link active text-success" href="/dashboard">Dashboard</a></li>
    @endif
        <li class="nav-item"><a class="nav-link text-white" href="/databarang">Data Barang</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/barangmasuk">Barang Masuk</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/barangkeluar">Barang Keluar</a></li>
        <hr class="bg-light" />
        <li class="nav-item"><a class="nav-link text-white" href="/account">Account</a></li>
        

        <!-- Logout dengan form POST -->
        <li class="nav-item">
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
           @csrf
          </form>
          <a href="#" class="nav-link text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Log Out
          </a>
        </li>
      </ul>
    </div>


    <!-- Main Content -->
    <div class="flex-grow-1 bg-light min-vh-100">
      <!-- Header -->
      <div class="bg-success text-white p-4 d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-1">Welcome back, {{ $userName ?? 'User' }}</h5>
          <p class="mb-0" style="font-size: 0.9rem;">Let’s take a detailed look at your financial situation today</p>
        </div>
        <div class="d-flex align-items-center gap-3">
          <!-- <input type="text" class="form-control" placeholder="Search here" style="max-width: 250px;" /> -->
          <div style="width: 40px; height: 40px; line-height: 40px;">
          </div>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="container py-4">
        <div class="row text-center mb-4">
          <div class="col-md-3">
            <div class="bg-white p-3 rounded shadow-sm stat-card">
              <h4>Total Sales</h4>
              <h2 class="text-success">{{ $totalSales }}</h2>
              <small class="text-success">Based on total jumlah barang keluar</small>
            </div>
          </div>
          <div class="col-md-3">
            <div class="bg-white p-3 rounded shadow-sm stat-card">
              <h4>Sales Revenue</h4>
              <h2 class="text-warning fs-5">Rp {{ number_format($salesRevenue, 0, ',', '.') }}</h2>
              <small class="text-success">Calculated from jumlah × harga</small>
            </div>
          </div>
          <div class="col-md-3">
            <div class="bg-white p-3 rounded shadow-sm stat-card">
              <h4>Refunded</h4>
              <h2 class="text-danger">{{ $refunded }}</h2>
              <small class="text-danger">Currently no refund data</small>
            </div>
          </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
          <!-- Sales Revenue Chart -->
          <div class="col-md-6 mb-4">
            <div class="bg-white p-3 rounded shadow-sm stat-card">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Sales Revenue (Monthly)</h5>
                <select class="form-select form-select-sm w-auto" disabled>
                  <option>Year 2025</option>
                </select>
              </div>
              <canvas id="revenueChart" height="200"></canvas>
            </div>
          </div>

          <!-- Top Barang Keluar Chart -->
          <div class="col-md-6 mb-4">
            <div class="bg-white p-3 rounded shadow-sm stat-card">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Top 5 Barang Keluar</h5>
              </div>
              <canvas id="salesChart" height="200"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Chart Scripts -->
  <script>
    // Sales Revenue Monthly Line Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
      type: 'line',
      data: {
        labels: {!! json_encode($monthlyLabels) !!},
        datasets: [{
          label: 'Revenue',
          data: {!! json_encode($monthlyData) !!},
          backgroundColor: 'rgba(25, 135, 84, 0.2)',
          borderColor: 'rgb(25, 135, 84)',
          fill: true,
          tension: 0.4,
          pointRadius: 4,
          pointHoverRadius: 6
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return 'Rp ' + value.toLocaleString();
              }
            }
          }
        },
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });

    // Top 5 Barang Keluar Bar Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(salesCtx, {
      type: 'bar',
      data: {
        labels: {!! json_encode($topLabels ?? []) !!},
        datasets: [{
          label: 'Jumlah Barang Keluar',
          data: {!! json_encode($topData ?? []) !!},
          backgroundColor: 'rgba(0, 123, 255, 0.6)',
          borderColor: 'rgb(0, 123, 255)',
          borderWidth: 1,
          borderRadius: 4
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 1
            }
          }
        },
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });
  </script>
</body>
</html>