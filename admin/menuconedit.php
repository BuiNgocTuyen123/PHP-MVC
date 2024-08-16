<?php 
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/menucha.php';

if (!isset($_GET['menucon_ID']) || $_GET['menucon_ID'] == NULL) {
    echo "<script>window.location ='menuconlist.php'</script>";
} else {
    $id = $_GET['menucon_ID'];
}

$menucon = new menucha();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $updateMenucon = $menucon->update_menucon($_POST, $id);
}

?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Sửa menu con</h2>
        <div class="block copyblock"> 
            <?php 
            if (isset($updateMenucon)) {
                echo $updateMenucon;
            }
            $get_menucon_name = $menucon->getmenuconbyID($id);
            if ($get_menucon_name) {
                while ($result_con = $get_menucon_name->fetch_assoc()) {
            ?>
            <form action="" method="post">
                <table class="form">
                    <tr>
                        <td>
                            <input type="text" value="<?php echo $result_con['menucon_Name']; ?>" name="menucon_Name" placeholder="Nhập tên menu con sau khi sửa:..." class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Menu cha</label>
                        </td>
                        <td>
                            <select id="select" name="menucha">
                                <option>Chọn menu cha</option>
                                <?php
                                $menucha = new menucha();
                                $menuchalist = $menucha->show_menucha();
                                if ($menuchalist) {
                                    while ($result_cha = $menuchalist->fetch_assoc()) {
                                ?>
                                <option 
                                    <?php if ($result_cha['menucha_ID'] == $result_con['menucha_ID']) { echo 'selected'; } ?>
                                    value="<?php echo $result_cha['menucha_ID']; ?>"><?php echo $result_cha['menucha_Name']; ?>
                                </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr> 
                        <td>
                            <input type="submit" name="submit" Value="Edit" />
                        </td>
                    </tr>
                </table>
            </form>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>
