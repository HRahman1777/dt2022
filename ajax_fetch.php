<?php
require 'db.php';
session_start();


$sql = "SELECT * FROM `players`";
$myquery = mysqli_query($conn, $sql);

$players = [];
while ($row = mysqli_fetch_array($myquery)) {
    $players[$row['id']] = $row['name'];
}

if (isset($_GET['mat'])) {
    $mid = $_GET['mat'];
    $sql = "SELECT * FROM player_matches WHERE id='$mid'";
    $query = mysqli_query($conn, $sql);
    $res = '<option value="">select one</option>';
    while ($r = mysqli_fetch_array($query)) {
        if (isset($_SESSION['player'])) {
            if ($_SESSION['player'] == $r['id']) {
                $res .= '<option value="' . $r['player1'] . '" selected>' . $players[$r['player1']] . '</option>';
                $res .= '<option value="' . $r['player2'] . '">' . $players[$r['player2']] . '</option>';
            } else {
                $res .= '<option value="' . $r['player1'] . '">' . $players[$r['player1']] . '</option>';
                $res .= '<option value="' . $r['player2'] . '" selected>' . $players[$r['player2']] . '</option>';
            }
        } else {
            $res .= '<option value="' . $r['player2'] . '">' . $players[$r['player2']] . '</option>';
            $res .= '<option value="' . $r['player2'] . '">' . $players[$r['player2']] . '</option>';
        }
    }

    echo $res;
}
