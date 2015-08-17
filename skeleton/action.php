<?php
include('definitions.php');
if(isset($_GET['action'])) {
    include('storage.php');
    include('solver.php');
    $action = $_GET['action'];
    $storage = new Storage();
    $solver = new Solver();
    switch ($action) {
        case 'create':
            echo $storage->createGrid();
            break;
        case 'change':
            echo $storage->setField($_POST['row'], $_POST['field'], $_POST['value']);
            break;
        case 'solve':
            $solver->solve();
            break;
        case 'test': $storage->makeBlocks();
            break;
    }
}
