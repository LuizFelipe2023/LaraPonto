document.addEventListener('DOMContentLoaded', function () {
    var deleteFuncionarioId = null;
    var deleteModal = document.getElementById('confirmDeleteModal');
    var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        deleteFuncionarioId = button.getAttribute('data-funcionarioid');
    });

    confirmDeleteBtn.addEventListener('click', function () {
        if (deleteFuncionarioId) {
            var form = document.getElementById('delete-form-' + deleteFuncionarioId);
            if (form) {
                form.submit();
            }
        }
    });
});
