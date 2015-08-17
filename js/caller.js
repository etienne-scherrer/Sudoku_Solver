/**
 * Created by Etienne on 17.08.2015.
 */
var caller = {
    grid: {},

    init: function () {
        caller.createGrid();
        caller.listenForChanges();
    },

    createGrid: function () {
        $.post('./skeleton/action.php?action=create', [], function (response) {
            response = JSON.parse(response);
            caller.grid = response.data;
            caller.showGrid();
        });
    },

    showGrid: function () {
        var fields = $('.sudoku-field');
        $.each(fields, function (index, field) {
            field = $(field);
            var rowValue = field.attr("data-field");
            var fieldValue = field.parent().attr("data-row");
            field.text(caller.grid[rowValue][fieldValue] || '');
        });
    },

    submitValues: function () {
        $.post('./action.php?action=solve', [], function () {
            window.location.reload();
        });
    },

    listenForChanges: function () {
        $("td[contenteditable=true]").blur(function () {
            var messageField = $("#status-field");
            var data = {
                row: $(this).attr("data-field"),
                field: $(this).parent().attr("data-row"),
                value: $(this).text()
            };
            var success = function (response) {
                if (response != '') {
                    messageField.show();
                    messageField.text(response);
                    //hide the message
                    setTimeout(function () {
                        //messageField.hide()
                    }, 3000);
                }
            };
            $.post('./skeleton/action.php?action=change', data, success);
        });
    }
};