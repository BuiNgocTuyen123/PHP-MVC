<?php
$loi = "";
if (isset($_POST['submit_email']) == true) {
    $email = $_POST['email'];
    $conn = new PDO("mysql:host=localhost;dbname=web_shop;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM user WHERE user_email=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $count = $stmt->rowcount();
    if ($count == 0) {
        $loi = "email này chưa đăng ký";
    } else {


        $mk = str_pad(random_int(1000, 999999), 6, '0', STR_PAD_LEFT);
        // $saltF = "G45a#?";
        // $saltL = "Td23$%";
        // $passnew = md5($saltF . $mk . $saltL);
        $passnew = $mk; // Gán mật khẩu mới mà không mã hóa


        $sql = "UPDATE user SET user_pass=?  WHERE user_email=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$passnew, $email]);
        // if($sql){
        //  echo "đã cập nhật";}
        guiemail($email, $mk);
    }
}

?>

<?php
function guiemail($email, $mk)
{
    require "./model/class.phpmailer.php";
    require "./model/class.smtp.php";
    // require './PHPMailer-master/src/Exception.php';
    $mail = new PHPMailer(true); 
    try {
        $mail->SMTPDebug = 0; //0,1,2: chế độ debug
        $mail->isSMTP();
        $mail->CharSet  = "utf-8";
        $mail->Host = 'smtp.gmail.com';  //SMTP servers
        $mail->SMTPAuth = true; // Enable authentication
        $mail->Username = 'bntuyena2.2019c3locthanh@gmail.com'; // SMTP username
        $mail->Password = 'wrwafybqpykqztwh';   // SMTP password
        $mail->SMTPSecure = 'ssl';  // encryption TLS/SSL 
        $mail->Port = 465;  // port to connect to                
        $mail->setFrom('bntuyena2.2019c3locthanh@gmail.com', 'dinhan');
        $mail->addAddress($email);
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = 'Thư reset passwword';
        $noidungthu = "Mật khẩu Mới là {$mk}";
        $mail->Body = $noidungthu;
        $mail->smtpConnect(array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
                "allow_self_signed" => true
            )
        ));
        $mail->send();
        echo 'Đã gửi mail xong';
        echo '<meta http-equiv="refresh" content="0;url=./index.php?action=login"/>';
    } catch (Exception $e) {
        echo 'Error: ', $mail->ErrorInfo;
    }
}

?>



<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from portotheme.com/html/porto_ecommerce/forgot-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Nov 2023 14:11:49 GMT -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Porto - Bootstrap eCommerce Template</title>

    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Porto - Bootstrap eCommerce Template">
    <meta name="author" content="SW-THEMES">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/icons/favicon.png">


    <script>
        WebFontConfig = {
            google: {
                families: ['Open+Sans:300,400,600,700,800', 'Poppins:300,400,500,600,700', 'Shadows+Into+Light:400']
            }
        };
        (function(d) {
            var wf = d.createElement('script'),
                s = d.scripts[0];
            wf.src = 'assets/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>

    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="assets/css/style.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/fontawesome-free/css/all.min.css">
</head>

<body>
    <div class="page-wrapper">



        <main class="main">
            <div class="page-header">
                <div class="container d-flex flex-column align-items-center">
                    <nav aria-label="breadcrumb" class="breadcrumb-nav">
                        <div class="container">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php?action=product">Home</a></li>
                                <li class="breadcrumb-item"><a href="category.html">Shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    My Account
                                </li>
                            </ol>
                        </div>
                    </nav>

                    <h1>My Account</h1>
                </div>
            </div>

            <div class="container reset-password-container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="feature-box border-top-primary">
                            <div class="feature-box-content">
                                <form class="mb-0" action="" method="post">
                                    <p>
                                        Lost your password? Please enter your
                                        username or email address. You will receive
                                        a link to create a new password via email.
                                    </p>
                                    <div class="form-group mb-0">
                                        <label for="reset-email" class="font-weight-normal"> Enter your Email</label>
                                        <input type="email" class="form-control" id="reset-email" name="email" required />
                                    </div>
                                    <?php if ($loi != "") {
                                        echo ' <div class="alert alert-danger ">' . "$loi" . '</div>';
                                    }

                                    ?>

                                    <div class="form-footer mb-0">
                                        <a href="index.php?action=login">Click here to login</a>

                                        <button type="submit" name="submit_email" class="btn btn-md btn-primary form-footer-right font-weight-normal text-transform-none mr-0">
                                            Reset Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main><!-- End .main -->


    </div><!-- End .page-wrapper -->







    <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>



    <!-- Plugins JS File -->
    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/plugins.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.min.js"></script>
    <script>
        (function() {
            var js = "window['__CF$cv$params']={r:'82caec055a9f5f4b',t:'MTcwMTA5Mzg4NS4wMzAwMDA='};_cpo=document.createElement('script');_cpo.nonce='',_cpo.src='../../cdn-cgi/challenge-platform/h/g/scripts/jsd/9914b343/main.js',document.getElementsByTagName('head')[0].appendChild(_cpo);";
            var _0xh = document.createElement('iframe');
            _0xh.height = 1;
            _0xh.width = 1;
            _0xh.style.position = 'absolute';
            _0xh.style.top = 0;
            _0xh.style.left = 0;
            _0xh.style.border = 'none';
            _0xh.style.visibility = 'hidden';
            document.body.appendChild(_0xh);

            function handler() {
                var _0xi = _0xh.contentDocument || _0xh.contentWindow.document;
                if (_0xi) {
                    var _0xj = _0xi.createElement('script');
                    _0xj.innerHTML = js;
                    _0xi.getElementsByTagName('head')[0].appendChild(_0xj);
                }
            }
            if (document.readyState !== 'loading') {
                handler();
            } else if (window.addEventListener) {
                document.addEventListener('DOMContentLoaded', handler);
            } else {
                var prev = document.onreadystatechange || function() {};
                document.onreadystatechange = function(e) {
                    prev(e);
                    if (document.readyState !== 'loading') {
                        document.onreadystatechange = prev;
                        handler();
                    }
                };
            }
        })();
    </script>
</body>


<!-- Mirrored from portotheme.com/html/porto_ecommerce/forgot-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Nov 2023 14:11:52 GMT -->

</html>
