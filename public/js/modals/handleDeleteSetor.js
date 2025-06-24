document.addEventListener('DOMContentLoaded', function () {
    var deleteSetorId = null;
    var deleteModal = document.getElementById('confirmDeleteModal');
    var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        deleteSetorId = button.getAttribute('data-setorid');
    });

    confirmDeleteBtn.addEventListener('click', function () {
        if (deleteSetorId) {
            var form = document.getElementById('delete-form-' + deleteSetorId);
            if (form) {
                form.submit();
            }
        }
    });
});
