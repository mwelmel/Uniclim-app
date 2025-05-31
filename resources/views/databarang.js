// DataBarang.js - Script untuk halaman Data Barang

// Fitur Pencarian (Live Search)
function initLiveSearch() {
  const searchInput = document.querySelector('input[type="text"]');
  const tableRows = document.querySelectorAll("tbody tr");

  if (!searchInput || tableRows.length === 0) return;

  searchInput.addEventListener("keyup", () => {
    const searchText = searchInput.value.toLowerCase();
    tableRows.forEach(row => {
      const rowText = row.textContent.toLowerCase();
      row.style.display = rowText.includes(searchText) ? "" : "none";
    });
  });
}

// Fitur Konfirmasi Sebelum Hapus
function initDeleteConfirmation() {
  const deleteForms = document.querySelectorAll('form[action*="databarang"]');

  deleteForms.forEach(form => {
    form.addEventListener("submit", event => {
      const confirmed = confirm("Apakah Anda yakin ingin menghapus barang ini?");
      if (!confirmed) event.preventDefault();
    });
  });
}

// Inisialisasi Semua Fitur saat DOM siap
document.addEventListener("DOMContentLoaded", () => {
  initLiveSearch();
  initDeleteConfirmation();
});
