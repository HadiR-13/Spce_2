document.addEventListener('DOMContentLoaded', function () {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.querySelector("#datatablesSimple");
    if (datatablesSimple) {
        const dataTable = new simpleDatatables.DataTable(datatablesSimple);

        function updateRowNumbers() {
            const rows = datatablesSimple.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                const cell = row.querySelector('td.no-col');
                if (cell) {
                    cell.textContent = index + 1;
                }
            });
        }

        // Panggil saat selesai inisialisasi
        dataTable.on('datatable.init', updateRowNumbers);
        dataTable.on('datatable.page', updateRowNumbers);
        dataTable.on('datatable.sort', updateRowNumbers);
        dataTable.on('datatable.search', updateRowNumbers);
        dataTable.on('datatable.update', updateRowNumbers);
        
        setTimeout(updateRowNumbers, 500);
    }
});
