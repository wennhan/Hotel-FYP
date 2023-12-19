<?php

?>
<?php

$GLOBALS['title'] = "Bill-HMS";
$base_url = "http://localhost/hms/";
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

        $result = $db->getData("SELECT a.serial,b.name,a.noOfMeal, a.photo, a.title, a.unitPrice, a.status,DATE_FORMAT(a.date, '%D %M,%Y') as mealDate FROM meal as a,studentinfo as b where a.userId=b.userId and b.isActive='Y' and a.status != 'Removed' and a.status != 'Inactive'");
        $GLOBALS['output'] = '';
        if ($result !== false) {

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
            while ($row = $result->fetch_array()) {
                $GLOBALS['isData'] = "1";
                $GLOBALS['output'] .= "<tr>";
                $GLOBALS['output'] .= "<td> <img src='./../../files/photos/" . $row['photo'] . "' alt='Avatar' height='100px' class='img-responsive img-rounded proimg'> </td>";
                $GLOBALS['output'] .= "<td>" . $row['title'] . "</td>";

                $GLOBALS['output'] .= "<td>" . $row['unitPrice'] . "</td>";

                $GLOBALS['output'] .= "<td><input type='number' name='quantity' value='1' min='1'></td>";




                $GLOBALS['output'] .= "<td><a title='Edit' class='btn btn-success btn-circle addToCartBtn' data-serial='" . $row['serial'] . "' data-wtd='edit'><i class='fa fa-shopping-cart'></i></a></td>";

                $GLOBALS['output'] .= "</tr>";
            }

            $GLOBALS['output'] .=  '</tbody>
                                </table>
                            </div>';
        } else {
            echo '<script type="text/javascript"> alert("' . $result . '");window.location="view.php";</script>';
        }
    } else {
        echo '<script type="text/javascript"> alert("' . $msg . '");window.location="view.php";</script>';
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serial = $_POST["serial"];
    $wtd = $_POST["wtd"];

    $db = new \dbPlayer\dbPlayer();
    $msg = $db->open();

    if ($msg == "true") {
        $quantity = $_POST["quantity"]; // Read the quantity from the form
        // Retrieve meal details
        $mealDetails = $db->getData("SELECT unitPrice FROM meal WHERE serial = $serial");

        if ($mealDetails !== false) {
            $unitPrice = $mealDetails->fetch_assoc()['unitPrice'];

            $data = array(
                'userId' => $ses->Get("userIdLoged"),
                'mealId' => $serial,
                'quantity' => $quantity,
                'totalPayment' => $quantity * $unitPrice, // Calculate totalPayment based on quantity and unit price
                'date' => date("Y-m-d")
            );

            $result = $db->insertData("cart", $data);

            if ($result >= 0) {
                echo "Item added to the cart successfully";
            } else {
                echo "Error adding item to the cart";
            }
        } else {
            echo "Error retrieving meal details";
        }
    } else {
        echo "Error opening the database";
    }
} else {
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
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Order </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i> Hostel Order View

                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <form action="http://localhost/hms/ui/cart/studentCart.php" style="display: inline-block; margin-right: 10px;">
                                <button type="submit" class="btn btn-warning">
                                    View Cart
                                </button>
                            </form>

                            <form action="http://localhost/hms/ui/orderPayment/studentOrderPayment.php" style="display: inline-block;">
                                <button type="submit" class="btn btn-success">
                                    Pending
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
    $('.addToCartBtn').on('click', function() {
        var serial = $(this).data('serial');
        var quantity = $(this).closest('tr').find('input[name="quantity"]').val();
        var wtd = $(this).data('wtd');

        $.ajax({
            type: "POST",
            url: "http://localhost/hms/ui/meal/studentView.php",
            data: {
                serial: serial,
                quantity: quantity,
                wtd: wtd
            },
            success: function(response) {
                console.log(response);
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
            $('#myModalLabel').text("Billing Info of [" + BillTo + "]");
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