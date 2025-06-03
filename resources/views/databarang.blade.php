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
    <div class="sidebar bg-dark text-white p-3" style="width: 220px; min-height: 100vh;">
      <img src="{{ asset('images/Logo UniCLim.png') }}" alt="UniClim Logo" class="img-fluid mb-4" style="max-width: 150px;" />
      <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link active text-success" href="/dashboard">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/databarang">Data Barang</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/barangmasuk">Barang Masuk</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/barangkeluar">Barang Keluar</a></li>
        <hr class="bg-light" />
        <li class="nav-item"><a class="nav-link text-white" href="/account">Account</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/settings">Settings</a></li>

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

        <!-- Tombol untuk buka modal -->
        <div class="mb-3">
          <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Barang</button>
        </div>

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
            @foreach($dataBarang as $barang)
              <tr>
                <td>{{ $barang->id }}</td>
                <td>{{ $barang->tanggal }}</td>
                <td>{{ $barang->kode_barang }}</td>
                <td>{{ $barang->nama_barang }}</td>
                <td>{{ $barang->harga }}</td>
                <td>{{ $barang->ukuran }}</td>
                <td>{{ $barang->jumlah }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal Tambah Barang -->
  <div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog">
      <form action="{{ route('barang.store') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Barang</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="date" name="tanggal" class="form-control mb-2" required placeholder="Tanggal">
            <input type="text" name="kode_barang" class="form-control mb-2" required placeholder="Kode Barang">
            <input type="text" name="nama_barang" class="form-control mb-2" required placeholder="Nama Barang">
            <input type="number" name="harga" class="form-control mb-2" required placeholder="Harga">
            <input type="text" name="ukuran" class="form-control mb-2" required placeholder="Ukuran">
            <input type="number" name="jumlah" class="form-control mb-2" required placeholder="Jumlah">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
