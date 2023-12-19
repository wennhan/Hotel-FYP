<?php

?>
<?php

$GLOBALS['title'] = "Bill-HMS";
$base_url = "http://localhost:8081/hms/";
$GLOBALS['output'] = '';
$GLOBALS['isData'] = "";

require('./../../inc/sessionManager.php');
require('./../../inc/dbPlayer.php');
require('./../../inc/handyCam.php');


$ses = new \sessionManager\sessionManager();
$ses->start();
$name = $ses->Get("name");
$loginId = $ses->Get("userIdLoged");
$loginGrp = $ses->Get("userGroupId");
if ($ses->isExpired()) {
    header('Location:' . $base_url . 'login.php');
} else {
    $name = $ses->Get("loginId");
    $msg = "";
    $db = new \dbPlayer\dbPlayer();
    $msg = $db->open();

    if ($msg = "true") {
        $handyCam = new \handyCam\handyCam();
        $data = array();
        // $result = $db->getData("SELECT serial, userId, photo, title, unitPrice, status, noOfMeal, DATE_FORMAT(date, '%D %M,%Y') as mealDate
        // FROM meal
        // WHERE userId IN (SELECT userId FROM studentinfo WHERE isActive='Y');
        // ");

        // $result = $db->getData("SELECT a.serial,b.name,a.noOfMeal, a.photo, a.title, a.unitPrice, a.status,DATE_FORMAT(a.date, '%D %M,%Y') as mealDate FROM meal as a,studentinfo as b where a.userId=b.userId and b.isActive='Y' and a.status != 'Removed'");

        // Update the query for retrieving cart items
        $cartResult = $db->getData("SELECT c.serial, c.userId, c.mealId, c.quantity, c.totalPayment, c.date,
                                 m.title, m.unitPrice, m.photo
                           FROM cart AS c
                           INNER JOIN meal AS m ON c.mealId = m.serial
                           WHERE c.userId = '$loginId'
                           and m.status != 'Inactive'
                           and m.status != 'Removed'");

        // Check if the query was successful
        if ($cartResult !== false) {
            $GLOBALS['output'] .= '<div class="table-responsive">
                            <table id="mealList" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Unit Price</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>';

            $totalPayment = 0;
            while ($row = $cartResult->fetch_array()) {
                $GLOBALS['isData'] = "1";
                $GLOBALS['output'] .= "<tr>";
                $GLOBALS['output'] .= "<td> <img src='./../../files/photos/" . $row['photo'] . "' alt='Avatar' height='100px' class='img-responsive img-rounded proimg'> </td>";
                $GLOBALS['output'] .= "<td>" . $row['title'] . "</td>";
                $GLOBALS['output'] .= "<td>" . $row['totalPayment'] . "</td>";
                $totalPayment += $row['totalPayment'];
                $GLOBALS['output'] .= "<td>" . $row['quantity'] . "</td>";
                $GLOBALS['output'] .= "<td><a title='Delete' class='btn btn-danger btn-circle deleteBtn' data-serial='" . $row['serial'] . "' href='#'><i class='fa fa-trash-o'></i></a></td>";

                $GLOBALS['output'] .= "</tr>";
            }

            $GLOBALS['output'] .= '</tbody>
                        </table>
                    </div>';
        } else {
            // Handle the case when the query fails
            echo '<script type="text/javascript"> alert("' . $cartResult . '");window.location="studentCart.php";</script>';
        }
    } else {
        echo '<script type="text/javascript"> alert("' . $msg . '");window.location="studentCart.php";</script>';
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["btnSave"])) {
        $db = new \dbPlayer\dbPlayer();
        $msg = $db->open();

        if ($msg == "true") {
            $cartResult = $db->getData("SELECT c.serial, c.userId, c.mealId, c.quantity, c.totalPayment, c.date,
                                     m.title, m.unitPrice, m.photo
                               FROM cart AS c
                               INNER JOIN meal AS m ON c.mealId = m.serial
                               WHERE c.userId = '$loginId'
                               ");

            if ($cartResult !== false) {
                while ($row = $cartResult->fetch_array()) {
                    $userId = $ses->Get("userIdLoged");
                    $date = date("Y-m-d");

                    $orderPaymentData = array(
                        'userId' => $userId,
                        'mealId' => $row['mealId'],
                        'totalPayment' => $row['totalPayment'],
                        'quantity' => $row['quantity'],
                        'status' => 'Pending',
                        'date' => $date
                    );

                    $resultOrderPayment = $db->insertData("orderpayment", $orderPaymentData);
                    $result = $db->delete("delete from cart where userId='" . $userId . "'");

                    $mealTotalOrderedDetails = $db->getData("SELECT noOfMeal FROM meal WHERE serial = " . $row['mealId']);
                    $currentNoOfMeal = $mealTotalOrderedDetails->fetch_array()['noOfMeal'];

                    $newNoOfMeal = $row['quantity'] + $currentNoOfMeal;

                    $dataNoOfMeal = array(
                        'noOfMeal' => $newNoOfMeal,
                    );

                    $db->updateData("meal", "serial", $row['mealId'], $dataNoOfMeal);

                    if ($resultOrderPayment < 0) {
                        echo '<script type="text/javascript"> alert("Error confirming order."); window.location="studentCart.php";</script>';
                        exit;
                    }
                }

                echo '<script type="text/javascript"> alert("Order confirmed successfully."); window.location="studentCart.php";</script>';
            } else {
                echo '<script type="text/javascript"> alert("' . $cartResult . '"); window.location="studentCart.php";</script>';
            }
        } else {
            echo '<script type="text/javascript"> alert("' . $msg . '"); window.location="cart.php";</script>';
        }
    }
}

if ($loginGrp === "UG004") {

    include('./../../smater.php');
} else {
    include('./../../master.php');
}
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Cart</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i> Hostel Cart View

                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <form action="http://localhost:8081/hms/ui/meal/studentView.php">
                                <button type="submit" class="btn btn-primary">
                                    Back
                                </button>
                            </form>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-lg-12">
                            <hr />
                            <?php if ($GLOBALS['isData'] == "1") {
                                echo $GLOBALS['output'];
                            } ?>
                        </div>
                    </div>


                    <!-- Modal -->
                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header alert alert-info">
                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                    <h4 id="myModalLabel" class="modal-title"></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-lg-6">
                                                <div class=""><label>Bill No: </label> <span id="billId"></span></div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class=""><label>Bill Date: </label> <span id="billDate"></span></div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table id="mbilllist" class="table table-responsive table-hover text-center">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center text-primary">Type</th>
                                                        <th class="text-center text-primary">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                            <div class="text-info"><label>Total: </label> <span id="total"></span></div>
                                        </div>

                                    </div>
                                    <p></p>
                                </div>
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-primary" type="button">Close</button>

                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->


                    <form action="http://localhost:8081/hms/ui/cart/studentCart.php" method="post">
                        <div class="text-info text-right"><label>Total Payment: </label> <span id="totalPayment"><?php echo $totalPayment; ?></span></div>

                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <!-- Add the submit button with the name "btnSave" -->
                                <button type="submit" class="btn btn-success" name="btnSave">
                                    Confirm
                                </button>
                            </div>
                        </div>
                    </form>


                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>

</div>
<!-- /#page-wrapper -->


<?php include('./../../footer.php'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        // Other code...

        // Add this click event listener
        $('.deleteBtn').on('click', function(e) {
            e.preventDefault();
            var serial = $(this).data('serial');

            // Make an AJAX call to delete the item
            $.ajax({
                type: "POST",
                url: "http://localhost:8081/hms/ui/cart/deleteCart.php",
                data: {
                    serial: serial
                },
                success: function(response) {
                    // Check the response and update the view accordingly
                    if (response === 'success') {
                        console.log(response);
                        alert("Item deleted successfully");
                        location.reload(true);

                    } else {
                        alert("Error deleting item");
                        console.log(response);

                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error: " + textStatus, errorThrown);
                    alert("Error deleting item");
                }
            });
        });

        // Other code...
    });


    $('.addToCartBtn').on('click', function() {
        var serial = $(this).data('serial');
        var quantity = $(this).closest('tr').find('input[name="quantity"]').val();
        var wtd = $(this).data('wtd');

        $.ajax({
            type: "POST",
            url: "http://localhost:8081/hms/ui/meal/studentView.php",
            data: {
                serial: serial,
                quantity: quantity,
                wtd: wtd
            },
            success: function(response) {
                alert("Added Successfully");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error: " + textStatus, errorThrown);
                alert("Error adding item to the cart");
            }
        });
    });




    $(document).ready(function() {



        $('#billList').dataTable();
        $('.showModal').on('click', function(e) {
            e.preventDefault();

            var table = document.getElementById('billList');
            var r = $(this).parent().parent().index();
            var BillTo = table.rows[r + 1].cells[1].innerHTML;
            var billId = table.rows[r + 1].cells[0].innerHTML;
            var date = table.rows[r + 1].cells[3].innerHTML;
            var t = table.rows[r + 1].cells[2].innerHTML;
            $('#myModalLabel').text("Cart Info of [" + BillTo + "]");
            $('#billId').text(billId);
            $('#billDate').text(date);
            $('#total').text(t);


            value = new Array();
            $.ajax({
                type: "GET",
                url: "action.php",
                dataType: 'json',
                success: function(result) {
                    alert(result);
                }

            });
            //  $("#myModal").modal('show');


        });
    });
</script>