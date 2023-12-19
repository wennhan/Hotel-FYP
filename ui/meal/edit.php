<?php

/**
 * Created by PhpStorm.
 * User: troot
 * Date: 1/5/15
 * Time: 1:57 PM
 */


$GLOBALS['title'] = "Mealt-HMS";
$base_url = "http://localhost/hms/";
require('./../../inc/sessionManager.php');
require('./../../inc/dbPlayer.php');
require('./../../inc/handyCam.php');
require('./../../inc/fileUploader.php');

$GLOBALS['serial'] = '';

if (isset($_GET['id']) && $_GET['wtd']) {
    $ses = new \sessionManager\sessionManager();
    $ses->start();
    $ses->Set("serialFor", $_GET['id']);
    $GLOBALS['serial'] = $ses->Get("serialFor");

    $db = new \dbPlayer\dbPlayer();
    $msg = $db->open();
    if ($_GET['wtd'] === "edit") {



        if ($msg = "true") {

            $data = array();
            $result = $db->getData("SELECT a.serial,b.name,a.userId,a.noOfMeal, a.photo, a.title, a.unitPrice, a.status, a.date FROM meal as a,studentinfo as b where a.serial='" . $GLOBALS['serial'] . "' and a.userId=b.userId ");
            // var_dump($result);
            $handyCam = new \handyCam\handyCam();
            if ($result !== false) {
                $data = array();
                while ($row = $result->fetch_array()) {
                    array_push($data, $row['name'] . '[' . $row['userId'] . ']');
                    array_push($data, $row['noOfMeal']);
                    array_push($data, $row['photo']);
                    array_push($data, $row['title']);
                    array_push($data, $row['unitPrice']);
                    array_push($data, $row['status']);

                    array_push($data, $handyCam->getAppDate($row['date']));
                }
                // var_dump($data);
                formRender($data);
            } else {
                echo '<script type="text/javascript"> alert("' . $result . '");window.location="view.php";</script>';
            }
        } else {
            echo '<script type="text/javascript"> alert("' . $msg . '");window.location="view.php";</script>';
        }
    } elseif ($_GET['wtd'] === "delete") {
        if ($msg == "true") {
            // Instead of deleting, update the status to "Removed"
            $result = $db->updateData("meal", "serial", $GLOBALS['serial'], array('status' => 'Removed'));

            if ($result === "true") {
                echo '<script type="text/javascript"> alert("Meal Marked as Removed Successfully.");
                        window.location.href = "view.php";
                    </script>';
            } else {
                echo '<script type="text/javascript"> alert("' . $result . '");window.location="view.php";</script>';
            }
        } else {
            echo '<script type="text/javascript"> alert("' . $msg . '");window.location="view.php";</script>';
        }
    } else {
        header("location: view.php");
    }
} elseif ($_GET['update'] == "1") {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {



        if (isset($_POST["btnUpdate"])) {
            $handyCam = new \handyCam\handyCam();
            $originalFilename = $_FILES['perPhoto']['name'];

            // Check if a file is uploaded
            if (!empty($originalFilename)) {
                $pathInfo = pathinfo($originalFilename);
                $filenameOnly = $pathInfo['filename'];
                $flup = new fileUploader\fileUploader();
                $perPhoto = $flup->upload("/hms/files/photos/", $_FILES['perPhoto'], $filenameOnly);
            } else {
                $perPhoto = NULL;
            }

            $ses = new \sessionManager\sessionManager();
            $ses->start();
            $serialFor = $ses->Get("serialFor");

            $db = new \dbPlayer\dbPlayer();
            $msg = $db->open();

            if ($msg == "true") {
                $handyCam = new \handyCam\handyCam();
                $data = array(
                    'title' => $_POST['title'],
                    'status' => $_POST['status'],
                    'unitPrice' => $_POST['unitPrice'],
                    'noOfMeal' => $_POST['noOfMeal'],
                    'date' => $handyCam->parseAppDate($_POST['date'])
                );

                if (!empty($perPhoto)) {
                    $data['photo'] = $perPhoto;
                }


                $result = $db->updateData("meal", "serial", $serialFor, $data);
                // var_dump($result);
                if ($result === "true") {

                    //  $db->close();
                    echo '<script type="text/javascript"> alert("Meal Updated Successfully.");
                                window.location.href = "view.php";
                        </script>';
                    // header("location: block.php");

                } else {
                    echo '<script type="text/javascript"> alert("' . $result . '");</script>';
                }
            } else {
                echo '<script type="text/javascript"> alert("' . $msg . '");</script>';
            }
        }
    }
} else {
    header("location: deposit.php");
}
function formRender($data)
{ ?>

    <?php include('./../../master.php'); ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Update Meal</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-info-circle fa-fw"></i>Meal Update [<?php echo $data[0]; ?>]
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form name="deposit" action="edit.php?update=1" accept-charset="utf-8" method="post" enctype="multipart/form-data">


                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-lg-4">
                                                <div class="form-group ">
                                                    <label>&nbsp;</label>
                                                    <div class="input-group">


                                                        <input type="text" placeholder="" class="form-control" name="" value="<?php echo $data[0]; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group ">
                                                    <label>No Of Meal</label>
                                                    <div class="input-group">

                                                        <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                        <input type="text" placeholder="No Of meal" class="form-control" name="noOfMeal" value="<?php echo $data[1]; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group ">
                                                    <label>Date</label>
                                                    <div class="input-group date" id='dp1'>

                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                                                        <input type="text" placeholder="Date" class="form-control datepicker" name="date" value="<?php echo $data[6]; ?>" required data-date-format="dd/mm/yyyy">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-lg-4">
                                                <div class="form-group ">
                                                    <label>Photo</label>
                                                    <div class="input-group">

                                                        <input type="file" class="form-control" name="perPhoto">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group ">
                                                    <label>Title</label>
                                                    <div class="input-group">

                                                        <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                        <input type="text" placeholder="Title" class="form-control" value="<?php echo $data[3]; ?>" name="title" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status" required="">
                                                <?php
                                                if ($data[5] === "Active") {
                                                    echo ' <option value="Active" selected>Active</option>';
                                                    echo '<option value="Inactive">Inactive</option>';
                                                } else {
                                                    echo ' <option value="Active" >Active</option>';
                                                    echo '<option value="Inactive" selected>Inactive</option>';
                                                }

                                                ?>

                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Unit Price</label>
                                            <div class="input-group">

                                                <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                <input type="text" placeholder="Unit Price" class="form-control" value="<?php echo $data[4]; ?>" name="unitPrice" required>
                                            </div>
                                        </div>
                                    </div>

                            </div>
                        </div>



                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-5"></div>
                                <div class="col-lg-2">
                                    <div class="form-group ">
                                        <button type="submit" class="btn btn-success" name="btnUpdate"><i class="fa fa-2x fa-check"></i>Update</button>
                                    </div>

                                </div>
                                <div class="col-lg-5">
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>

    </div>

    </div>



    <?php include('./../../footer.php'); ?>

<?php } ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.datepicker').datepicker();


    });
</script>