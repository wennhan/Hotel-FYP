<?php

$GLOBALS['title'] = "Bill-HMS";
$base_url = "http://localhost:8081/hms/";
$GLOBALS['output'] = '';
$GLOBALS['isData'] = "";

require('./../../inc/sessionManager.php');
require('./../../inc/dbPlayer.php');
require('./../../inc/handyCam.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new \dbPlayer\dbPlayer();
    $msg = $db->open();

    if ($msg == "true") {
        $serial = $_POST["serial"];

        $result = $db->delete("delete from cart where serial='" . $serial . "'");

        if ($result !== false) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }
} else {
    echo "error";
}
