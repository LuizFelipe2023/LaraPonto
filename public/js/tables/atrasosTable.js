$(document).ready(function () {
    $('#atrasosTable').DataTable({
        language: {
            emptyTable: "Nenhum registro encontrado",
            info: "Mostrando _START_ a _END_ de _TOTAL_ atrasos",
            infoEmpty: "0 atrasos",
            infoFiltered: "(filtrado de _MAX_ no total)",
            lengthMenu: "Mostrar _MENU_ registros",
            search: "Buscar:",
            zeroRecords: "Nenhum resultado",
            paginate: {
                first: "«",
                last: "»",
                next: "›",
                previous: "‹"
            }
        },
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        order: [[2, 'desc']],  // ordena por data
        responsive: true
    });
});
