<?php
require('./../../inc/dbPlayer.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['orderId'];
    $newStatus = $_POST['newStatus'];
    $db = new \dbPlayer\dbPlayer();
    $msg = $db->open();

    $data = array(
        'paymentBy' => "Bank",
        'status' => $newStatus,
    );

    $db->updateData("stdpayment", "serial", $orderId, $data);

    echo 'success';
} else {
    echo 'Invalid request.';
}
