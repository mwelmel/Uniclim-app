<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Barang Masuk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/barangkeluarstyle.css') }}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />
</head>
<body>
  <div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar bg-dark text-white p-3" style="width: 220px; min-height: 100vh;">
      <img src="{{ asset('images/Logo_UniClim.png') }}" alt="UniClim Logo" class="img-fluid mb-4" style="max-width: 150px;" />
      <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link text-white" href="/dashboard">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/databarang">Data Barang</a></li>
        <li class="nav-item"><a class="nav-link active text-success" href="/barangmasuk">Barang Masuk</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/barangkeluar">Barang Keluar</a></li>
        <hr class="bg-light" />
        <li class="nav-item"><a class="nav-link text-white" href="/account">Account</a></li>
        <li class="nav-item">
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
          <a href="#" class="nav-link text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
        </li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 bg-light">
      <div class="bg-success text-white p-4 d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-1">Barang Masuk</h5>
          <p class="mb-0" style="font-size: 0.9rem;">Laporan barang masuk hari ini dan sebelumnya</p>
        </div>
      </div>

      <div class="container my-4">
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahBarangModal">
          <i class="bi bi-plus-circle"></i> Tambah Barang Masuk
        </button>

        <table class="table table-bordered text-center align-middle" id="barangmasukTable">
          <thead>
            <tr class="table-success">
              <th>ID</th>
              <th>Tanggal</th>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Harga</th>
              <th>Ukuran</th>
              <th>Jumlah</th>
              <th>Total</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($barangmasuk as $barang)
            <tr>
              <td>{{ $barang->id }}</td>
              <td>{{ $barang->tanggal }}</td>
              <td>{{ $barang->kode_barang }}</td>
              <td>{{ $barang->nama_barang }}</td>
              <td>{{ $barang->harga }}</td>
              <td>{{ $barang->ukuran }}</td>
              <td>{{ $barang->jumlah }}</td>
              <td>{{ $barang->total }}</td>
              <td>
                <form action="{{ route('barangmasuk.destroy', $barang->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-danger btn-sm">Delete</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal Tambah Barang -->
  <div class="modal fade" id="tambahBarangModal" tabindex="-1" aria-labelledby="tambahBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" action="{{ route('barangmasuk.store') }}">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="tambahBarangModalLabel">Tambah Barang Masuk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            @if ($errors->any())
          <div class="alert alert-danger">
           <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
          </div>
            @endif

            <div class="mb-3">
              <label for="tanggal" class="form-label">Tanggal</label>
              <input type="date" class="form-control" id="tanggal" name="tanggal" required />
            </div>
            <div class="mb-3">
              <label for="kode_barang" class="form-label">Kode Barang</label>
              <input type="text" class="form-control" id="kode_barang" name="kode_barang" required />
            </div>
            <div class="mb-3">
              <label for="nama_barang" class="form-label">Nama Barang</label>
              <input type="text" class="form-control" id="nama_barang" name="nama_barang" required />
            </div>
            <div class="mb-3">
              <label for="harga" class="form-label">Harga</label>
              <input type="number" step="0.01" min="0" class="form-control" id="harga" name="harga" />
            </div>
            <div class="mb-3">
              <label for="ukuran" class="form-label">Ukuran</label>
              <input type="number" step="0.01" min="0" class="form-control" id="ukuran" name="ukuran" required />
            </div>
            <div class="mb-3">
              <label for="jumlah" class="form-label">Jumlah</label>
              <input type="number" min="1" class="form-control" id="jumlah" name="jumlah" required value="1" />
            </div>
            <div class="mb-3">
              <label for="total" class="form-label">Total</label>
              <input type="number" step="0.01" class="form-control" id="total" name="total" readonly />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script>
  $(document).ready(function () {
    const table = $('#barangmasukTable').DataTable();

    $('#harga, #ukuran, #jumlah').on('input', function () {
      let harga = parseFloat($('#harga').val()) || 0;
      let ukuran = parseFloat($('#ukuran').val()) || 0;
      let jumlah = parseInt($('#jumlah').val()) || 1;
      let total = harga * ukuran * jumlah;
      $('#total').val(total.toFixed(2));
    });

    @if ($errors->any())
     $('#tambahBarangModal').modal('show');
    @endif

  });
  </script>
</body>
</html>
