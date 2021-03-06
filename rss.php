<?php
require "./config.php";
require "./core/gum.php";
header("Content-type:text/xml");

$db   = new db();
$sql  = "SELECT * FROM post WHERE status=1 ORDER BY id DESC LIMIT 20";
$rows = $db->rows($sql);
if (isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
    $protocol = 'https://';
} else {
    $protocol = 'http://';
}

$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
$xml .= "<rss version=\"2.0\">\r\n";
$xml .= "<channel>\r\n";
$xml .= "<title>" . TITLE . "</title>\r\n";
$xml .= "<description>" . DESCRIPTION . "</description>\r\n";
$xml .= "<link>" . DOMAIN . "</link>\r\n";
foreach ($rows as $row) {

    $xml .= "<item>\r\n";
    $xml .= "\t<link>" . $protocol . $_SERVER['HTTP_HOST'] . "/post/" . $row['id'] . ".html</link>\r\n";
    $xml .= "\t<pubDate>" . date('D, d M Y H:i:s O', $row['time']) . "</pubDate>\r\n";
    $xml .= "\t<description><![CDATA[ " . $row['content'] . " ]]></description>\r\n";

    $xml .= "\t<category><![CDATA[ " . $row['tag_name'] . " ]]></category>\r\n";
    if (!empty($row['author'])) {
        $xml .= "\t<author><![CDATA[ " . $row['author'] . " ]]></author>\r\n";
    }

    $xml .= "\t<title><![CDATA[ " . $row['title'] . " ]]></title>\r\n";
    $xml .= "</item>\r\n";

}
$xml .= "</channel>\r\n";
$xml .= "</rss>\r\n";
echo $xml;
