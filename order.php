
<?php
include './View/header.php';
include './View/slider.php';
?>
<?php 
$login_check = Session::get('customer_login');
if($login_check==false){
    echo '<script type="text/javascript">window.location.href = "login.php";</script>';
}

?>
<div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<div class="not_found">
                       <h3>ORDER</h3>
                    </div>
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
 <?php
include './View/Footer.php';
?>