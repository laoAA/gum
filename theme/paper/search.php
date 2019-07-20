<?php
if ($keyword == "") {
    gum::not_found();
}

$title        = $keyword . " - ";
$posts        = [];
$page_size    = 10;
$page_current = $page??1;
$sql          = "SELECT * FROM post WHERE status=1 AND (title LIKE '%".$keyword."%' OR content LIKE '%".$keyword."%')";
$count        = $db->count($sql); //先查数量
if ($count > 0) {
    $page_count   = ceil($count / $page_size);
    $page_current = max(min($page_current, $page_count), 1);
    $prev_page    = $page_current - 1 < 1 ? 1 : $page_current - 1;
    $next_page    = $page_current + 1 > $page_count ? $page_count : $page_current + 1;
    $rows         = $db->rows($sql . " ORDER BY id DESC LIMIT " . (($page_current - 1) * $page_size) . "," . $page_size); //获取ID(索引)
    $ids          = implode(array_column($rows, 'id'), ","); //取出id集合字符串
    $posts        = $db->rows("SELECT * FROM post WHERE id IN (" . $ids . ") ORDER BY id DESC");
}
?>

<?php include 'header.php';?>

<div class="layout">
<?php if (!empty($posts)): ?>
 
    <?php foreach ($posts as $post): ?>
    <?php
    $post["title"]=str_ireplace($keyword,"<span style='color:red'>".$keyword."</span>",$post["title"]);
    $post["description"]=empty($post["description"])?gum::short_text($post["content"]):$post["description"];
    $post["description"]=str_ireplace($keyword,"<span style='color:red'>".$keyword."</span>",$post["description"]);
    ?>
    <article class="post-entry">
        <header class="entry-header">
            <h2><?=$post["title"]?>
            <?php if ($post["best"] == 1): ?>
        <span class="best">推荐</span>
        <?php endif;?></a></h2>
        </header>
        <section class="entry-content">
        <p><?=$post["description"]?></p>
        </section>
        <footer class="entry-footer">
            <time><?=date("d F, Y", $post["time"])?></time>
        </footer>
        <a class="entry-link" href="<?=DOMAIN?>/post/<?=$post["id"]?>.html"></a>
    </article>
    <?php endforeach;?>
 

<?php if ($page_count > 1): ?>
<div class="pagination">
<?php if ($page_current > 1): ?>
    <a class="prev" href="<?=DOMAIN?>/search/<?=$keyword?>-<?=$prev_page?>.html"></a>
<?php else:?>
    <a class="prev disabled"></a>
<?php endif;?>

<?php if ($page_current < $page_count): ?>
    <a class="next" href="<?=DOMAIN?>/search/<?=$keyword?>-<?=$next_page?>.html"></a>
<?php else:?>
    <a class="next disabled"></a>
<?php endif;?>
</div>
<?php endif;?>

<?php else: ?>
    <div class="nodata">找不到数据</div>
<?php endif;?>
</div>
<?php include 'footer.php';?>