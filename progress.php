<?php
require('includes/functions.php');
require('includes/validationFunctions.php');
require('includes/session.php');
require('includes/dbConnect.php');
confirm_logged_in();
$check="SELECT * FROM `projects`";
$result = mysqli_query($connection, $check) or die(mysqli_error($connection));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Project Management system</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all">
    <script type="text/javascript" src="js/jquery-1.4.2.min.js" ></script>
    <script type="text/javascript" src="js/cufon-yui.js"></script>
    <script type="text/javascript" src="js/cufon-replace.js"></script>
    <script type="text/javascript" src="js/Myriad_Pro_300.font.js"></script>
    <script type="text/javascript" src="js/Myriad_Pro_400.font.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <!--[if lt IE 7]>
    <link rel="stylesheet" href="css/ie6.css" type="text/css" media="screen">
    <script type="text/javascript" src="js/ie_png.js"></script>
    <script type="text/javascript">ie_png.fix('.png, footer, header nav ul li a, .nav-bg, .list li img');</script>
    <![endif]-->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="js/html5.js"></script><![endif]-->
</head>
<body id="page1">
<!-- START PAGE SOURCE -->
<div class="wrap">
    <?php require_once('includes/header.php') ?>
    <div class="container" width="100">
        <?php require_once('includes/nav.php') ?>
        <section id="content">
            <div class="inside">
                <h2>Track Progress</h2>
            </div>
            <div class="inside">

                <form action="report.php" method="post">
                    <label>Select a Project</label>
                    <br>
                    <select name="projects">
                        <?php
                        if ($result->num_rows> 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <option>
                                    <?php echo $row['name'];?>
                                </option>

                            <?php
                            }
                        }
                        else {
                            ?>
                            <option>
                                <?php echo "No Projects Available"?>

                            </option>
                        <?php
                        }?>
                    </select>
                    <input type="submit" value="Track Progress">
                </form>



            </div>
        </section>

    </div>

</div>
<footer>
    <div class="footerlink">
        <p class="lf">Copyright &copy; 2010 <a href="#">SiteName</a> - All Rights Reserved</p>
        <div style="clear:both;"></div>
    </div>
</footer>
<script type="text/javascript"> Cufon.now(); </script>
<!-- END PAGE SOURCE -->
</body>
</html>
<?php require_once("includes/dbClose.php"); ?>