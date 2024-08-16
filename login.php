
<?php
include './View/header.php';
include './View/slider.php';

?>
<?php 
$login_check = Session::get('customer_login');
if ($login_check) {
  echo '<script type="text/javascript">window.location.href = "order.php";</script>';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login/sign-up</title>
</head>

<body>
  <style>
    @import url("https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css");
    @import url("https://unicons.iconscout.com/release/v2.1.9/css/unicons.css");
    @import url("https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900");

    body {
      font-family: "Poppins", sans-serif;
      font-weight: 300;
      font-size: 15px;
      line-height: 1.7;
      background: linear-gradient(to right, #4e5150, #c1d3e6, #f897c4, brown);
      /* Gradient from left to right */
    }

    a {
      cursor: pointer;
      transition: all 200ms linear;
    }

    a:hover {
      text-decoration: none;
    }

    link {
      color: #c4c3ca;
    }

    .link:hover {
      color: #ffeba7;
    }

    p {
      font-weight: 500;
      font-size: 14px;
      line-height: 1.7;
    }

    h4 {
      font-weight: 600;
    }

    h6 span {
      padding: 0 20px;
      text-transform: uppercase;
      font-weight: 700;
    }

    .section {
      position: relative;
      width: 100%;
      display: block;
    }

    .full-height {
      min-height: 100vh;
    }

    [type="checkbox"] {
      position: absolute;
      appearance: none;
    }

    .checkbox:checked+label,
    .checkbox:not(:checked)+label {
      position: relative;
      display: block;
      text-align: center;
      width: 60px;
      height: 16px;
      background-color: #ffeba7;
      border-radius: 8px;
      padding: 0;
      margin: 10px auto;
      cursor: pointer;
    }

    .checkbox:checked+label:before,
    .checkbox:not(:checked)+label:before {
      position: absolute;
      display: block;
      width: 36px;
      height: 36px;
      background-color: #102770;
      border-radius: 50%;
      color: #ffeba7;
      font-family: "unicons";
      content: "\eb4f";
      z-index: 20;
      top: -10px;
      left: -10px;
      line-height: 36px;
      text-align: center;
      font-size: 24px;
      transition: all 0.5s ease;
    }

    .checkbox:checked+label:before {
      transform: translateX(44px) rotate(-270deg);
    }

    .card-3d-wrap {
      position: relative;
      width: 440px;
      max-width: 100%;
      height: 400px;
      transform-style: preserve-3d;
      perspective: 800px;
      margin-top: 60px;
    }

    .card-3d-wrapper {
      width: 100%;
      height: 100%;
      display: flex;
      gap: 10px;
      position: absolute;
      top: 0;
      left: 0;
      transform-style: preserve-3d;
      transition: all 600ms ease-out;
    }

    .card-front,
    .card-back {
      width: 100%;
      height: 100%;
      background-color: #2a2b3B;
      background-image: url("{{ asset('frontend/img/image.png') }}");
      background-repeat: no-repeat;
      background-size: cover;
      /* This will cover the entire element */
      border-radius: 6px;
      left: 0;
      top: 0;
      transform-style: preserve-3d;
      backface-visibility: hidden;
    }

    .center-wrap {
      position: absolute;
      width: 100%;
      padding: 0 35px;
      top: 50%;
      left: 0;
      transform: translate3d(0, -50%, 35px)perspective(100px);
      z-index: 20;
      display: block;
    }

    .form-group {
      position: relative;
      display: block;
      margin: 0;
      padding: 0;
    }

    .form-style {
      color: #c4c3ca;
      background-color: #1f2029;
      padding: 13px 20px;
      padding-left: 55px;
      height: 48px;
      width: 100%;
      font-weight: 500;
      border-radius: 4px;
      font-size: 14px;
      line-height: 22px;
      letter-spacing: 0.5px;
      outline: none;
      border: none;
      transition: all 200ms linear;
      box-shadow: 0 4px 8px 0 rgba(21, 21, 21, 0.2);
    }

    .form-style:focus {
      border: none;
      outline: none;
      box-shadow: 0 4px 8px 0 rgba(21, 21, 21, 0.2);
    }

    .input-icon {
      position: absolute;
      top: 0;
      left: 18px;
      height: 48px;
      font-size: 24px;
      line-height: 48px;
      text-align: left;
      color: #ffeba7;
      transition: all 200ms linear;
    }

    input:focus::-webkit-input-placeholder {
      opacity: 0;
      transition: all 200ms linear;
    }

    .btn {
      background-color: #ffeba7;
      color: #102770;
      border-radius: 4px;
      height: 44px;
      font-size: 13px;
      font-weight: 600;
      text-transform: uppercase;
      transition: all 200ms linear;
      padding: 0 30px;
      letter-spacing: 1px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      border: none;
      box-shadow: 0 8px 24px 0 rgba(255, 235, 167, 0.2);
    }

    .btn:hover {
      background-color: #102770;
      color: #ffeba7;
      box-shadow: 0 8px 24px 0 rgba(16, 39, 112, 0.2);
    }

    .card-front,
    .card-back {
      position: absolute;
    }

    .card-back {
      transform: rotateY(180deg);
    }

    .checkbox:checked~.card-3d-wrap .card-3d-wrapper {
      transform: rotateY(180deg);
    }

    #login-sign-up {
      position: relative;
      z-index: 1500;
    }
  </style>
  </head>

  <body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
      $insertuser = $us->add_user($_POST);
    }
    // Kiểm tra sau khi form đăng nhập được submit
