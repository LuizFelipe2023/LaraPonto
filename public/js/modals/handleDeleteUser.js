document.addEventListener('DOMContentLoaded', function () {
    var deleteUserId = null;
    var deleteModal = document.getElementById('confirmDeleteModal');
    var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        deleteUserId = button.getAttribute('data-userid');
    });

    confirmDeleteBtn.addEventListener('click', function () {
        if (deleteUserId) {
            var form = document.getElementById('delete-form-' + deleteUserId);
            if (form) {
                form.submit();
            }
        }
    });
});