<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Barang Keluar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/barangkeluarstyle.css') }}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />
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
          <h5 class="mb-1">Barang Keluar</h5>
          <p class="mb-0" style="font-size: 0.9rem;">Laporan barang keluar hari ini dan sebelumnya</p>
        </div>
        <div class="d-flex align-items-center gap-3">
          <!-- <input type="text" class="form-control" placeholder="Search here" /> -->
          <div class="bg-white rounded-circle text-success fw-bold text-center" style="width: 40px; height: 40px; line-height: 40px;">
            {{ strtoupper(substr(Auth::user()->name ?? 'O', 0, 1)) }}
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="container my-4">
        <div class="d-flex justify-content-start gap-3 mb-3">
          <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahBarangModal">
            <i class="bi bi-plus-circle"></i> Tambah Barang Keluar
          </button>
        </div>

        <!-- Table -->
        <table class="table table-bordered text-center align-middle" id="barangKeluarTable">
          <thead>
            <tr class="table-success">
              <th>ID</th>
              <th>Tanggal</th>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Harga Awal</th>
              <th>Harga Dikonversi</th>
              <th>Ukuran</th>
              <th>Jumlah</th>
              <th>Ukuran Dipotong</th>
              <th>Total</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($barangKeluar as $barang)
            <tr>
              <td>{{ $barang->id }}</td>
              <td>{{ $barang->tanggal }}</td>
              <td>{{ $barang->kode_barang }}</td>
              <td>{{ $barang->nama_barang }}</td>
              <td>{{ $barang->harga_awal ?? '-' }}</td>
              <td>{{ $barang->harga_dikonversi }}</td>
              <td>{{ $barang->ukuran }}</td>
              <td>{{ $barang->jumlah }}</td>
              <td>{{ $barang->ukuran_dipotong }}</td>
              <td>{{ $barang->total }}</td>
              <td>
                <a href="{{ route('barangkeluar.edit', $barang->id) }}" class="btn btn-success btn-sm mb-1">Edit</a><br />
                <form action="{{ route('barangkeluar.destroy', $barang->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                  @csrf
                  @method('DELETE')
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

  <!-- Modal Tambah Barang Keluar -->
  <div class="modal fade" id="tambahBarangModal" tabindex="-1" aria-labelledby="tambahBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" action="{{ route('barangkeluar.store') }}">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="tambahBarangModalLabel">Tambah Barang Keluar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required value="{{ \Carbon\Carbon::now()->toDateString() }}">
            </div>

            <div class="mb-3">
              <label for="nama_barang" class="form-label">Nama Barang</label>
              <select id="nama_barang" class="form-select" required>
                <option value="">-- Pilih Barang --</option>
                @foreach ($barangList as $barang)
                  <option value="{{ $barang->nama_barang }}" data-kode="{{ $barang->kode_barang }}" data-harga="{{ $barang->harga }}" data-ukuran="{{ $barang->ukuran }}">
                    {{ $barang->nama_barang }}
                  </option>
                @endforeach
              <input type="hidden" name="nama_barang" id="nama_barang_hidden">
              </select>
            </div>
            <div class="mb-3">
              <label for="kode_barang" class="form-label">Kode Barang</label>
              <input type="text" class="form-control" id="kode_barang" name="kode_barang" readonly />
            </div>
            <div class="mb-3">
              <label for="harga_awal" class="form-label">Harga Awal</label>
              <input type="number" step="0.01" min="0" class="form-control" id="harga_awal" name="harga_awal" readonly />
            </div>
            <div class="mb-3">
              <label for="ukuran" class="form-label">Ukuran</label>
              <input type="number" step="0.01" min="0" class="form-control" id="ukuran" name="ukuran" readonly />
            </div>
            <div class="mb-3">
              <label for="jumlah" class="form-label">Jumlah</label>
              <input type="number" min="1" class="form-control" id="jumlah" name="jumlah" required value="1" />
            </div>
            <div class="mb-3">
              <label for="ukuran_dipotong" class="form-label">Ukuran Dipotong</label>
              <input type="number" step="0.01" min="0" class="form-control" id="ukuran_dipotong" name="ukuran_dipotong" required />
            </div>
            <div class="mb-3">
              <label for="harga_dikonversi" class="form-label">Harga Dikonversi</label>
              <input type="number" step="0.01" class="form-control" id="harga_dikonversi" name="harga_dikonversi" readonly />
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

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#barangKeluarTable').DataTable();

      function hitungKonversi() {
        let harga_awal = parseFloat($('#harga_awal').val()) || 0;
        let ukuran = parseFloat($('#ukuran').val()) || 0;
        let ukuran_dipotong = parseFloat($('#ukuran_dipotong').val()) || 0;
        let jumlah = parseInt($('#jumlah').val()) || 1;

        if (harga_awal <= 0 || ukuran <= 0 || ukuran_dipotong <= 0) {
          $('#harga_dikonversi').val('');
          $('#total').val('');
          return;
        }

        $.ajax({
          url: "{{ route('barangkeluar.konversi') }}",
          type: "POST",
          headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
          data: { harga_awal, ukuran, ukuran_dipotong, jumlah },
          success: function (data) {
            $('#harga_dikonversi').val(data.harga_dikonversi);
            $('#total').val(data.total);
          },
          error: function (xhr) {
            console.error(xhr.responseJSON?.error || 'Terjadi kesalahan konversi');
            $('#harga_dikonversi').val('');
            $('#total').val('');
          }
        });
      }

      $('#harga_awal, #ukuran, #ukuran_dipotong, #jumlah').on('input', hitungKonversi);

      $('#nama_barang').on('change', function () {
        const selected = $(this).find(':selected');
        const kode = selected.data('kode') || '';
        const harga = selected.data('harga') || '';
        const ukuran = selected.data('ukuran') || '';
        const nama = selected.val();

        $('#kode_barang').val(kode);
        $('#harga_awal').val(harga);
        $('#ukuran').val(ukuran);
        $('#nama_barang_hidden').val(nama);

        hitungKonversi();
      });
    });
  </script>
</body>
</html>