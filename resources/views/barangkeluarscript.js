document.addEventListener('DOMContentLoaded', () => {
    const data = [
      {
        id: 1,
        tanggal: 'Today',
        kode: '83927',
        nama: 'Fauget Cafe',
        hargaAwal: '$500',
        hargaKonversi: 'Rp5.000.000',
        ukuran: '3 Meter',
        jumlah: 3,
        ukuranPotong: '1meter x 2meter',
        total: 70
      },
      {
        id: 2,
        tanggal: 'Today',
        kode: '31749',
        nama: 'Claudia Store',
        hargaAwal: '$500',
        hargaKonversi: 'Rp5.000.000',
        ukuran: '3 Meter',
        jumlah: 3,
        ukuranPotong: '1meter x 2meter',
        total: 70
      }
    ];
  
    const tbody = document.getElementById('barangKeluarTable');
    data.forEach(item => {
      const row = `
        <tr>
          <td>${item.id}</td>
          <td>${item.tanggal}</td>
          <td>${item.kode}</td>
          <td>${item.nama}</td>
          <td>${item.hargaAwal}</td>
          <td>${item.hargaKonversi}</td>
          <td>${item.ukuran}</td>
          <td>${item.jumlah}</td>
          <td>${item.ukuranPotong}</td>
          <td>${item.total}</td>
          <td>
            <button class="btn btn-sm btn-success me-1">Edit</button>
            <button class="btn btn-sm btn-danger">Delete</button>
          </td>
        </tr>
      `;
      tbody.innerHTML += row;
    });
  });
  