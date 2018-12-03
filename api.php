<?php
require_once __DIR__ . '/vendor/autoload.php';

use TicTac\Classes\Move;

$boardState = ($_POST['boardState'])??'';
$symbol = ($_POST['symbol'])??'';

$moveObj = new Move();
/* //For test
$symbol = 'X';
$boardState = [['X', 'O', ''],
 ['X', 'O', 'O'],
 ['', '', '']];*/

$a = $moveObj->makeMove($boardState, $symbol);
echo json_encode($a);
