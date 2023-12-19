<?php
require('./../../inc/dbPlayer.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['orderId'];
    $newStatus = $_POST['newStatus'];
    $db = new \dbPlayer\dbPlayer();
    $msg = $db->open();


    $data = array(

        'status' => $newStatus,

    );

    $db->updateData("orderpayment", "serial", $orderId, $data);

    echo 'success';
} else {
    echo 'Invalid request.';
}
