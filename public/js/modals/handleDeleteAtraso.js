document.addEventListener('DOMContentLoaded', function () {
    var deleteAtrasoId = null;
    var deleteModal    = document.getElementById('confirmDeleteModal');
    var confirmBtn     = document.getElementById('confirmDeleteBtn');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        deleteAtrasoId = event.relatedTarget.getAttribute('data-atrasoid');
    });

    confirmBtn.addEventListener('click', function () {
        if (deleteAtrasoId) {
            var form = document.getElementById('delete-form-' + deleteAtrasoId);
            if (form) form.submit();
        }
    });
});
