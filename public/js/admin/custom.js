$(document).ready(function () {
    $('.sidebar-menu').tree();
    // Select
    if ($('.select-2').length > 0)
        $('.select-2').select2();
    // Delete confirm
    $('.deleteRecord').submit(function (e) {
        e.preventDefault();
        var currentForm = this;
        bootbox.confirm({
            message: "Are you sure?",
            size: 'small',
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-danger'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-default'
                }
            },
            callback: function (result) {
                if (result) {
                    currentForm.submit();
                }
            }
        });
    })
});
