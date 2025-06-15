window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        const dataTable = new simpleDatatables.DataTable(datatablesSimple);

        const updateRowNumbers = () => {
            const rows = datatablesSimple.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                const noCell = row.querySelector('td.no-col');
                if (noCell) noCell.textContent = index + 1;
            });
        };

        dataTable.on('datatable.init', updateRowNumbers);
        dataTable.on('datatable.page', updateRowNumbers);
        dataTable.on('datatable.sort', updateRowNumbers);
        dataTable.on('datatable.search', updateRowNumbers);
        dataTable.on('datatable.update', updateRowNumbers);
    }
});
