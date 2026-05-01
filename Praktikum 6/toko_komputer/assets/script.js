document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchProduct");

  if (searchInput) {
    // Event listener saat user mengetik di kolom pencarian
    searchInput.addEventListener("keyup", function () {
      let filterText = searchInput.value.toLowerCase();
      let tableRows = document.querySelectorAll("#productTable tbody tr");

      tableRows.forEach((row) => {
        // Ambil teks dari kolom ke-3 (Nama Produk)
        let productName = row.cells[2].textContent.toLowerCase();

        // Sembunyikan baris jika tidak cocok, tampilkan jika cocok
        if (productName.includes(filterText)) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      });
    });
  }
});
