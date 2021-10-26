<?php
session_start();
error_reporting(0);
function success()
{
    echo '<script>window.location = window.location.href;</script>';
}
include('includes/config.php');
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('location: login.php');
    exit;
} else {
    if (isset($_POST['submit5'])) {
        $password = md5($_POST['password']);
        $newpassword = md5($_POST['newpassword']);
        $email = $_SESSION['login'];
        $sql = "SELECT Password FROM tblusers WHERE EmailId=:email and Password=:password";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            $con = "update tblusers set Password=:newpassword where EmailId=:email";
            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
            $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $chngpwd1->execute();
            $msg = "Your Password successfully changed";
            success();
        } else {
            $error = "Your current password is wrong";
        }
    }
?>
    <!doctype html>
    <html class="no-js" lang="zxx">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>interior</title>
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
        <link rel="stylesheet" href="css/slicknav.css">
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

        <!-- bradcam_area  -->
        <div class="bradcam_area bradcam_bg_4">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="bradcam_text text-center">
                            <h3>Change password</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ bradcam_area  -->

        <!-- ================ contact section start ================= -->
        <section class="contact-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="contact-title">Change Password</h2>
                    </div>
                    <div class="col">
                        <form class="form-contact contact_form" method='post'>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input class="form-control" name="password" id="password" type="password" placeholder="Password" required="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input class="form-control" name="newpassword" id="newpassword" type="password" placeholder="New Password" required="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input class="form-control" name="confirmpassword" id="confirmpassword" type="password" placeholder="Confirm New Password" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <?php if ($msg) {
                                    echo "<div class='alert alert-success'>" . $msg . "</div>";
                                } elseif ($error) {
                                    echo "<div class='alert alert-danger'>" . $error . "</div>";
                                }
                                ?>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" name="submit5" id="change-password" class="button button-contactForm boxed-btn">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- ================ contact section end ================= -->

        <!-- footer start -->
        <?php include('includes/footer.php'); ?>
        <!--/ footer end  -->

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

        <!--contact js-->
        <script src="js/contact.js"></script>
        <script src="js/jquery.ajaxchimp.min.js"></script>
        <script src="js/jquery.form.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/mail-script.js"></script>

        <script src="js/main.js"></script>
    </body>

    </html>
<?php } ?>