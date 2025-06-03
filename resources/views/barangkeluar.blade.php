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
  <div class="sidebar bg-dark text-white p-3" style="width: 220px; min-height: 100vh;">
    <img src="{{ asset('images/Logo UniCLim.png') }}" alt="UniClim Logo" class="img-fluid mb-4" style="max-width: 150px;" />
    <ul class="nav flex-column">
      <li class="nav-item"><a class="nav-link text-white" href="/dashboard">Dashboard</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="/databarang">Data Barang</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="/barangmasuk">Barang Masuk</a></li>
      <li class="nav-item"><a class="nav-link active text-success" href="/barangkeluar">Barang Keluar</a></li>
      <hr class="bg-light" />
      <li class="nav-item"><a class="nav-link text-white" href="/account">Account</a></li>
      <li class="nav-item">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        <a href="#" class="nav-link text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
      </li>
    </ul>
  </div>

  <div class="flex-grow-1 bg-light">
    <div class="bg-success text-white p-4 d-flex justify-content-between align-items-center">
      <div>
        <h5 class="mb-1">Barang Keluar</h5>
        <p class="mb-0" style="font-size: 0.9rem;">Laporan barang keluar hari ini dan sebelumnya</p>
      </div>
    </div>

    <div class="container my-4">
      <div class="d-flex justify-content-start gap-3 mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahBarangModal">
          <i class="bi bi-plus-circle"></i> Tambah Barang Keluar
        </button>
      </div>

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
            <td>{{ $barang->harga_awal }}</td>
            <td>{{ $barang->harga_dikonversi }}</td>
            <td>{{ $barang->ukuran }}</td>
            <td>{{ $barang->jumlah }}</td>
            <td>{{ $barang->ukuran_dipotong }}</td>
            <td>{{ $barang->total }}</td>
            <td>
              <a href="{{ route('barangkeluar.edit', $barang->id) }}" class="btn btn-success btn-sm mb-1">Edit</a><br />
              <form action="{{ route('barangkeluar.destroy', $barang->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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

<!-- Modal Tambah -->
<div class="modal fade" id="tambahBarangModal" tabindex="-1" aria-labelledby="tambahBarangModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('barangkeluar.store') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Barang Keluar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" class="form-control" name="tanggal" value="{{ \Carbon\Carbon::now()->toDateString() }}" required />
          </div>
          <div class="mb-3">
            <label>Nama Barang</label>
            <select id="nama_barang" class="form-select" required>
              <option value="">-- Pilih Barang --</option>
              @foreach ($barangList as $barang)
                <option value="{{ $barang->nama_barang }}" data-kode="{{ $barang->kode_barang }}" data-harga="{{ $barang->harga }}" data-ukuran="{{ $barang->ukuran }}">{{ $barang->nama_barang }}</option>
              @endforeach
            </select>
            <input type="hidden" name="nama_barang" id="nama_barang_hidden" />
          </div>
          <div class="mb-3"><label>Kode Barang</label><input type="text" class="form-control" id="kode_barang" name="kode_barang" readonly /></div>
          <div class="mb-3"><label>Harga Awal</label><input type="number" class="form-control" id="harga_awal" name="harga_awal" readonly /></div>
          <div class="mb-3"><label>Ukuran</label><input type="number" class="form-control" id="ukuran" name="ukuran" readonly /></div>
          <div class="mb-3"><label>Jumlah</label><input type="number" class="form-control" id="jumlah" name="jumlah" value="1" min="1" required /></div>
          <div class="mb-3"><label>Ukuran Dipotong</label><input type="number" class="form-control" id="ukuran_dipotong" name="ukuran_dipotong" required /></div>
          <div class="mb-3"><label>Harga Dikonversi</label><input type="number" class="form-control" id="harga_dikonversi" name="harga_dikonversi" readonly /></div>
          <div class="mb-3"><label>Total</label><input type="number" class="form-control" id="total" name="total" readonly /></div>

          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="toggle_usd">
            <label class="form-check-label" for="toggle_usd">Tampilkan dalam USD</label>
            <input type="hidden" name="toggle_usd" id="toggle_usd_hidden" value="0">
          </div>
          <div class="mb-3 d-none" id="usd_fields">
            <label>Harga Dikonversi (USD)</label><input type="text" class="form-control" id="harga_dikonversi_usd" readonly />
          </div>
          <div class="mb-3 d-none" id="total_usd_fields">
            <label>Total (USD)</label><input type="text" class="form-control" id="total_usd" readonly />
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

    function toggleUSDFields(show) {
      $('#usd_fields, #total_usd_fields').toggleClass('d-none', !show);
    }

    $('#toggle_usd').on('change', function () {
      toggleUSDFields(this.checked);
      hitungKonversi();
    });

    $('#nama_barang').on('change', function () {
      let selected = $(this).find(':selected');
      $('#kode_barang').val(selected.data('kode'));
      $('#harga_awal').val(selected.data('harga'));
      $('#ukuran').val(selected.data('ukuran'));
      $('#nama_barang_hidden').val(selected.val());
      hitungKonversi();
    });

    $('#harga_awal, #ukuran, #ukuran_dipotong, #jumlah').on('input', hitungKonversi);

    function hitungKonversi() {
      const harga_awal = parseFloat($('#harga_awal').val()) || 0;
      const ukuran = parseFloat($('#ukuran').val()) || 0;
      const ukuran_dipotong = parseFloat($('#ukuran_dipotong').val()) || 0;
      const jumlah = parseInt($('#jumlah').val()) || 1;
      const kurs_usd = 15500;

      if (harga_awal <= 0 || ukuran <= 0 || ukuran_dipotong <= 0 || jumlah <= 0) {
        $('#harga_dikonversi, #total, #harga_dikonversi_usd, #total_usd').val('');
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

          if ($('#toggle_usd').is(':checked')) {
            $('#harga_dikonversi_usd').val(`$${(data.harga_dikonversi / kurs_usd).toFixed(2)}`);
            $('#total_usd').val(`$${(data.total / kurs_usd).toFixed(2)}`);
          } else {
            $('#harga_dikonversi_usd, #total_usd').val('');
          }
        },
        error: function () {
          $('#harga_dikonversi, #total, #harga_dikonversi_usd, #total_usd').val('');
        }
      });
    }
    $('#toggle_usd').on('change', function () {
     if (this.checked) {
    $('#currency').val('USD');
    } else {
    $('#currency').val('IDR');
    }
    });
  });
</script>
</body>
</html>
