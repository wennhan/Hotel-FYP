<?php

$GLOBALS['title'] = "Meal-HMS";
$base_url = "http://localhost:8081/hms/";
$GLOBALS['output'] = '';
$GLOBALS['isData'] = "";
require('./../../inc/sessionManager.php');
require('./../../inc/dbPlayer.php');
require('./../../inc/handyCam.php');

$ses = new \sessionManager\sessionManager();
$ses->start();
$name = $ses->Get("name");
if ($ses->isExpired()) {
    header('Location:' . $base_url . 'login.php');
} else {
    $name = $ses->Get("loginId");
    $msg = "";
    $db = new \dbPlayer\dbPlayer();
    $msg = $db->open();

    if ($msg == "true") {
        $handyCam = new \handyCam\handyCam();
        $data = array();

        $result = $db->getData("SELECT op.serial, op.userId AS orderUserId, s.name, m.photo,  m.title, m.unitPrice, op.status, op.totalPayment , op.quantity AS totalOrdered, DATE_FORMAT(op.date, '%D %M,%Y') AS orderDate
            FROM orderpayment AS op
            JOIN meal AS m ON op.mealId = m.serial
            JOIN studentinfo AS s ON op.userId = s.userId
            WHERE s.isActive='Y' AND m.status != 'Removed' AND op.status = 'Pending';");

        $GLOBALS['output'] = '';

        if ($result !== false) {
            $GLOBALS['output'] .= '<div class="table-responsive">
                                <table id="orderPaymentList" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Order User</th>
                                            <th>Title</th>
                                            <th>Total Payment</th>
                                            <th>Status</th>
                                            <th>Total Ordered</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

            while ($row = $result->fetch_array()) {
                $GLOBALS['isData'] = "1";
                $GLOBALS['output'] .= "<tr>";
                $GLOBALS['output'] .= "<td> <img src='./../../files/photos/" . $row['photo'] . "' alt='Avatar' height='100px' class='img-responsive img-rounded proimg'> </td>";
                $GLOBALS['output'] .= "<td>" . $row['name'] . " [" . $row['orderUserId'] . "]" . "</td>";
                $GLOBALS['output'] .= "<td>" . $row['title'] . "</td>";
                $GLOBALS['output'] .= "<td>" . $row['totalPayment'] . "</td>";

                $statusOptions = array('Pending', 'Done', 'Canceled');

                $statusDropdown = '<select name="status" class="form-control status-dropdown" data-order-id="' . $row['serial'] . '">';
                foreach ($statusOptions as $option) {
                    $selected = ($row['status'] == $option) ? 'selected' : '';
                    $statusDropdown .= '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
                }
                $statusDropdown .= '</select>';
                $GLOBALS['output'] .= "<td>" . $statusDropdown . "</td>";



                $GLOBALS['output'] .= "<td>" . $row['totalOrdered'] . "</td>";
                $GLOBALS['output'] .= "<td>" . $row['orderDate'] . "</td>";
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

?>
<?php include('./../../master.php'); ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Student Order List</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i><i class="fa fa-hand-o-right"></i> Hostel Student Order List View
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">


                    <div class="row">
                        <div class="col-lg-12">
                            <hr />
                            <?php if ($GLOBALS['isData'] == "1") {
                                echo $GLOBALS['output'];
                            } ?>
                        </div>
                    </div>


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



        $('#mealList').dataTable();
    });


    $(document).ready(function() {
        $(document).on('change', '.status-dropdown', function() {
            var orderId = $(this).data('order-id');
            var newStatus = $(this).val();

            $.ajax({
                type: 'POST',
                url: 'http://localhost:8081/hms/ui/orderpayment/updateStatus.php',
                data: {
                    orderId: orderId,
                    newStatus: newStatus
                },
                success: function(response) {
                    if (response == 'success') {
                        alert('Status updated successfully.');
                        location.reload();
                    } else {
                        alert('Failed to update status.');
                        console.log(response);
                    }
                },
                error: function() {
                    alert('Error in AJAX request.');
                }
            });
        });

        // Initialize DataTable
        $('#orderPaymentList').dataTable();
    });
</script>