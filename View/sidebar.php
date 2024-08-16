<?php
spl_autoload_register(function($className){
	include_once "classes/".$className.".php";
});
$th = new thuonghieu();
$brandlist = $th->show_thuonghieu();
?>
<style>
    #sidebar ul ul {
    display: none; /* Ẩn tất cả các ul.sub ban đầu */
}
#sidebar {
    width: 250px;
    height: 100%;
    background: rgba(52, 48, 48, 0.78);
    position: fixed; /* Thêm thuộc tính position: fixed */
    top: 0; /* Đặt vị trí fixed ở trên cùng của trang */
    left: 0; /* Đặt vị trí fixed ở bên trái của trang */
    bottom: 0; /* Đặt chiều cao fixed để sidebar kéo dài đến dưới cùng của trang */
    z-index: 5; /* Đảm bảo sidebar hiển thị trên mọi phần khác của trang */
    overflow-y: auto; /* Hiển thị thanh cuộn khi nội dung quá dài */
    margin-top: 50px;
    border-right: 3px solid brown;
}

#sidebar ul li {
    position: relative;
}
ul.sidebar-menu,ul.sidebar-menu li ul.sub {
    margin:-2px 0 0;
    padding:0;
}
ul.sidebar-menu {
    padding-top:80px;

}
#sidebar>ul>li>ul.sub {
    display:none;
}
#sidebar .sub-menu>.sub li a {
    padding-left:46px;
}
#sidebar>ul>li.active>ul.sub,#sidebar>ul>li>ul.sub>li>a {
    display:block;
}
ul.sidebar-menu li ul.sub li {
    background:rgba(52, 48, 48, 0);
    margin-bottom:0;
    margin-left:0;
    margin-right:0;
}
ul.sidebar-menu li ul.sub li a {
    font-size:12px;
    padding-top:13px;
    padding-bottom:13px;
    -webkit-transition:all 0.3s ease;
    -moz-transition:all 0.3s ease;
    -o-transition:all 0.3s ease;
    -ms-transition:all 0.3s ease;
    transition:all 0.3s ease;
    color:#fff;
}
ul.sidebar-menu li ul.sub li a:hover,ul.sidebar-menu li ul.sub li.active a {
    color:#fff;
    -webkit-transition:all 0.3s ease;
    -moz-transition:all 0.3s ease;
    -o-transition:all 0.3s ease;
    -ms-transition:all 0.3s ease;
    transition:all 0.3s ease;
    display:block;
    background:rgba(40, 40, 46, 0.28);
}
ul.sidebar-menu li {
    border-bottom:1px solid rgba(255,255,255,0.05);
}
ul.sidebar-menu li.sub-menu {
    line-height:15px;
}
ul.sidebar-menu ul.sub li {
    border-bottom:none;
}
ul.sidebar-menu li a span {
    display:inline-block;
}
ul.sidebar-menu li a {
    color:#fff;
    text-decoration:none;
    display:block;
    padding:18px 0 18px 25px;
    font-size:12px;
    outline:none;
    -webkit-transition:all 0.3s ease;
    -moz-transition:all 0.3s ease;
    -o-transition:all 0.3s ease;
    -ms-transition:all 0.3s ease;
    transition:all 0.3s ease;
}
ul.sidebar-menu li a.active, ul.sidebar-menu li a:hover, ul.sidebar-menu li a:focus {
    background: rgba(40, 40, 46, 0.28);
    color: #fff;
    display: block;
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    -ms-transition: all 0.3s ease;
    transition: all 0.3s ease;
}
ul.sidebar-menu li a i {
    font-size:15px;
    padding-right:6px;
}
ul.sidebar-menu li a:hover i,ul.sidebar-menu li a:focus i {
    color:#fff;
}
ul.sidebar-menu li a.active i {
    color:#fff;
}
</style>
<aside>
<div id="sidebar" class="nav-collapse">
    <div class="leftside-navigation">
        <ul class="sidebar-menu" id="nav-accordion">
            <li>
                <b class="active" style="color:white;">
                    <i style="margin-left:20px;" class="fa fa-dashboard"></i>
                    <span>Thương hiệu sản phẩm</span>
                </b>
            </li>
            <?php
            if ($brandlist) {
                while ($result = $brandlist->fetch_assoc()) {
            ?>
            <li class="sub-menu">
            <a href="productbybrand.php?brand_ID=<?php echo urlencode($result['brand_ID']); ?>">
                    <i class="fa fa-book"></i>
                    <span><?php echo $result['brand_Name']; ?></span>
                </a>
            </li>
            <?php
                }
            }
            ?>
        </ul>
    </div>
</div>
</aside>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
$(document).ready(function() {
    // Khi một link trong sub-menu được clicked
    $('.sub-menu > a').click(function(e) {
        // Ngăn sự kiện lan truyền lên phần tử cha
        e.stopPropagation();

        // Tìm ul.sub gần nhất của link được click và thực hiện hành động slideToggle
        $(this).next('ul.sub').slideToggle();

        // Đóng tất cả các ul.sub khác không liên quan
        $(".sub-menu > ul.sub").not($(this).next()).slideUp();
    });

    // Thêm sự kiện click cho các liên kết bên trong sub-menu
    $('.sub-menu > ul.sub > li > a').click(function(e) {
        // Ngăn sự kiện lan truyền để không ảnh hưởng đến bộ xử lý sự kiện ở cấp cao hơn
        e.stopPropagation();
    });
});



</script>