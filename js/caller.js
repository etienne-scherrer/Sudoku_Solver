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

    revertStep: function () {
        $.post('./skeleton/action.php?action=revertStep', [], function (response) {
            response = JSON.parse(response);
            caller.refreshGrid(response.data);
            $('#sudoku-revert').hide();
        });
    },

    submitValues: function () {
        $.post('./skeleton/action.php?action=solve', [], function (response) {
            response = JSON.parse(response);
            caller.refreshGrid(response.data);
            $('#sudoku-revert').show();
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
                console.log('response', response);
                if (!response.status) {
                    field.text('');
                }
            };
            $.post('./skeleton/action.php?action=change', data, success);
        });
    },

    reset: function () {
        $.post('./skeleton/action.php?action=reset', [], function () {
            caller.createGrid();
        });
    },

    login: function (username, password) {
        var data = {
            username: username,
            password: password
        };
        $.post('./skeleton/action.php?action=login', data, function (response) {
            response = JSON.parse(response);
            caller.showStatusMessage(response.status, response.message, true);
        });
    },

    logout: function () {
        $.post('./skeleton/action.php?action=login', [], function () {
            window.location.reload();
        });
    },

    register: function (username, password, password2) {
        var data = {
            username: username,
            password: password,
            password2: password2
        };
        $.post('./skeleton/action.php?action=register', data, function (response) {
            response = JSON.parse(response);
            caller.showStatusMessage(response.status, response.message, true);
        });
    },

    showStatusMessage: function (status, message, reload) {
        $('#status-message').show().text(message).addClass(status ? 'success' : 'error');
        setTimeout(function() {
            $('#status-message').hide().text('').removeClass();
            if(reload) {
                window.location.reload();
            }
        }, 3000);
    },

    save: function (sudokuName) {
        var data = {
            sudokuData: caller.grid,
            sudokuName: sudokuName
        };
        if(sudokuName === '') {
            caller.showStatusMessage(0, 'Please enter a sudoku name', false);
        } else {
            $.post('./skeleton/action.php?action=saveSudoku', data, function (response) {
                response = JSON.parse(response);
                caller.showStatusMessage(response.status, response.message, false);
            });
        }
    }
};