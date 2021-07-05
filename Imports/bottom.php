<!--Bootstrap Tooltip-->
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<!--Bootstrap Confirmation-->
<script>
    $('[data-toggle=confirmation]').confirmation({
        rootSelector: '[data-toggle=confirmation]',
    });
</script>
<!--Context-Menu-->
<script type="text/javascript">
    $(function () {
        $.contextMenu({
            selector: '.context-menu',
            callback: function (key) {
                if (key === "edit") {
                    $.notify(key, 'success');
                } else if (key === "delete") {
                    $.notify(key, 'success');
                }
            },
            items: {
                "edit": {name: "Edit"},
                "delete": {name: "Delete"}
            }
        });
    });
</script>