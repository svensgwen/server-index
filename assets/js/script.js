$(document).ready(function () {
    $("#search").on("keyup", function () {
        let value = $(this).val().toLowerCase();

        $(".folder-item").each(function () {
            let name = $(this).data("name");
            $(this).toggle(name.indexOf(value) > -1);
        });
    });

    $(document).on("click", ".pin-btn", function () {
        let folder = $(this).data("folder");
        let action = $(this).data("action");

        $.ajax({
            url: "api/folder-action.php",
            type: "POST",
            dataType: "json",
            data: {
                folder: folder,
                action: action
            },
            success: function (res) {
                if (res.success) {
                    location.reload();
                } else {
                    alert(res.message);
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert("Pin/unpin failed.");
            }
        });
    });

    $(document).on("click", ".hide-btn", function () {
        let folder = $(this).data("folder");

        $.ajax({
            url: "api/folder-action.php",
            type: "POST",
            dataType: "json",
            data: {
                folder: folder,
                action: "hide"
            },
            success: function (res) {
                if (res.success) {
                    location.reload();
                } else {
                    alert(res.message);
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert("Hide failed.");
            }
        });
    });

    $(document).on("click", ".unhide-btn", function () {
        let folder = $(this).data("folder");

        $.ajax({
            url: "api/folder-action.php",
            type: "POST",
            dataType: "json",
            data: {
                folder: folder,
                action: "unhide"
            },
            success: function (res) {
                if (res.success) {
                    location.reload();
                } else {
                    alert(res.message);
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert("Unhide failed.");
            }
        });
    });
});