$(document).ready(function () {
    $('#auditsTable').DataTable({
        language: {
            emptyTable: "Nenhum registro encontrado",
            info: "Mostrando _START_ a _END_ de _TOTAL_ auditorias",
            infoEmpty: "0 auditorias",
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
        order: [[3, 'desc']],  
        responsive: true
    });
});
