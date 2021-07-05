$(function () {
    var targetColumn;
    var newValue;
    var referenceColumn;
    var referenceValue;
    var oldValue;
    var selectedCell;
    var editor;

    $("#attendeeList").load("attendeeList.php");

    $("#eventList").load("eventList.php");

    setInterval(function () {
        checkUpdates("event");
        checkUpdates("attendee");
    }, 1000);

    $(document).on("contextmenu", function (e) {
        return false;
    });

    $("#addEvent").click(function (e) {
        $('#newEventForm').modal('show');
    });

    $("#deleteEvent").click(function (e) {
        $('#deleteEventForm').modal('show');
    });

    $("#addAttendee").click(function (e) {
        for (var i = 0; i < field.length; i++) {
            $("#" + field[i]).val("");
        }
        $('#confirmNewAttendee').hide();
        $('#newAttendeeForm').modal('show');
    });

    $("#confirmDeleteRow").click(function (e) {
        deleteRow("attendee", selectedRow);
    });

    $("#confirmDeleteEvent").click(function (e) {
        deleteRow("event", "null");
        setTimeout(function () {
            window.location.replace("index.php");
        }, 500);
    });

    $(document).on("keydown", function (e) {
        if ($('#deleteRow').is(':visible')) {
            if (e.keyCode === 13) {
                if ($('#deleteRow').is(':visible')) {
                    deleteRow("attendee", selectedRow);
                    $('#deleteRow').modal('hide');
                }
            } else if (e.keyCode === 27) {
                $('#deleteRow').modal('hide');
            }
        }
    });

    var values;
    var field = ["firstName", "lastName", "company", "designation", "email", "contactNumber", "eventFee"];
    $(document).on("keyup change", "#newAttendeeForm", function (e) {
        values = [$("#firstName").val(), $("#lastName").val(), $("#company").val(), $("#designation").val(), $("#email").val(), $("#contactNumber").val(), $("#eventFee").val()];
        var emptyValues = 0;
        for (var i = 0; i < field.length; i++) {
            if (values[i] === "" || !values[i].replace(/\s/g, '').length) {
                emptyValues++;
            }
        }
        if (emptyValues !== field.length) {
            if (!$("#confirmNewAttendee").is(':visible')) {
                $("#confirmNewAttendee").show(100);
            }
        } else {
            $("#confirmNewAttendee").hide(100);
            for (var i = 0; i < field.length; i++) {
                if (values[i] === "" || !values[i].replace(/\s/g, '').length) {
                    $("#" + field[i]).val("");
                }
            }
        }
    });

    $(document).on("click", "#confirmNewAttendee", function (e) {
        values = [$("#firstName").val(), $("#lastName").val(), $("#company").val(), $("#designation").val(), $("#email").val(), $("#contactNumber").val(), $("#eventFee").val()];
        insertAttendee(JSON.stringify(values));
        $('#newAttendeeForm').modal('hide');
    });

    $(document).on("click", "#confirmNewEvent", function (e) {
        if (!$("#eventFormTitle").val().replace(/\s/g, '').length) {
            $("#eventFormTitle").val("");
            setTimeout(function () {
                $("#eventFormTitle").attr('placeholder', "A title is required!");
            }, 100);
            setTimeout(function () {
                $("#eventFormTitle").attr('placeholder', "");
            }, 300);
            setTimeout(function () {
                $("#eventFormTitle").attr('placeholder', "A title is required!");
            }, 400);
            setTimeout(function () {
                $("#eventFormTitle").attr('placeholder', "");
            }, 1000);
        } else {
            insertEvent($("#eventFormTitle").val(), $("#eventFormDesc").val());
            $("#eventFormTitle").val("");
            $("#eventFormDesc").val("");
            $('#newEventForm').modal('hide');
        }
    });

    $(document).on("dblclick", "td:not(.position)", function (e) {
        $("tr").removeClass("tr-selected");
        targetColumn = $(this).attr('class');
        referenceValue = $(this).closest('tr').attr('value');
        referenceColumn = $(this).closest('tr').attr('class');
        oldValue = $(this).html();
        selectedCell = $(this);
        if (targetColumn === "eventFee") {
            editor = ".edit-fee";
        } else {
            editor = ".edit-box";
        }
        if ($(this).attr('value') === "true") {
            $(editor).val(oldValue);
        } else {
            $(editor).val("");
        }
        setTimeout(function () {
            $(editor).show(50);
            $(editor).css({"top": e.pageY + "px", "left": e.pageX + "px"});
            $(editor).focus();
        }, 50);
    });

    var selectedRow;
    $(document).on("click", "tr:not(.tableHeader)", function (e) {
        e.stopPropagation();
        selectedRow = $(this).closest('tr').attr('value');
        $("tr").removeClass("tr-selected");
        $(this).addClass("tr-selected");
    });

    $(document).on("click", function (e) {
        selectedRow = "";
        $("tr").removeClass("tr-selected");
    });

    $(document).on("keydown", function (e) {
        if (selectedRow) {
            if (e.keyCode === 46) {
                $('#deleteRow').modal('show');
            }
        }
    });

    $(document).on("focusout keydown", ".edit-box, .edit-fee", function (e) {
        newValue = $(editor).val().replace(/(\r\n|\n|\r)/gm, "");
        if (e.keyCode === 13 || $(".edit-box, .edit-fee").is(":focus") === false) {
            confirmValue(editor, targetColumn, newValue, referenceColumn, referenceValue, oldValue, selectedCell);
        }
    });

    $(document).on("click", ".eventName", function (e) {
        var eventId = $(this).attr('id');
        $.ajax({
            url: 'Classes/CRUD.php',
            type: 'POST',
            dataType: 'text',
            data: {
                Read: "eventId",
                eventId: eventId
            },
            success: function (data) {},
            error: function (data) {}
        });
    });
});

