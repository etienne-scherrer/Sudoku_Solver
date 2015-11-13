<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sudoku Solver</title>
    <link rel="stylesheet" type="text/css" href="./css/base.css">
    <?php if (file_exists('./css/' . $content . '.css')): ?>
        <link rel="stylesheet" type="text/css" href="./css/<?= $content ?>.css">
    <?php endif; ?>
    <script type="text/javascript" src="./js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="./js/caller.js"></script>
</head>
<body>
<div id="status-message"></div>