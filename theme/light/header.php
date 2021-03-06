<!DOCTYPE html>
<html lang="zh-Hans">
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit">
<meta name="force-rendering" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, viewport-fit=cover">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Pragma" content="no-cache">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="white">
<meta name="apple-mobile-web-app-title" content="<?=$config["title"]?>">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="email=no">
<meta name="theme-color" content="#ffffff">

<?php if (isset($post)): ?>
<meta property="og:site_name" content="<?=$config["title"]?>">
<meta property="og:type" content="article">
<meta property="og:title" content="<?=htmlspecialchars($post["title"])?>">
<meta property="og:url" content="<?=DOMAIN?>/post/<?=$post["id"]?>.html">
<meta property="og:image" content="<?=htmlspecialchars($post["cover"])?>">
<meta property="og:description" content="<?=$description?>">
<?php endif;?>

<?php if (!empty($keywords)): ?>
<meta name="keywords" content="<?=$keywords?>">
<?php endif;?>
<?php if (!empty($description)): ?>
<meta name="description" content="<?=$description?>">
<?php endif;?>
<?php if (!empty($post["author"])): ?>
<meta name="author" content="<?=htmlspecialchars($post["author"])?>">
<?php endif;?>
<link rel="icon" href="data:image/ico;base64,aWNv">
<link rel="stylesheet" href="<?=DOMAIN?>/theme/light/static/main.css">
<link rel="alternate" type="application/rss+xml" title="<?=$config["title"]?> RSS 2.0" href="<?=DOMAIN?>/rss.php">
<title><?=@$title?><?=$config["title"]?></title>
</head>
<body>

<header>

  <a  href="<?=DOMAIN?>" class="logo"><img src="<?=DOMAIN?>/theme/light/static/logo.svg"></a>
  <nav>

  <?php $nav_tags = $db->rows("SELECT * FROM tag WHERE status=1 ORDER BY sort ASC");?>
  <?php foreach ($nav_tags as $nav_key => $nav_tag): ?>
    <?php if ($nav_key > 0): ?>
      <span></span>
    <?php endif;?>
    <a href="<?=DOMAIN?>/tag/<?=$nav_tag["id"]?>.html" <?=(isset($active) && $active == $nav_tag["id"] ? "class='active'" : "");?>><?=$nav_tag["name"]?></a>
  <?php endforeach;?><span></span><a href="<?=DOMAIN?>/about" <?=($file == 'about' ? "class='active'" : "");?>>关于</a>
  </nav>
  </header>

