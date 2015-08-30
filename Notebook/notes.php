<?
require_once getenv("PHPLIB") . "parsedown.php";
$pd = new Parsedown();
// convert filename to display name
function dispname($file) {
    return preg_replace("/-/", " ", ucwords($file));
}
$path = explode("?", substr($_SERVER["REQUEST_URI"], 7));
// default to index page
if (!$path[0]) return header("Location: index");
if (count($path) === 1)  $path[1] = "";
$loc = realpath($path[0] . ".md");
// must be within current (root) directory
if ($loc && substr($loc, 0, strlen(getcwd())) === getcwd()) {
    $file = file_get_contents($loc);
    switch ($path[1]) {
        case "source":
            $content = "<h1>Source: " . dispname($path[0]) . "</h1>\n            ";
            $content .= "<pre class=\"source\"><code>" . htmlspecialchars($file) . "</code></pre>";
            break;
        default:
            $content = preg_replace("/\n</", "\n            <", $pd->text($file)) . "\n";
            break;
    }
?><!DOCTYPE html>
<html>
    <head>
        <title><?=dispname($path[0])?> &ndash; Notebook</title>
        <link rel="stylesheet" href="res/css/style.css">
    </head>
    <body>
        <footer>Random ramblings of a socially awkward CompSci, presented by <a href="/">Ollie Terrance</a>.</footer>
        <div id="side">
            <div></div>
            <a href="index"<?=($path[0] === "index" ? " class=\"current\"" : "")?>>Index</a>
            <div></div>
<?
    foreach (glob("*.md") as $page) {
        $page = substr($page, 0, -3);
        if ($page === "index") continue;
        $curr = ($page === $path[0] ? " class=\"current\"" : "");
?>
            <a href="<?=$page?>"<?=$curr?>><?=dispname($page)?></a>
<?
    }
?>
            <div class="hidden"></div>
        </div>
        <div id="main">
<?
    if ($path[1] !== "source") {
?>
            <a class="top-right" href="<?=$path[0]?>?source">View source</a>
<?
    } else {
?>
            <a class="top-right" href="<?=$path[0]?>">View rendered</a>
<?
    }
?>
            <?=$content?>
        </div>
        <script src="/res/js/analytics.js"></script>
    </body>
</html>
<?
// not found
} else return http_response_code(404);
