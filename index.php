<?php
    include 'functions.php';
    $credentials =  array(
        "principal" => "1807605",
        "credentials" => "kidan123@",
        "system" => "lucy"     
    );
    $country_codes = array(
        'ET' => '251'
    ); 
    $names = array("trees_WebHookEvent.log", "children_WebHookEvent.log","students_WebHookEvent.log");
    $treesTarget = 25000;
    $childrenTarget = 60000;
    $studentsTarget = 97500;
    $totalTarget = 182000;
    $treesTotal = getTotal($names[0]);
    $childrenTotal = getTotal($names[1]);
    $studentsTotal = getTotal($names[2]);
    $treesGoal = ($treesTotal < $treesTarget) ? $treesTarget : ($treesTarget + 10000);
    $childrenGoal = ($childrenTotal < $childrenTarget) ? $childrenTarget : ($childrenTarget + 10000);
    $studentsGoal = ($studentsTotal < $studentsTarget) ? $studentsTarget : ($studentsTarget + 10000);

    $total = $treesTotal + $childrenTotal + $studentsTotal;
    $goal = ($total < $totalTarget) ? $totalTarget : ($totalTarget + 10000);
    $percent = round(($total/$goal), 3);
    $treePercent = round(($treesTotal/$treesGoal), 3);
    $childrenPercent = round(($childrenTotal/$childrenGoal), 3);
    $studentsPercent = round(($studentsTotal/$studentsGoal), 3);
    // $percent = round(ceil($total/$goal),3);
    // echo $treesTotal." ".$childrenTotal." ".$studentsTotal." ".$total."<br>";
    if (isset($_POST['donate'])) {

        if(!isset($_SESSION['token']) && empty($_SESSION['token'])) {
            $token = generateToken($credentials);
        }
        $amount = $_POST['amount'];
        if(!checkBalance($_SESSION['token'],$amount)){
            // echo "\n Insufficent balance";
            echo "<script>alert('Insufficent balance!!!');</script>\n";
        }
        else{
            $from = cleanupMobilePhone($_POST['phone_num'],"251",$country_codes);
            $description = $_POST['description'];
            $full_name = $_POST['full_name'];
            $donation_type = $_POST['donation_type'];
            $retVal = ($donation_type=="0") ? "trees" : (($donation_type=="1")?"children":"blood");
            $today = date("Y-m-d");
            $file_name = dirname(__FILE__) . "/" .$retVal."_WebHookEvent.log";

            $currency = "ETB";
            $invoice_data =  array(
                "amount" => (int)$amount,
                "description" => $description,
                "from" => $from,
                "currency" => $currency,
                "notifyfrom" => true,
                "notifyto" => true
            );
            $create_invoice = createInvoice($invoice_data,$_SESSION['token'],$full_name,$donation_type,$file_name);
            if ($create_invoice) {
                echo "<script>alert('Invoice generated successfully!!!');</script>\n";
            } else {
                echo "<script>alert('Invoice not generated!!');</script>\n";
            }
        }

    } else {
        # code...
    }
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="" href="img/GoodHeartsLogo.svg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Charity page</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">

    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/owl.carousel.min.css">
    <link rel="stylesheet" href="./css/owl.theme.default.min.css">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./responsive.css">
    <style type="text/css">
        html
        {
            scroll-behavior: smooth !important;
        }
        .header-bottom{
            position: fixed;
            top: 0;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <header class="header">
            <section class="header-top">
                <div class="container">
                    <div class="row">
                   </div>
                </div>
            </section>
            <section class="header-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <a href="#">
                                <div class="main-logo">
                                    <img src="img/GoodHeartsLogo.svg" alt="" width="60" height="60">
                                    <h2>Good Hearts</h2>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <div class="menu">
                                <ul class="nav navbar-nav">
                                    <li class="active"><a href="#home">HOME</a></li>
                                    <li><a href="#donated_amount">RAISED FUND</a></li>
                                    <li><a href="#donations">DONATIONS </a></li>
                                    <li><a href="#donate">DONATE</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </header>
        <section class="carosal-area" id="home">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="client owl-carousel owl-theme">
                            <div class="item">
                                <div class="text">
                                    <h3>LETS CONTRIBUTE FOR OUR ENVIRONMENT</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim <br> ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo </p>
                                    <h5 class="white-button"><a href="#donate">DONATE NOW</a></h5>
                                    <h5><a href="javascript:void(0);">CONTACT US</a></h5>
                                </div>
                            </div>
                            <div class="item">
                                <div class="text">
                                    <h3>LETS CONTRIBUTE FOR OUR CHILDREN</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim <br> ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo </p>
                                    <h5 class="white-button"><a href="#donate">DONATE NOW</a></h5>
                                    <h5><a href="javascript:void(0);">CONTACT US</a></h5>
                                </div>
                            </div>
                            <div class="item">
                                <div class="text">
                                    <h3>LETS CONTRIBUTE FOR OUR STUDENTS</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim <br> ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo </p>
                                    <h5 class="white-button"><a href="#donate">DONATE NOW</a></h5>
                                    <h5><a href="javascript:void(0);">CONTACT US</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> 
        <section class="donate_section" id="donated_amount">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 for-padding">
                        <h3>Total Raised Money</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                        <div class="progress-text">
                            <p class="progress-top"><?php echo $percent;?>%</p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:50%"></div>
                            </div>
                            <p class="progress-left">Raised: <?php echo $total;?></p>
                            <p class="progress-right">Goal: <?php echo $goal;?></p>
                        </div>
                        <h2>
                            <a href="#donate">DONATE NOW</a>
                        </h2>
                    </div>
                </div>
            </div>
        </section>
        <section class="our_cuauses" id="donations">
            <h2>List of Donations</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor <br> incididunt ut labore et dolore magna aliqua. </p>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="our_cuauses_single owl-carousel owl-theme">
                            <div class="item">
                                <img src="img/environment.jpg" alt="">
                                <div class="for_padding">
                                    <h2>FUTURES FOR ENVIRONMENT</h2>
                                    <p>Let's plant 1000 trees</p>
                                    <p>Cost of a single tree ETB 25)</p>  
                                    <p>Target: <?php echo $treesGoal;?> Br</p><br>
                                    <div class="progress-text">
                                        <p class="progress-top"><?php echo $treePercent;?>%</p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%"></div>
                                        </div>
                                        <p class="progress-left">Raised: <span>ETB <?php echo $treesTotal;?></span></p>
                                        <p class="progress-right">Goal: <span>ETB <?php echo $treesGoal;?></span></p>
                                    </div>
                                    <h2 class="borderes"><a href="#donate">DONATE NOW</a></h2>
                                </div>
                            </div>
                            <div class="item">
                                <img src="img/children.jpg" alt="">
                                <div class="for_padding">
                                    <h2>FUTURES FOR CHILDREN</h2>
                                    <p>Let us feed 500 street kids</p>
                                    <p>Cost of feeding a single kid: 120.00 Br/kid</p>
                                    <p>Target: <?php echo $childrenGoal;?>Br</p><br>
                                    <div class="progress-text">
                                        <p class="progress-top"><?php echo $childrenPercent;?>%</p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%"></div>
                                        </div>
                                        <p class="progress-left">Raised: <span>ETB <?php echo $childrenTotal;?></span></p>
                                        <p class="progress-right">Goal: <span>ETB <?php echo $childrenGoal;?></span></p>
                                    </div>
                                    <h2 class="borderes"><a href="#donate">DONATE NOW</a></h2>
                                </div>
                            </div>
                            <div class="item">
                                <img src="img/students.jpg" alt="">
                                <div class="for_padding">
                                    <h2>FUTURES FOR STUDENTS</h2>
                                    <p>Let's cover cost of stationary for 1500 students(grade 1 to 5)</p>
                                    <p>Cost of stationary per student: 65.00 Br</p>
                                    <p>Target: <?php echo $studentsGoal;?> Br</p>
                                    <div class="progress-text">
                                        <p class="progress-top"><?php echo $studentsPercent;?>%</p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%"></div>
                                        </div>
                                        <p class="progress-left">Raised: <span>ETB <?php echo $studentsTotal;?></span></p>
                                        <p class="progress-right">Goal: <span>ETB <?php echo $studentsGoal;?></span></p>
                                    </div>
                                    <h2 class="borderes"><a href="#donate">DONATE NOW</a></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="donors" id="donate">
            <div class="container">
                <div class="row">
                    <div class="col-md-12" style="background-color: inherit;">
                        <div class="donors_input" style="background-color: inherit;padding-right: 15px;">
                            <h2>DONATE NOW</h2>
                            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                                <p class="amount">
                                    <label for="usd">AMOUNT : </label>
                                    <input type="radio" name="amount" value ="10" checked>10ETB
                                    <input type="radio" name="amount" value ="50">50ETB
                                    <input type="radio" name="amount" value ="100">100ETB
                                    <input type="radio" name="amount" value ="200">200ETB
                                </p>
                                <p class="amount">
                                    <input type="radio" name="amount" value ="500">500ETB
                                    <input type="radio" name="amount" value ="1000">1,000ETB
                                    <input type="radio" name="amount" value ="5000">5,000ETB
                                    <input type="radio" name="amount" value ="10000">10,000ETB
                                </p>    
                                <h5>
                                    <input type="text" name="full_name" placeholder="Name">
                                    <input type="tel" name="phone_num" minlength="9" maxlength="13" placeholder="Phone Number" required>
                                </h5>
                                <h5>
                                    <input type="text" name="description" minlength="9" maxlength="130" placeholder="Description" required  style="width: 460px !important;margin-left: 10px; margin-top: -5px;">
                                </h5>
                                <h4>
                                    <select name="donation_type" required style="width: 460px !important;margin-left: 10px;">
                                        <option value="">Choose One</option>
                                        <option value="0">To plant 1000 trees</option>
                                        <option value="1">To Feed 500 street kids</option>
                                        <option value="2">To cover stationary cost for 1500 students</option>
                                    </select>
                                </h4>
                                <input type="submit" value="DONATION NOW" name="donate">
                            </form>
                        </div>
                        <div class="donors_image">
                            <h2>FEATURED DONORS</h2>
                            <div class="donors_featured owl-carousel owl-theme">
                                <div class="item">
                                    <img src="img/donors_featured_one.jpg" alt="">
                                    <h3>Kenneth J. Garnica</h3>
                                    <p>Donated Amount : <span>220 USD</span> </p>
                                </div>
                                <div class="item">
                                    <img src="img/donors_featured_one.jpg" alt="">
                                    <h3>Kenneth J. Garnica</h3>
                                    <p>Donated Amount : <span>220 USD</span> </p>
                                </div>
                                <div class="item">
                                    <img src="img/donors_featured_one.jpg" alt="">
                                    <h3>Kenneth J. Garnica</h3>
                                    <p>Donated Amount : <span>220 USD</span> </p>
                                </div>
                                <div class="item">
                                    <img src="img/donors_featured_one.jpg" alt="">
                                    <h3>Kenneth J. Garnica</h3>
                                    <p>Donated Amount : <span>220 USD</span> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="clear"></div>
        <section class="volunteer_area">
            <h2>Our Volunteer</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor <br> incididunt ut labore et dolore magna aliqua. </p>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="volunteer_single owl-carousel owl-theme">
                            <div class="item">
                                <img src="img/volanteer_1.jpg" alt="">
                                <div class="text">
                                    <h3>Laura Jammy</h3>
                                    <h6>Designer</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisi</p>
                                    <h5><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a><a href="#"><i class="fa fa-behance" aria-hidden="true"></i></a></h5>
                                </div>
                            </div>
                            <div class="item">
                                <img src="img/volanteer_2.jpg" alt="">
                                <div class="text">
                                    <h3>Albert R. Ardoin</h3>
                                    <h6>Actor</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisi</p>
                                    <h5><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a><a href="#"><i class="fa fa-behance" aria-hidden="true"></i></a></h5>
                                </div>
                            </div>
                            <div class="item">
                                <img src="img/volanteer_3.jpg" alt="">
                                <div class="text">
                                    <h3>Cynthia Anni</h3>
                                    <h6>Singer</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisi</p>
                                    <h5><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a><a href="#"><i class="fa fa-behance" aria-hidden="true"></i></a></h5>
                                </div>
                            </div>
                            <div class="item">
                                <img src="img/volanteer_1.jpg" alt="">
                                <div class="text">
                                    <h3>Laura Jammy</h3>
                                    <h6>Designer</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisi</p>
                                    <h5><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a><a href="#"><i class="fa fa-behance" aria-hidden="true"></i></a></h5>
                                </div>
                            </div>
                            <div class="item">
                                <img src="img/volanteer_2.jpg" alt="">
                                <div class="text">
                                    <h3>Albert R. Ardoin</h3>
                                    <h6>Actor</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisi</p>
                                    <h5><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a><a href="#"><i class="fa fa-behance" aria-hidden="true"></i></a></h5>
                                </div>
                            </div>
                            <div class="item">
                                <img src="img/volanteer_3.jpg" alt="">
                                <div class="text">
                                    <h3>Cynthia Anni</h3>
                                    <h6>Singer</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisi</p>
                                    <h5><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a><a href="#"><i class="fa fa-behance" aria-hidden="true"></i></a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="footer-charity-text">
                            <h2>HELP CHARITY</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris </p>
                            <hr>
                            <p><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a><a href="#"><i class="fa fa-behance" aria-hidden="true"></i></a><a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4 col-sm-5">
                                <div class="footer-text one">
                                    <h3>RECENT POST</h3>
                                    <ul>
                                        <li><a href="#"><i class="material-icons">keyboard_arrow_right</i> Consectetur Adipisicing Elit</a></li>
                                        <li><a href="#"><i class="material-icons">keyboard_arrow_right</i> Consectetur Adipisicing </a></li>
                                        <li><a href="#"><i class="material-icons">keyboard_arrow_right</i> Consectetur Adipisicing Elit</a></li>
                                        <li><a href="#"><i class="material-icons">keyboard_arrow_right</i> Consectetur Adipisicing</a></li>
                                        <li><a href="#"><i class="material-icons">keyboard_arrow_right</i> Consectetur Adipisicing Elit</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-3">
                                <div class="footer-text two">
                                    <h3>USEFUL LINKS</h3>
                                    <ul>
                                        <li><a href="#">Home</a></li>
                                        <li><a href="#">Causes</a></li>
                                        <li><a href="#">Event</a></li>
                                        <li><a href="#">Blog</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="footer-text one">
                                    <h3>CONTACT US</h3>
                                    <ul>
                                        <li><a href="#"><i class="material-icons">location_on</i>Addis Ababa, Ethiopia</a></li>
                                        <li><a href="#"><i class="material-icons">email</i>hailemariam37@gmail.com</a></li>
                                        <li><a href="#"><i class="material-icons">call</i>+251921601266</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer_bottom">
                <p>Copyright @ 2020 <a href="#">Hello cash payment integration</a> | All Rights Reserved </p>
            </div>
        </footer>
    </div>
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/animationCounter.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/active.js"></script>
</body>

</html>
