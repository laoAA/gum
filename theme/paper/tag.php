<?php
if ($id == "") {
    gum::not_found();
}
// 获取tag信息
$tag = $db->row("SELECT * FROM tag WHERE id=?", ["params" => [$id]]);
// print_r($tag);exit;
if (!$tag) {
    gum::not_found();
}
$title        = $tag["name"] . " - ";
$active       = $id;
$posts        = [];
$page_size    = 10;
$page_current = $page ?? 1;
$sql          = "SELECT * FROM post WHERE status=1 AND tag_id='" . $id . "'";
$count        = $db->count($sql); //先查数量
if ($count > 0) {
    $page_count   = ceil($count / $page_size);
    $page_current = max(min($page_current, $page_count), 1);
    $prev_page    = $page_current - 1 < 1 ? 1 : $page_current - 1;
    $next_page    = $page_current + 1 > $page_count ? $page_count : $page_current + 1;
    $rows         = $db->rows($sql . " ORDER BY id DESC LIMIT " . (($page_current - 1) * $page_size) . "," . $page_size); //获取ID(索引)
    $ids          = implode(",",array_column($rows, 'id')); //取出id集合字符串
    $posts        = $db->rows("SELECT * FROM post WHERE id IN (" . $ids . ") ORDER BY id DESC");
}
?>

<?php include 'header.php'; ?>

<div class="layout home">
<?php if (!empty($posts)): ?>
    <div class="post-entries">
    <?php foreach ($posts as $post): ?>
        <article class="detail">
    <div class="title"><a  href="<?=DOMAIN ?>/post/<?=$post["id"] ?>.html"><?=$post["title"] ?></a></div>
    <div class="meta">
        <time>发表于 <?=date("Y年m月d日", $post["time"]) ?></time>
        <span>阅读 <?=number_format($post["view"]) ?></span>
        <?php if (!empty($post["author"])): ?>
            <span>作者 <?=$post["author"] ?></span>
		<?php endif; ?>

    </div>
	<section><?=empty($post["description"]) ? gum::short_text($post["content"]) : $post["description"] ?></section>
</article>
<?php endforeach; ?>
            </div>

<?php if ($page_count > 1): ?>
<div class="pagination">
<?php if ($page_current > 1): ?>
    <a class="prev" href="<?=DOMAIN ?>/tag/<?=$id ?>-<?=$prev_page ?>.html"></a>
<?php else: ?>
    <a class="prev disabled"></a>
<?php endif; ?>

<?php if ($page_current < $page_count): ?>
    <a class="next" href="<?=DOMAIN ?>/tag/<?=$id ?>-<?=$next_page ?>.html"></a>
<?php else: ?>
    <a class="next disabled"></a>
<?php endif; ?>
</div>
<?php endif; ?>

<?php else: ?>
    <div class="nodata">找不到数据</div>
<?php endif; ?>
</div>
<?php include 'footer.php'; ?>