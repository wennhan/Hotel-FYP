
<?php

$GLOBALS['title']="Meal-HMS";
$base_url="http://localhost:8081/hms/";
$GLOBALS['output']='';
$GLOBALS['isData']="";
require('./../../inc/sessionManager.php');
require('./../../inc/dbPlayer.php');
require('./../../inc/handyCam.php');

$ses = new \sessionManager\sessionManager();
$ses->start();
$name=$ses->Get("name");
if($ses->isExpired())
{
    header( 'Location:'.$base_url.'login.php');

}
else
{
    $name=$ses->Get("loginId");
    $msg="";
    $db = new \dbPlayer\dbPlayer();
    $msg = $db->open();

    if ($msg = "true") {
        $handyCam = new \handyCam\handyCam();
        $data = array();
        // $result = $db->getData("SELECT serial, userId, photo, title, unitPrice, status, noOfMeal, DATE_FORMAT(date, '%D %M,%Y') as mealDate
        // FROM meal
        // WHERE userId IN (SELECT userId FROM studentinfo WHERE isActive='Y');
        // ");

        $result = $db->getData("SELECT a.serial,b.name,a.noOfMeal, a.photo, a.title, a.unitPrice, a.status,DATE_FORMAT(a.date, '%D %M,%Y') as mealDate FROM meal as a,studentinfo as b where a.userId=b.userId and b.isActive='Y' and a.status != 'Removed'");
        $GLOBALS['output']='';
        if ($result !== false)
        {

            $GLOBALS['output'].='<div class="table-responsive">
                                <table id="mealList" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>

                                        <th>Image</th>
                                            <th>Name</th>
                                            <th>Title</th>
                                            <th>Unit Price</th>
                                            <th>Status</th>
                                             <th>Total Ordered</th>
                                             <th>Date</th>
                                              <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>';
                while ($row = $result->fetch_array()) {
                $GLOBALS['isData']="1";
                $GLOBALS['output'] .= "<tr>";
                $GLOBALS['output'] .= "<td> <img src='./../../files/photos/".$row['photo'] ."' alt='Avatar' height='100px' class='img-responsive img-rounded proimg'> </td>";
                $GLOBALS['output'] .= "<td>" . $row['name'] . "</td>";
                $GLOBALS['output'] .= "<td>" . $row['title'] . "</td>";
                $GLOBALS['output'] .= "<td>" . $row['unitPrice'] . "</td>";
                $GLOBALS['output'] .= "<td>" . $row['status'] . "</td>";

                $GLOBALS['output'] .= "<td>" . $row['noOfMeal'] . "</td>";

                $GLOBALS['output'] .= "<td>" . $row['mealDate'] . "</td>";


                $GLOBALS['output'] .= "<td><a title='Edit' class='btn btn-success btn-circle' href='edit.php?id=" . $row['serial'] ."&wtd=edit'"."><i class='fa fa-pencil'></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger btn-circle' href='edit.php?id=" . $row['serial'] ."&wtd=delete'"."><i class='fa fa-trash-o'></i></a></td>";
                $GLOBALS['output'] .= "</tr>";

            }

            $GLOBALS['output'].=  '</tbody>
                                </table>
                            </div>';


        }
        else
        {
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
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Meal List</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i><i class="fa fa-hand-o-right"></i> Hostel Meal List View
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">


                    <div class="row">
                        <div class="col-lg-12">
                            <hr />
                            <?php if($GLOBALS['isData']=="1"){echo $GLOBALS['output'];}?>
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
    $( document ).ready(function() {



        $('#mealList').dataTable();
    });




</script>
