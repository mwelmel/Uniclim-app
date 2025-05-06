document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.querySelector('input[type="text"]');
    const tableRows = document.querySelectorAll("tbody tr");
  
    searchInput.addEventListener("keyup", function () {
      const searchText = this.value.toLowerCase();
      tableRows.forEach(row => {
        const rowText = row.textContent.toLowerCase();
        row.style.display = rowText.includes(searchText) ? "" : "none";
      });
    });
  
    // Optional: Confirm before delete
    const deleteButtons = document.querySelectorAll(".btn-danger");
    deleteButtons.forEach(button => {
      button.addEventListener("click", () => {
        const confirmed = confirm("Apakah Anda yakin ingin menghapus barang ini?");
        if (!confirmed) {
          event.preventDefault();
        }
      });
    });
  });
  