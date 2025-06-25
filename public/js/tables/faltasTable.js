$(document).ready(function () {
    $('#faltasTable').DataTable({
        language: {
            emptyTable: "Nenhum registro encontrado",
            search: "Buscar:",
            paginate: { first: "«", last: "»", next: "›", previous: "‹" }
        },
        pageLength: 10,
        responsive: true
    });
});