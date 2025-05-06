const openBtn = document.getElementById('openPopupBtn');
const closeBtn = document.getElementById('closePopupBtn');
const popup = document.getElementById('popupForm');

openBtn.addEventListener('click', () => {
  popup.style.display = 'flex';
});

closeBtn.addEventListener('click', () => {
  popup.style.display = 'none';
});

document.getElementById('formBarangKeluar').addEventListener('submit', e => {
  e.preventDefault();
  alert("Data berhasil disimpan! (Simulasi)");
  popup.style.display = 'none';
});
