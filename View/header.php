<?php
include './lib/session.php';
Session::init();
?>
<?php
include_once './lib/database.php';
include_once './helpers/format.php';
spl_autoload_register(function($className){
	include_once "classes/".$className.".php";
});
$db = new Database();
$fm = new Format();
$ct = new cart();
$us = new user();
$menucon = new menucha();
$sp = new sanpham();
$menucha = new menucha();
  header("Cache-Control: no-cache, must-revalidate");
  header("Pragma: no-cache"); 
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
  header("Cache-Control: max-age=2592000");
?>
<?php
if (isset($_GET['customer_id'])) {
  $delcart = $ct->del_all_data_cart();
  Session::destroy();
  header('Location: login.php');
  exit;
}
?>
<!DOCTYPE HTML>
<head>
<title>Store Website</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="./button.css">
<script src="js/jquerymain.js"></script>
<script src="js/script.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> 
<script type="text/javascript" src="js/nav.js"></script>
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script> 
<script type="text/javascript" src="js/nav-hover.js"></script>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
<script type="text/javascript">
  $(document).ready(function($){
    $('#dc_mega-menu-orange').dcMegaMenu({rowItems:'4',speed:'fast',effect:'fade'});
  });
</script>
<style>
  @import url('http://fonts.googleapis.com/css?family=poppins:ital,wght@0,400;0,500;1,500&display=swap');
*{
    padding: 0;
    margin: 0;
}
body {
  
    width: 100%;
    height: 100vh;
    font-family: 'Poppins', sans-serif;
    margin: 0;
  }
  .logo ion-icon:hover {
    color: red;  
  }
  header {
  display: flex;
  background-color: #000;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1000;
  padding: 0 20px;
  height: 100px; /* Điều chỉnh chiều cao nếu cần */
}
  header .logo ion-icon {
    font-size: 50px;
    color: white;
    animation: animate 4s infinite linear;
  }
  .logo {
  display: flex;
  align-items: center;
}
  .logo ion-icon:hover {
  color: red;  
  animation: rotate 4s infinite linear, scaleUp 0.3s forwards; /* Kích hoạt cả hai animation khi hover */
}
  @keyframes animate {
    0% {
      transform: rotate(0deg);
    }
  
    100% {
      transform: rotate(360deg);
    }
  }
  @keyframes scaleUp {
  0% {
    transform: scale(1);
  }

  100% {
    transform: scale(1.3);
  }
}
#main-menu {
  flex: 1; /* Cho phép menu mở rộng */
  display: flex;
  justify-content: flex-end; /* Căn phải các menu items */
  list-style: none;
  padding: 0;
  margin: 0;
}
.menuu {
    text-decoration: none;
    color: white;
    margin-top:-50px ;
}

.menuu:hover {
    color: red; /* Màu chữ khi hover */
    transform: 1.2;
    text-decoration: none;
}


header #main-menu .item{
    margin: 0px 30px;
}
header .loginn{
    width: 200px;
    height: 40px;
    background-color: #61DBFB;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
}
.dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 2;
        }
.dropdown:hover .dropdown-content {
            display: block;
        }
        .menucon{
          color:black;
        }
        .dropdown-content{
          width:1604px;
          height:auto;
          margin-left: -1052px;
          z-index:100;
          border-top:5px solid brown;
          background-color: black;
        }
        hr {
    border: none;
    border-top: 2px solid black; /* Màu đen và độ dày 2px */
    margin: 10px 0; /* Điều chỉnh khoảng cách trên và dưới đường kẻ */
  }
  .menuconn{
    color:white;
  }
.menuconn:hover{
  text-decoration: none;
  color: red;
}
.menuchaa{
  color: yellow;
    text-decoration: underline; /* Bật gạch chân */
}
.menuchaa:hover{
  color:red;
  font-weight: bold; /* Làm đậm khi hover */

}
#main-menu li.item {
  padding: 0 10px; /* Khoảng cách giữa các menu item */
}

.menuu {
  color: white;
  text-decoration: none;
  display: block;
  padding: 10px 15px;
}
.menuu:hover, .menuu.active {
  color: red;
  text-decoration: none;
}

.dropdown-content {
  display: none; /* Ẩn nội dung dropdown */
}

.dropdown:hover .dropdown-content {
  display: block; /* Hiển thị khi hover */
  position: absolute; /* Để không làm xô lệch layout chính */
}
.name_shop{
  color:white;
}
.name_shop:hover{
  text-decoration: none;
  color:red;
}
.logo{
      width:300px;
      margin-top:20px;
    }
    .search_box{
      margin-left:30px;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div id="web">
            <header>
              <div class="logo">
               <a href="index.php"> <ion-icon name="logo-react"></ion-icon></a>
               <a class="name_shop" href="index.php">Re-shop</a>
               <div class="searchh">
                  <form action="search.php" method="post">
                    <input type="text" placeholder="Tìm kiếm sản phẩm" name="tu_khoa" style="color:white; border:solid 2px red; width:100px; justify-content: center; margin-left:20px; background-color:black; height:50px;">
                    <input type="submit" name="search_product" value="Tìm" name="tim_kiem" style="background-color:white;">
                  </form>
              </div>
              </div>
      
              <ul id="main-menu">
              <?php 
    $login_check = Session::get('customer_login');
    if($login_check == false){
      echo '';
    }
    else{
      ?> 
    <li class="item"><a class="menuu" href="profile.php">Profile</a></li>
    <?php } ?>
    <li class="item"><a class="menuu" href="news.php">Tin tức</a></li>
    <li class="item"><a class="menuu" href="all_pro.php">Tất cả sản phẩm</a></li>
    <li class="item"><a class="menuu" href="cart.php">Cart</a></li>
    <li class="nav-item item" style="margin-top:-20px;">
            <div class="dropdown">
                <a class="menuu fa fa-bars" href="products.php"> <b>v</b></a>
                <div class="dropdown-content">
                            <div class="row">
                            <?php
                    $menucha_show = $menucha->show_menucha();
                    if ($menucha_show) {
                        while ($result_cha = $menucha_show->fetch_assoc()) {
                          ?>
                            <div class='col-md-3'>
                            <br>
                            <a style="margin-left:80px;" class="menuchaa" href="productbymenucha.php?menucha_id=<?php echo $result_cha['menucha_ID']; ?>"><?php echo $result_cha['menucha_Name']; ?></a><br><br>
                          <?php
                            // Lấy danh sách các menu con tương ứng với menu cha
                            $menucon_show = $menucon->show_menuconn($result_cha['menucha_ID']);
                            if ($menucon_show) {
                                while ($result_con = $menucon_show->fetch_assoc()) {
                                  ?>
    <a style="margin-left:80px;" class="menuconn" href="productbymenucon.php?menucon_ID=<?php echo $result_con['menucon_ID']; ?>"><?php echo $result_con['menucon_Name']; ?></a><br><br>
                                    <?php
                                }
                            }
                            ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    </div>
                </div>
            </div>
    </li>
    <li class="item">
    <?php $login_check = Session::get('customer_login');
    if($login_check == false){
      ?>
      <a class="menuu" href="./login.php"><button class="glowing-btn">
      <span class="glowing-txt">N <span class="faulty-letter">H</span>ẬP </span>
  </button>
          </header></a>
          <?php
    }
    else{
      ?>
         <a class="menuu" href="<?php echo '?customer_id='.Session::get('customer_id') ?>"><button class="glowing-btn">
        <span class="glowing-txt">X <span class="faulty-letter">U</span>ẤT</span>
    </button>
            </header></a>
      <?php
    }
     ?>  
 </li>
</ul>
    </div>
</body>
</html>