// Kiểm tra sau khi form đăng nhập được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
  $login_customer = $us->login_user($_POST);
  if ($login_customer === true) {
      // Đăng nhập thành công, chuyển hướng người dùng đến trang 'order.php'
      echo '<script type="text/javascript">window.location.href = "cart.php";</script>';
  } else {
      // Đăng nhập không thành công, hiển thị thông báo lỗi
      echo '<script type="text/javascript">alert("Tài khoản hoặc mật khẩu ko đúng");</script>';
  }
}


    ?>
    <div class="section" id="login-sign-up">
      <div class="container">
        <div class="row full-height justify-content-center">
          <div style="margin-top:100px;" class="col-12 text-center align-self-center py-5">
            <div class="section pb-5 pt-5 pt-sm-2 text-center">
              <h6 style="color:white;" class="mb-0 pb-3"><span>Log In</span><span>Sign Up</span></h6>
              <input class="checkbox" id="reg-log" type="checkbox" name="reg-log">
              <label for="reg-log"></label>
              <div class="card-3d-wrap mx-auto">
                <div class="card-3d-wrapper">
                  <div class="card-front">
                    <div class="center-wrap">
                      <div class="section text-center">
                        <h4 style="color:white;" class="mb-4 pb-3">Log In</h4>
                        <?php
                        if(isset($login_customer)){
                          echo $login_customer;
                        }
                        ?>
                        <?php
                        if (isset($insertuser)) {
                          echo $insertuser;
                        }
                        ?>
                        <form action="login.php" method="POST">
                          <div class="form-group">
                            <input type="text" name="username" id="logemail" class="form-style" placeholder="Your emai"
                              autocomplete="off" aria-describedby="helpId">
                            <i class="input-icon uil uil-at"></i>
                          </div>
                          <div class="form-group mt-2">
                            <input type="password" name="password" class="form-style" placeholder="Your password"
                              id="logpass" autocomplete="off">
                            <i class="input-icon uil uil-lock-alt"></i>
                          </div>
                          <input type="submit" name="login" value="đămg mhập" class="btn mt-4">
                        </form>
                        <p class="mb-0 mt-4 text-center"><a href="forgetpassword.php" class="link">Forgot your password?</a></p>
                      </div>
                    </div>
                  </div>
                  <div class="card-back">
                    <div class="center-wrap">
                      <div class="section text-center">
                        <h4 style="color:white;" class="mb-4 pb-3">Sign up</h4>
                        <form action="login.php" method="POST">
                          <div class="form-group">
                            <input type="text" name="user_name" class="form-style" placeholder="Your full name"
                              id="logname" autocomplete="off">
                            <i class="input-icon uil uil-user"></i>
                          </div>

                          <div class="form-group mt-2">
                            <input type="password" name="user_pass" class="form-style" placeholder="Your password"
                              autocomplete="off">
                            <i class="input-icon uil uil-lock-alt"></i>
                          </div>

                          <div class="form-group" style="margin-top:10px;">
                            <input type="text" name="address" class="form-style" placeholder="Địa chỉ"
                              id="address" autocomplete="off">
                            <i class="input-icon uil uil-user"></i>
                          </div>
                          <div class="form-group mt-2">
                            <input type="email" name="user_email" class="form-style" placeholder="Your email"
                              autocomplete="off">
                            <i class="input-icon uil uil-at"></i>
                          </div>
                          <div class="form-group mt-2">
                            <input type="text" name="user_phone" class="form-style" placeholder="Your phone"
                              autocomplete="off">
                            <i class="input-icon uil uil-phone-alt"></i>
                          </div>
                          <button type="submit" name="signup" class="btn mt-4">Signup</button>
                        </form>
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

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
      integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
      crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
      integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
      crossorigin="anonymous"></script>
  </body>

</html>