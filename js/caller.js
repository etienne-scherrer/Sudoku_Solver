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
            caller.refreshGrid(response.data);
        });
    },

    showGrid: function () {
        var fields = $('.sudoku-field');
        $.each(fields, function (index, field) {
            field = $(field);
            var fieldValue = field.attr("data-field");
            var rowValue = field.parent().attr("data-row");
            field.text(caller.grid[rowValue][fieldValue] || '');
        });
    },

    refreshGrid: function (gridData) {
        caller.grid = gridData;
        caller.showGrid();
    },

    submitValues: function () {
        $.post('./skeleton/action.php?action=solve', [], function (response) {
            response = JSON.parse(response);
            caller.refreshGrid(response.data);
        });
    },

    listenForChanges: function () {
        $("td[contenteditable=true]").blur(function () {
            var field = $(this);
            var data = {
                row: field.parent().attr("data-row"),
                field: field.attr("data-field"),
                value: field.text()
            };
            var success = function (response) {
                response = JSON.parse(response);
                if (!response.status) {
                    field.text('');
                }
            };
            $.post('./skeleton/action.php?action=change', data, success);
        });
    },

    reset: function () {
        $.post('./skeleton/action.php?action=reset', [], function () {
            caller.refreshGrid({});
        });
    }
};