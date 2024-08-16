<?php include './View/header.php'; ?>

<style>
.name_pages{
    text-align: center;
    color: Red;
    margin-top: 200px;
}
.container {
    margin-top: 100px;
    margin-bottom: 100px;
}
.news-item {
    margin-bottom: 50px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}
.news-item-header {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin-bottom: 15px;
}
.news-item h2 {
    font-size: 24px;
}
.news-date {
    margin-left: 200px;
    color: #666;
}
.news-item img {
    max-width: 100%;
    height: auto;
    margin-bottom: 15px;
}
.news-content {
    text-align: justify;
}
</style>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<div class="container">
    <h1 class="name_pages">Tin tức mới nhất</h1>
    <?php
    $news = new sanpham(); // Giả sử bạn đã có class sanpham với method show_news
    $news_list = $news->show_news();
    if ($news_list) {
        while ($result = $news_list->fetch_assoc()) {
            // Chuyển đổi ngày từ dạng YYYY-MM-DD HH:MM:SS sang dạng DD/MM/YYYY
            $date = new DateTime($result['date_time']);
            $formattedDate = $date->format('d/m/Y');
    ?>
        <div class="news-item">
            <div class="news-item-header">
                <h2><?= $result['tieu_de']; ?></h2>
                <span class="news-date">Ngày đăng: <?= $formattedDate; ?></span>
            </div>
            <p class="news-content"><?= $result['content']; ?></p>
            <img src="admin/upload/<?= $result['image']; ?>" alt="News Image">
        </div>
    <?php
        }
    }
    ?>
</div>

<?php include './View/footer.php'; ?>
