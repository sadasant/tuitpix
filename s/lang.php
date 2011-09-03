<?
session_start();

if ($_GET["lang"] == "eng" || $_GET["lang"] == "esp") {
    $_SESSION["lang"] = $_GET["lang"];
    echo $_SESSION["lang"];
}

?>
