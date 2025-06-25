document.addEventListener('DOMContentLoaded', function () {
    var deletePontoId = null;
    var deleteModal = document.getElementById('confirmDeleteModal');
    var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        deletePontoId = button.getAttribute('data-pontoid');
    });

    confirmDeleteBtn.addEventListener('click', function () {
        if (deletePontoId) {
            var form = document.getElementById('delete-form-' + deletePontoId);
            if (form) {
                form.submit();
            }
        }
    });
});
