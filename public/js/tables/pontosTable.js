$(document).ready(function () {
    let table = $('#pontosTable').DataTable({
        language: {
            decimal: "",
            emptyTable: "Nenhum dado disponível na tabela",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando 0 a 0 de 0 registros",
            infoFiltered: "(filtrado de _MAX_ registros no total)",
            thousands: ",",
            lengthMenu: "Mostrar _MENU_ registros",
            loadingRecords: "Carregando...",
            processing: "Processando...",
            search: "Buscar:",
            zeroRecords: "Nenhum registro correspondente encontrado",
            paginate: {
                first: "Primeiro",
                last: "Último",
                next: "Próximo",
                previous: "Anterior"
            },
            aria: {
                sortAscending: ": ativar para ordenar a coluna em ordem crescente",
                sortDescending: ": ativar para ordenar a coluna em ordem decrescente"
            }
        },
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        ordering: true,
        order: [[2, 'desc']], 
        responsive: true
    });

    $('#setor_filtro').on('change', function () {
        let filtroSetor = $(this).val();
        if (filtroSetor) {
            table.column(1).search(filtroSetor).draw();
        } else {
            table.column(1).search('').draw();
        }
    });

});
