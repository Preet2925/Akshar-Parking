<?php
require "conn.php";
date_default_timezone_set('Asia/Kolkata');
// Check if form is submitted and the 'make_bill' button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['make_bill'])) {
    $id = $_POST["id"];
    
    // Update flag value to 1 for the specified id
    $updateSql = "UPDATE addtruckdetails SET Flag = 1 WHERE id = '$id'";
    if ($conn->query($updateSql) === TRUE) {
        // Display success message if the update is successful
        echo '<script>alert("Flag value updated to 1");</script>';
    } else {
        // Display error message if the update fails
        echo "Error updating record: " . $conn->error;
    }
}
// Fetch truck data from database
$id = isset($_POST['id']) ? mysqli_real_escape_string($conn, $_POST['id']) : '';
$fetchSql = "SELECT * FROM addtruckdetails WHERE id = '$id'";
$result = $conn->query($fetchSql);
$row = $result->fetch_assoc();
$entryDateTime = $row['DateTime'];
$currentDateTime = date('Y-m-d\TH:i');

$entryDateTimeObj = new DateTime($entryDateTime);
$currentDateTimeObj = new DateTime($currentDateTime);
$interval = $entryDateTimeObj->diff($currentDateTimeObj);
$totalMinutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;
$totalHours = floor($totalMinutes / 60);
$remainingMinutes = $totalMinutes % 60;


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Check Out</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico" />
        <!-- Theme Config Js -->
        <script src="assets/js/config.js"></script>
        <!-- App css -->
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
        <!-- Icons css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ========== Topbar Start ========== -->
            <?php require "topbar.php" ?>
            <!-- ========== Topbar End ========== -->

            <!-- ========== Left Sidebar Start ========== -->
            <?php require "left-sidebar.php" ?>
            <!-- ========== Left Sidebar End ========== -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <div class="content">
                    <!-- Start Content-->
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Checkout Page</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-10">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="needs-validation" novalidate method="POST">
                                            <div class="mb-3">
                                                <label class="form-label" for="validationCustom01">Invoice ID</label>
                                                <div class="input-group">
                                                    <!-- Display the Invoice ID -->
                                                    <input type="text" class="form-control" id="validationCustom01" placeholder="Invoice Id" value="<?php echo isset($_POST['id']) ? $_POST['id'] : ''; ?>" readonly />
                                                    <!-- Store the Invoice ID in a hidden field for form submission -->
                                                    <input type="hidden" name="id" value="<?php echo isset($_POST['id']) ? $_POST['id'] : ''; ?>" />
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="validationCustom02">Truck Number</label>
                                                <!-- Display the Truck Number -->
                                                <input type="text" class="form-control" id="validationCustom02" placeholder="Truck Number" value="<?php echo isset($_POST['TruckNumber']) ? $_POST['TruckNumber'] : ''; ?>" readonly />
                                                <!-- Store the Truck Number in a hidden field for form submission -->
                                                <input type="hidden" name="TruckNumber" value="<?php echo isset($_POST['TruckNumber']) ? $_POST['TruckNumber'] : ''; ?>" />
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="validationCustomUsername">Phone Number</label>
                                                <div class="input-group">
                                                    <!-- Display the Phone Number -->
                                                    <span class="input-group-text" id="inputGroupPrepend">+91</span>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="validationCustomUsername"
                                                        placeholder="Driver Number"
                                                        aria-describedby="inputGroupPrepend"
                                                        value="<?php echo isset($_POST['PhoneNumber']) ? $_POST['PhoneNumber'] : ''; ?>"
                                                        readonly
                                                    />
                                                    <!-- Store the Phone Number in a hidden field for form submission -->
                                                    <input type="hidden" name="PhoneNumber" value="<?php echo isset($_POST['PhoneNumber']) ? $_POST['PhoneNumber'] : ''; ?>" />
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="validationCustom03">Current Date and Time</label>
                                                <input type="datetime-local" class="form-control" name="DateTime" id="validationCustom03" value="<?php echo $currentDateTime; ?>" required readonly />
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label" for="validationCustom04">
                                                  <?php echo "Total Time : $totalHours Hours & $remainingMinutes minutes."; ?>
                                                </label>
                                            </div>

                                            <!-- Submit button to make a bill -->
                                            <button class="btn btn-danger" type="submit" name="make_bill">Make A Bill</button>
                                        </form>
                                    </div>
                                    <!-- end card-body-->
                                </div>
                                <!-- end card-->
                            </div>
                            <!-- end col-->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- container -->
                </div>
                <!-- content -->
            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
        </div>
        <!-- END wrapper -->
        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>
        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
    </body>
</html>

