<?php
session_start();
error_reporting(0);
include('includes/config.php');
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
    <link rel="stylesheet" href="css/gijgo.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/slicknav.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">

    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->

    <style>
        #myDIV {
            width: 100%;
            padding: 10px;
            background-color: #FF4A52;
            margin-top: 20px;
            border-radius: 10px;
            color: #fff;
        }

        #myDIV p {
            color: #fff;
        }

        #myDIV b {
            color: #000;
        }

        .accordionWrapper {
            padding: 10px;
            background: #fff;
            float: left;
            width: 100%;
            box-sizing: border-box;
            margin-top: 30px;
            margin-bottom: 30px;
            box-shadow: 0 1.5em 85px 0 rgba(0, 0, 0, 0.2);
        }

        .accordionItem {
            float: left;
            display: block;
            width: 100%;
            box-sizing: border-box;
            font-family: 'Open-sans', Arial, sans-serif;
        }

        .accordionItemHeading {
            cursor: pointer;
            margin: 0px 0px 10px 0px;
            padding: 10px;
            background: #FF4A52 !important;
            color: #fff;
            width: 100%;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            box-sizing: border-box;
        }

        .close .accordionItemContent {
            height: 0px;
            transition: height 1s ease-out;
            -webkit-transform: scaleY(0);
            -o-transform: scaleY(0);
            -ms-transform: scaleY(0);
            transform: scaleY(0);
            float: left;
            display: block;
        }

        .open .accordionItemContent {
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            width: 100%;
            margin: 0px 0px 10px 0px;
            display: block;
            -webkit-transform: scaleY(1);
            -o-transform: scaleY(1);
            -ms-transform: scaleY(1);
            transform: scaleY(1);
            -webkit-transform-origin: top;
            -o-transform-origin: top;
            -ms-transform-origin: top;
            transform-origin: top;

            -webkit-transition: -webkit-transform 0.4s ease-out;
            -o-transition: -o-transform 0.4s ease;
            -ms-transition: -ms-transform 0.4s ease;
            transition: transform 0.4s ease;
            box-sizing: border-box;
        }

        .open .accordionItemHeading {
            margin: 0px;
            -webkit-border-top-left-radius: 3px;
            -webkit-border-top-right-radius: 3px;
            -moz-border-radius-topleft: 3px;
            -moz-border-radius-topright: 3px;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
            -webkit-border-bottom-right-radius: 0px;
            -webkit-border-bottom-left-radius: 0px;
            -moz-border-radius-bottomright: 0px;
            -moz-border-radius-bottomleft: 0px;
            border-bottom-right-radius: 0px;
            border-bottom-left-radius: 0px;
            background-color: #FF4A52 !important;
            color: #fff;
        }
    </style>
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <!-- header-start -->
    <?php include('includes/header.php'); ?>

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
            <!-- header-end -->
            <div class="destination_banner_wrap overlay">
                <div class="destination_text text-center">
                    <h3><?php echo htmlentities($result->PackageName); ?></h3>
                </div>
            </div>

            <div class="destination_details_info">
                <div class="container">
                    <div class="row d-flex mb-5">
                        <div class="col-md-6 order-md-last heading-section pl-md-5 ftco-animate d-flex ">
                            <div class="w-100">
                                <h2 class="mb-4"><?php echo htmlentities($result->PackageName); ?></h2>
                                <p><b>Package Location :</b> <?php echo htmlentities($result->PackageLocation); ?></p>
                                <p><b>Package Schedule :</b> <?php echo htmlentities($result->PackageSchedule); ?></p>
                                <p><b>Features :</b> <?php echo htmlentities($result->PackageFetures); ?></p>
                                <a href="/package-payment.php?pkgid=<?php echo htmlentities($result->PackageId); ?>" class="btn btn-primary py-3 px-5">Book Now</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="demo" class="carousel slide" data-ride="carousel">

                                <!-- Indicators -->
                                <ul class="carousel-indicators">
                                    <li data-target="#demo" data-slide-to="0" class="active"></li>
                                    <li data-target="#demo" data-slide-to="1"></li>
                                    <li data-target="#demo" data-slide-to="2"></li>
                                </ul>

                                <!-- The slideshow -->
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="admin/pacakgeimages/a1.jpg" alt="Los Angeles">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="admin/pacakgeimages/a2.jpg" alt="Chicago">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="admin/pacakgeimages/a3.jpg" alt="New York">
                                    </div>
                                </div>

                                <!-- Left and right controls -->
                                <a class="carousel-control-prev" href="#demo" data-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </a>
                                <a class="carousel-control-next" href="#demo" data-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </a>

                            </div>
                        </div>
                    </div>

                    <div class="row d-flex">
                        <div class="col">
                            <section class="mb-2 align-items-center">
                                <!-- Flights -->
                                <a onclick="myFunction()" class="btn btn-primary btn-floating m-1" style="background-color: #39b7cd;padding: 20px; margin-right:20px;" role="button" aria-disabled="false"><i class="fa fa-plane fa-2x"></i></a>
                                <!-- Hotel -->
                                <a onclick="myFunction1()" class="btn btn-primary btn-floating m-1" style="background-color: #39b7cd;padding: 20px;margin-right:20px;" role="button" aria-disabled="false"><i class="fa fa-hotel fa-2x"></i></a>
                                <!-- SightSeeing -->
                                <a onclick="myFunction2()" class="btn btn-primary btn-floating m-1" style="background-color: #39b7cd; padding: 20px;margin-right:20px;" role="button" aria-disabled="false"><i class="fa fa-camera fa-2x"></i></a>
                                <!-- Meals -->
                                <a onclick="myFunction3()" class="btn btn-primary btn-floating m-1" style="background-color: #39b7cd;padding: 20px;margin-right:20px;" role="button" aria-disabled="true"><i class="fa fa-cutlery fa-2x"></i></a>
                            </section>
                            <div id="myDIV">
                                <p><b>Package Flights :</b><br> <?php echo htmlentities($result->PackageFlights); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row d-flex">
                        <div class="accordionWrapper">
                            <div class="accordionItem open">
                                <h2 class="accordionItemHeading">What you Tour Price includes?</h2>
                                <div class="accordionItemContent">
                                    <p><?php echo $result->PackageTourIncludes; ?></p>
                                </div>
                            </div>

                            <div class="accordionItem close">
                                <h2 class="accordionItemHeading">What you Tour Price does not include?</h2>
                                <div class="accordionItemContent">
                                    <p><?php echo $result->PackageTourNotIncludes; ?></p>
                                </div>
                            </div>

                            <div class="accordionItem close">
                                <h2 class="accordionItemHeading">Visa, Passport and Insurance</h2>
                                <div class="accordionItemContent">
                                    <p><?php echo $result->PackageVisa; ?></p>
                                </div>
                            </div>

                            <div class="accordionItem close">
                                <h2 class="accordionItemHeading">Itinerary</h2>
                                <div class="accordionItemContent">
                                    <p><?php echo $result->PackageItinerary; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex">
                        <div class="col-md-6 order-md-last heading-section pl-md-5 ftco-animate d-flex fadeInUp ftco-animated">
                            <div class="w-100">
                                <h2 class="mb-4">Payment Policy</h2>
                                <p><?php echo $result->PackagePaymentPolicy; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6 heading-section ftco-animate d-flex fadeInUp ftco-animated">
                            <div class="w-100">
                                <h2 class="mb-4">Cancellation Policy</h2>
                                <p><?php echo $result->PackageCancellationPolicy; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php }
    } ?>

    <div class="popular_places_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center mb_70">
                        <h3>More Places</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="single_place">
                        <div class="thumb">
                            <img src="img/place/1.png" alt="">
                            <a href="#" class="prise">$500</a>
                        </div>
                        <div class="place_info">
                            <a href="#">
                                <h3>California</h3>
                            </a>
                            <p>United State of America</p>
                            <div class="rating_days d-flex justify-content-between">
                                <span class="d-flex justify-content-center align-items-center">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <a href="#">(20 Review)</a>
                                </span>
                                <div class="days">
                                    <i class="fa fa-clock-o"></i>
                                    <a href="#">5 Days</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_place">
                        <div class="thumb">
                            <img src="img/place/2.png" alt="">
                            <a href="#" class="prise">$500</a>
                        </div>
                        <div class="place_info">
                            <a href="#">
                                <h3>Korola Megna</h3>
                            </a>
                            <p>United State of America</p>
                            <div class="rating_days d-flex justify-content-between">
                                <span class="d-flex justify-content-center align-items-center">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <a href="#">(20 Review)</a>
                                </span>
                                <div class="days">
                                    <i class="fa fa-clock-o"></i>
                                    <a href="#">5 Days</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_place">
                        <div class="thumb">
                            <img src="img/place/3.png" alt="">
                            <a href="#" class="prise">$500</a>
                        </div>
                        <div class="place_info">
                            <a href="#">
                                <h3>London</h3>
                            </a>
                            <p>United State of America</p>
                            <div class="rating_days d-flex justify-content-between">
                                <span class="d-flex justify-content-center align-items-center">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <a href="#">(20 Review)</a>
                                </span>
                                <div class="days">
                                    <i class="fa fa-clock-o"></i>
                                    <a href="#">5 Days</a>
                                </div>
                            </div>
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
    <!--     
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-de7e2ef6bfefd24b79a3f68b414b87b8db5b08439cac3f1012092b2290c719cd.js"></script>

    <script src=" https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"> </script> -->
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
    <script src="js/nice-select.min.js"></script>
    <script src="js/jquery.slicknav.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/gijgo.min.js"></script>
    <script src="js/slick.min.js"></script>



    <!--contact js-->
    <script src="js/contact.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/mail-script.js"></script>


    <script src="js/main.js"></script>
    <script>
        $('#datepicker').datepicker({
            iconsLibrary: 'fontawesome',
            icons: {
                rightIcon: '<span class="fa fa-caret-down"></span>'
            }
        });
    </script>
    <script>
        function myFunction() {
            var x = document.getElementById("myDIV");
            x.style.display = "block";
            document.getElementById("myDIV").innerHTML = "<p><b>Package Flights :</b><br> <?php echo htmlentities($result->PackageFlights); ?></p>";
        }

        function myFunction1() {
            var x = document.getElementById("myDIV");
            x.style.display = "block";
            document.getElementById("myDIV").innerHTML = "<p><b>Package Hotels :</b><br> <?php echo htmlentities($result->PackageHotels); ?></p>";
        }

        function myFunction2() {
            var x = document.getElementById("myDIV");
            x.style.display = "block";
            document.getElementById("myDIV").innerHTML = "<p><b>Package Sightseeing :</b><br> <?php echo htmlentities($result->PackageSightseeing); ?></p>";
        }

        function myFunction3() {
            var x = document.getElementById("myDIV");
            x.style.display = "block";
            document.getElementById("myDIV").innerHTML = "<p><b>Package Meals :</b><br> <?php echo htmlentities($result->PackageMeals); ?></p>";
        }

        var accItem = document.getElementsByClassName('accordionItem');
        var accHD = document.getElementsByClassName('accordionItemHeading');
        for (i = 0; i < accHD.length; i++) {
            accHD[i].addEventListener('click', toggleItem, false);
        }

        function toggleItem() {
            var itemClass = this.parentNode.className;
            for (i = 0; i < accItem.length; i++) {
                accItem[i].className = 'accordionItem close';
            }
            if (itemClass == 'accordionItem close') {
                this.parentNode.className = 'accordionItem open';
            }
        }
    </script>
</body>

</html>