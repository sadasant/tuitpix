<?php
# D:{SADASANT;}
# propose.php ~ proposing parts to tuitpix

if (!$_SESSION) include 'auth.php';

if ($_SERVER['HTTP_HOST'] == "tuitpix.com" && isset($_SESSION['access_token']) && isset($R)) {
    $link = mysql_connect("localhost","tuitpix_tuitpix","le*7u17p1x*DB");
    $db   = mysql_select_db("tuitpix_tuitpix",$link);

    $twid  = "t".$R->id;

    $table = explode(".",$_SERVER['PHP_SELF']);
    $table = explode("/",$table[0]);
    $table = ($table[2] == "load")? "maker" : $table[1];
    if ($table == "_index") $table = "index";
    if ($table == "_maker") $table = "maker";
    
    if ($table == "maker") {
        if ($_POST["active"]) {
            $active = $_POST["active"];
        } else {
            die();
        }
    }

    $_table = ($active == "gen")? "index" : (($_POST["of"])? $_POST["of"] : $table);
    $query = ($active)? "SELECT twid,".(($_table == "index")? " sex, looking, " : "" )." ".$active." FROM `" : "SELECT twid, looking, sex, gen, hair, beard, wear, addon FROM `";
    $query.= $_table."` WHERE twid = '$twid'";
    if($query = mysql_query($query, $link)) {
        $arr = array();
        while($row = mysql_fetch_array($query))
            $arr[] = $row;

        if ($arr[0]) {
            if ($table == "index") {
                $load = "LOAD = ($.parseJSON('".json_encode($arr)."'))[0];";
            }
            elseif ($table == "maker") {
                $load = json_encode($arr);
                echo $load;
            }
        } else {
        }
    }
}

?>
