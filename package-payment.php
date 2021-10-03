<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('location: login.php');
    exit;
}

if (isset($_POST['submit11']) && $_POST["paymentType"] == "partialAmountOut") {
    $pid = intval($_GET['pkgid']);
    $useremail = $_SESSION['login'];
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $numPassengers = $_POST['numPassengers'];
    $passengerDetails = array();
    for ($i = 1; $i <= $numPassengers; $i++) {
        $passenger = array();
        array_push($passenger, $_POST['passengerName' . $i], $_POST['passengerAge' . $i], $_POST['passengerGender' . $i]);
        array_push($passengerDetails, $passenger);
    }
    $passengerdetails = json_encode($passengerDetails);
    +$packagePrice = $_POST['packagePrice'];
    $FullAmount = $numPassengers * $packagePrice;
    $PartialAmount = $packagePrice * 0.1 * $numPassengers;
    $balance = $FullAmount - $PartialAmount;
    $sql = "INSERT INTO  tblpayments(PackageId,UserEmail,NumPassengers,FromDate,ToDate,PassengerDetails, FullAmount, PartialAmount, Balance) VALUES(:pid,:useremail,:numpassengers,:fromdate,:todate,:passengerdetails, :fullamount, :partialamount, :balance)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':pid', $pid, PDO::PARAM_STR);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->bindParam(':numpassengers', $numPassengers, PDO::PARAM_STR);
    $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
    $query->bindParam(':todate', $todate, PDO::PARAM_STR);
    $query->bindParam(':passengerdetails', $passengerdetails, PDO::PARAM_STR);
    $query->bindParam(':fullamount', $FullAmount, PDO::PARAM_STR);
    $query->bindParam(':partialamount', $PartialAmount, PDO::PARAM_STR);
    $query->bindParam(':balance', $balance, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();

    if ($lastInsertId) { /* Redirect browser */
        $msg = "Paid Successfully";
    } else {
        $error = "Something went wrong. Please try again";
    }
} elseif (isset($_POST['submit11']) && $_POST["paymentType"] == "fullAmountOut") {
    $pid = intval($_GET['pkgid']);
    $useremail = $_SESSION['login'];
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $numPassengers = $_POST['numPassengers'];
    $passengerDetails = array();
    for ($i = 1; $i <= $numPassengers; $i++) {
        $passenger = array();
        array_push($passenger, $_POST['passengerName' . $i], $_POST['passengerAge' . $i], $_POST['passengerGender' . $i]);
        array_push($passengerDetails, $passenger);
    }
    $passengerdetails = json_encode($passengerDetails);
    $packagePrice = $_POST['packagePrice'];
    $FullAmount = $numPassengers * $packagePrice;
    $PartialAmount = 0;
    $balance = $FullAmount;
    $sql = "INSERT INTO  tblpayments(PackageId,UserEmail,NumPassengers,FromDate,ToDate,PassengerDetails, FullAmount, PartialAmount, Balance) VALUES(:pid,:useremail,:numpassengers,:fromdate,:todate,:passengerdetails, :fullamount, :partialamount, :balance)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':pid', $pid, PDO::PARAM_STR);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->bindParam(':numpassengers', $numPassengers, PDO::PARAM_STR);
    $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
    $query->bindParam(':todate', $todate, PDO::PARAM_STR);
    $query->bindParam(':passengerdetails', $passengerDetails, PDO::PARAM_STR);
    $query->bindParam(':fullamount', $FullAmount, PDO::PARAM_STR);
    $query->bindParam(':partialamount', $PartialAmount, PDO::PARAM_STR);
    $query->bindParam(':balance', $balance, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();

    if ($lastInsertId) {
        $msg = "Paid Successfully";
    } else {
        $error = "Something went wrong. Please try again";
    }
}
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>BookATrip</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/gijgo.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/slicknav.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <!-- header-start -->
    <?php include('includes/header.php'); ?>
    <!-- header-end -->

    <?php
    $pid = intval($_GET['pkgid']);
    $sql = "SELECT * from tbltourpackages where PackageId=:pid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':pid', $pid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
    if ($query->rowCount() > 0) {
        foreach ($results as $result) { ?>
            <!-- bradcam_area  -->
            <div class="bradcam_area bradcam_bg_2">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="bradcam_text text-center">
                                <h3><?php echo htmlentities($result->PackageName); ?></h3>
                                <p>Tour Payment</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ bradcam_area  -->

            <div class="destination_details_info">
                <div class="container">
                    <div class="row d-flex">
                        <div class="col-md-6 order-md-last heading-section pl-md-5 ftco-animate d-flex ">
                            <div class="w-100">
                                <h2 class="mb-4"><?php echo htmlentities($result->PackageName); ?></h2>
                                <p><b>Package Location :</b> <?php echo htmlentities($result->PackageLocation); ?></p>
                                <p><b>Package Schedule :</b> <?php echo htmlentities($result->PackageSchedule); ?></p>
                                <p><b>Features :</b> <?php echo htmlentities($result->PackageFetures); ?></p>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex">
                            <form method='post' class="bg-light p-5 contact-form">
                                <div class="form-group">
                                    <input type="number" name="numPassengers" value="<?php echo (isset($people)) ? $people : ''; ?>" id="numPeople" onchange="addNew()" class="form-control" placeholder="Number of passengers" required="">
                                </div>
                                <div class="form-group">
                                    Passenger Details
                                </div>
                                <div id="passengerName">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="address" id="address" class="form-control" placeholder="Address" required="">
                                </div>
                                <div class="single-element-widget mt-30">
                                    <h5 class="mb-30">Select Payment Type</h5>
                                    <div class="default-select">
                                        <select id="paymentType" name="paymentType" required="">
                                            <option disabled selected> select an option </option>
                                            <option value="partialAmountOut">Partial Payment</option>
                                            <option value="fullAmountOut">Full Payment</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row d-flex">
                                    <div class="col-md-6">
                                        <label for="startDate">From</label>
                                        <div class="form-field">
                                            <input type="text" class="form-control" id="startDate" name="fromdate" placeholder="From">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="toDate">To</label>
                                        <div id="toDate"></div>
                                        <input type="text" class="form-control" id="toDateValue" name="todate" value="" readonly>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group mt-15">
                                    <label for="totalAmount" id="totalPaymentPrice">Total Amount</label>
                                </div>
                                <div class="form-group">
                                    <label for="partialAmount" id="partialPaymentPrice">Partial Amount</label>
                                </div>

                                <input type="hidden" id="packagePrice" name="packagePrice" value="<?php echo htmlentities($result->PackagePrice) ?>">
                                <button type="submit" name="submit11" id="confirmPaymentButton" class="btn btn-primary py-3 px-4">Confirm Payment</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- newletter_area_start  -->
            <div class="newletter_area overlay">
                <div class="container">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-lg-10">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <div class="newsletter_text">
                                        <h4>Subscribe Our Newsletter</h4>
                                        <p>Subscribe newsletter to get offers and about
                                            new places to discover.</p>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="mail_form">
                                        <div class="row no-gutters">
                                            <div class="col-lg-9 col-md-8">
                                                <div class="newsletter_field">
                                                    <input type="email" placeholder="Your mail">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4">
                                                <div class="newsletter_btn">
                                                    <button class="boxed-btn4 " type="submit">Subscribe</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- newletter_area_end  -->
            <div class="recent_trip_area">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="section_title text-center mb_70">
                                <h3>Recent Trips</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="single_trip">
                                <div class="thumb">
                                    <img src="img/trip/1.png" alt="">
                                </div>
                                <div class="info">
                                    <div class="date">
                                        <span>Oct 12, 2019</span>
                                    </div>
                                    <a href="#">
                                        <h3>Journeys Are Best Measured In
                                            New Friends</h3>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="single_trip">
                                <div class="thumb">
                                    <img src="img/trip/2.png" alt="">
                                </div>
                                <div class="info">
                                    <div class="date">
                                        <span>Oct 12, 2019</span>
                                    </div>
                                    <a href="#">
                                        <h3>Journeys Are Best Measured In
                                            New Friends</h3>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="single_trip">
                                <div class="thumb">
                                    <img src="img/trip/3.png" alt="">
                                </div>
                                <div class="info">
                                    <div class="date">
                                        <span>Oct 12, 2019</span>
                                    </div>
                                    <a href="#">
                                        <h3>Journeys Are Best Measured In
                                            New Friends</h3>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <?php include('includes/footer.php'); ?>


            <!-- Modal -->
            <div class="modal fade custom_search_pop" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="serch_form">
                            <input type="text" placeholder="Search">
                            <button type="submit">search</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- link that opens popup -->


            <!-- JS here -->
            <script src="js/vendor/modernizr-3.5.0.min.js"></script>
            <script src="js/vendor/jquery-1.12.4.min.js"></script>
            <script src="js/popper.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/owl.carousel.min.js"></script>
            <script src="js/isotope.pkgd.min.js"></script>
            <script src="js/ajax-form.js"></script>
            <script src="js/waypoints.min.js"></script>
            <script src="js/jquery.counterup.min.js"></script>
            <script src="js/imagesloaded.pkgd.min.js"></script>
            <script src="js/scrollIt.js"></script>
            <script src="js/jquery.scrollUp.min.js"></script>
            <script src="js/wow.min.js"></script>
            <script src="js/jquery-ui.min.js"> </script>
            <script src="js/nice-select.min.js"></script>
            <script src="js/jquery.slicknav.min.js"></script>
            <script src="js/jquery.magnific-popup.min.js"></script>
            <script src="js/plugins.js"></script>
            <script src="js/range.js"></script>
            <!-- <script src="js/gijgo.min.js"></script> -->
            <script src="js/slick.min.js"></script>
            <script src="js/bootstrap-datepicker.js"></script>

            <!--contact js-->
            <script src="js/contact.js"></script>
            <script src="js/jquery.ajaxchimp.min.js"></script>
            <script src="js/jquery.form.js"></script>
            <script src="js/jquery.validate.min.js"></script>
            <script src="js/mail-script.js"></script>
            <script src="js/main.js"></script>

            <script>
                function addNew() {
                    var txtNewInputBox = "";
                    var numPeople = document.getElementById("numPeople").value
                    for (var i = 1; i <= numPeople; i++) {
                        txtNewInputBox += `
                <p>Passenger ${i}</p>
                <div class="form-group">
                <input type='text' class='form-control' name='passengerName${i}' placeholder='Name'  required=''>
                </div>
                <div class="form-group">
                <input type='text' class='form-control' name='passengerGender${i}' placeholder='Gender' required=''>
                </div>
                <div class="form-group">
                <input type='number' class='form-control' style='margin-top:10px' name='passengerAge${i}' placeholder='Age' required=''>
                </div>
                `;
                    }
                    var container = document.getElementById("passengerName");
                    container.innerHTML = txtNewInputBox;

                    var totalPrice = <?php echo htmlentities($result->PackagePrice); ?> * numPeople;
                    console.log(totalPrice);
                    document.getElementById("partialPaymentPrice").innerHTML = "Pay partial amount: <b>₹" + totalPrice * 0.5;
                    document.getElementById("totalPaymentPrice").innerHTML = "Full Amount: <b>₹" + totalPrice;
                }
            </script>
            <script>
                <?php $days = htmlentities($result->PackageDays) - 1; ?>

                $(function() {
                    var sd = new Date(),
                        ed = new Date();

                    $('#startDate').datepicker({
                        'format': 'yyyy/m/d',
                        'autoclose': true,
                        'startDate': sd
                    });

                    $('#confirmPaymentButton').click(function() {
                        if (document.getElementById("paymentType").value == "partialAmountOut") {
                            alert(`Dear Traveller, this is to kindly notify that this is a Partial Payment (10%) to only hold your bookings in the said Price. You need to Pay the remaining amount (90%) for Confirm Booking within 90 days from the day of booking. This Payment is 100% Non-Refundable if booking not confirmed in the said time period.\n\nClick OK if you fully understand the said Disclaimer and agree with the same.\n\nThanks `)
                        }
                    })

                    $('#paymentType').change(function() {
                        console.log("Working");
                        console.log(document.getElementById("paymentType").value);
                        if (document.getElementById("paymentType").value == "partialAmountOut") {
                            var ppd = new Date();
                            ppd.setDate(ppd.getDate() + 90);
                            $('#startDate').datepicker('setStartDate', ppd);
                        }
                        if (document.getElementById("paymentType").value == "fullAmountOut") {
                            var fpd = new Date();
                            $('#startDate').datepicker('setStartDate', fpd);
                        }
                    })

                    $('#startDate').change(function() {
                        let date = document.getElementById("startDate");

                        let start = new Date(date.value);
                        let maxDate = new Date(date.value);
                        maxDate.setDate(maxDate.getDate() + <?php echo $days ?>);
                        var dateString = maxDate.getFullYear() + "/" + (maxDate.getMonth() + 1) + "/" + maxDate.getDate();
                        document.getElementById("toDateValue").value = dateString;
                        document.getElementById("toDateValue").innerHTML = dateString
                    });
                });
            </script>

    <?php }
    }
    ?>

</body>

</html>