function deleteRow(type, referenceValue) {
    $.ajax({
        url: 'Classes/CRUD.php',
        type: 'POST',
        dataType: 'TEXT',
        data: {
            Delete: type,
            referenceValue: referenceValue
        },
        success: function (data) {},
        error: function (data) {}
    });
}

function insertEvent(title, description) {
    $.ajax({
        url: 'Classes/CRUD.php',
        type: 'POST',
        dataType: 'TEXT',
        data: {
            Create: "insertEvent",
            title: title,
            description: description
        },
        success: function (data) {},
        error: function (data) {}
    });
}

function insertAttendee(values) {
    $.ajax({
        url: 'Classes/CRUD.php',
        type: 'POST',
        dataType: 'TEXT',
        data: {
            Create: "insertAttendee",
            values: values
        },
        success: function (data) {},
        error: function (data) {}
    });
}

function checkUpdates(target) {
    $.ajax({
        url: 'Classes/CRUD.php',
        type: 'POST',
        dataType: 'TEXT',
        data: {
            Read: "checkUpdates",
            target: target
        },
        success: function (data) {
            if (target === "attendee") {
                if (data === "true") {
                    $("#attendeeList").load("attendeeList.php");
                }
            } else {
                if (data === "true") {
                    $("#eventList").load("eventList.php");
                }
            }
        },
        error: function (data) {}
    });
}

function confirmValue(editor, targetColumn, newValue, referenceColumn, referenceValue, oldValue, selectedCell) {
    if (newValue !== oldValue && newValue.replace(/\s/g, '').length !== 0) {
        update(targetColumn, newValue, referenceColumn, referenceValue, selectedCell);
    }
    $(editor).hide(100);
    setTimeout(function () {
        $(editor).css("display", "none");
    }, 100);
}

function update(targetColumn, newValue, referenceColumn, referenceValue, selectedCell) {
    $.ajax({
        url: 'Classes/CRUD.php',
        type: 'POST',
        dataType: 'TEXT',
        data: {
            Update: "tableCell",
            targetColumn: targetColumn,
            newValue: newValue,
            referenceColumn: referenceColumn,
            referenceValue: referenceValue
        },
        success: function (data) {
            $("#attendeeList").load("attendeeList.php");
        },
        error: function (data) {}
    });
}