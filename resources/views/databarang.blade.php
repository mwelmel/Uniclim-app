<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Data Barang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('databarang.css') }}"/>
</head>
<body>
  <div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar bg-dark text-white p-3" style="min-width: 200px;">
      <img src="{{ asset('images/Logo UniCLim.png') }}" alt="UniClim Logo" class="img-fluid mb-4" style="max-width: 150px;" />
      <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link text-white" href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="{{ url('/databarang') }}">Data Barang</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="{{ url('/barangmasuk') }}">Barang Masuk</a></li>
        <li class="nav-item"><a class="nav-link active text-success" href="{{ url('/barangkeluar') }}">Barang Keluar</a></li>
        <hr class="bg-light" />
        <li class="nav-item"><a class="nav-link text-white" href="{{ url('/account') }}">Account</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="{{ url('/settings') }}">Settings</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="{{ url('/logout') }}">Log Out</a></li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 bg-light">
      <!-- Header -->
      <div class="bg-success text-white p-4 d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-1">Data Barang</h5>
          <p class="mb-0" style="font-size: 0.9rem;">Daftar Semua Barang Yang Tersedia</p>
        </div>
        <div class="d-flex align-items-center gap-3">
          <input type="text" class="form-control" placeholder="Search here" />
          <div class="bg-white rounded-circle text-success fw-bold text-center" style="width: 40px; height: 40px; line-height: 40px;">O</div>
        </div>
      </div>

      <!-- Content -->
      <div class="container my-4">

        <table class="table table-bordered text-center align-middle">
            <thead>
              <tr class="table-success">
                <th>ID</th>
                <th>Tanggal</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Ukuran</th>
                <th>Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>17482</td>
                <td>Today</td>
                <td>83927</td>
                <td>Fauget Cafe</td>
                <td>Rp5.000.000</td>
                <td>3 Meter</td>
                <td>70</td>
              </tr>
              <tr>
                <td>24245</td>
                <td>Today</td>
                <td>31749</td>
                <td>Claudia Store</td>
                <td>Rp5.000.000</td>
                <td>3 Meter</td>
                <td>70</td>
              </tr>
              <tr>
                <td>35242</td>
                <td>Today</td>
                <td>13901</td>
                <td>Chidi Barber</td>
                <td>Rp5.000.000</td>
                <td>3 Meter</td>
                <td>70</td>
              </tr>
              <tr>
                <td>48463</td>
                <td>Today</td>
                <td>46283</td>
                <td>Yael Amari</td>
                <td>Rp5.000.000</td>
                <td>3 Meter</td>
                <td>70</td>
              </tr>
              <tr>
                <td>57825</td>
                <td>Yesterday</td>
                <td>38473</td>
                <td>Larana, Inc.</td>
                <td>Rp5.000.000</td>
                <td>3 Meter</td>
                <td>70</td>
              </tr>
              <tr>
                <td>56246</td>
                <td>Yesterday</td>
                <td>28393</td>
                <td>Larana, Inc.</td>
                <td>Rp5.000.000</td>
                <td>3 Meter</td>
                <td>70</td>
              </tr>
            </tbody>
          </table>
          
      </div>
    </div>
  </div>

  <script src="{{ asset('databarang.js') }}"></script>
</body>
</html>
