<?php
# D:{SADASANT;}
# propose.php ~ proposing parts to tuitpix

include 'auth.php';

//var_dump($_FILES);
//var_dump($_POST);

$table = explode("/",$_SERVER['HTTP_REFERER']);
$table = explode(".",$table[3]);
$table = ($table[0] !== "")? $table[0] : "index";

if ($table == "_index") $table = "index";
if ($table == "_maker") $table = "maker";

//var_dump($table);
//var_dump($_SERVER['HTTP_HOST']);

if ($_SERVER['HTTP_HOST'] == "tuitpix.com" && isset($R) && (
        (   $table == "index" &&
            ($_POST["looking"] === "0" || $_POST["looking"] === "1") &&
            ($_POST["sex"]     === "0" || $_POST["sex"]     === "1") &&
            ($gen   = $_POST["gen"]) &&
            ($hair  = $_POST["hair"]) &&
            ($beard = $_POST["beard"]) &&
            ($wear  = $_POST["wear"]) &&
            ($addon = $_POST["addon"]) &&
            ($img   = $_POST["img"])
        )   ||
        (   $table == "maker" &&
            (    ($gen  = $_POST["gen"]) ||
                 ($hair  = $_POST["hair"]) ||
                 ($beard = $_POST["beard"]) ||
                 ($wear  = $_POST["wear"]) ||
                 ($addon = $_POST["addon"])
            )
        )
    )) {
    echo "LOGGED \n";

    $link = mysql_connect("localhost","tuitpix_tuitpix","le*7u17p1x*DB");
    $db   = mysql_select_db("tuitpix_tuitpix",$link);

    $twid  = "t".$R->id;
    if (isset($_POST["looking"])) $look  = ($_POST["looking"] === "1")? "1" : "0";
    if (isset($_POST["looking"])) $sex   = ($_POST["sex"] === "1")? "1" : "0";
    if (isset($gen  )) $gen   = mysql_escape_string($gen);
    if (isset($hair )) $hair  = mysql_escape_string($hair);
    if (isset($beard)) $beard = mysql_escape_string($beard);
    if (isset($wear )) $wear  = mysql_escape_string($wear);
    if (isset($addon)) $addon = mysql_escape_string($addon);
    if (isset($img  )) $img   = mysql_escape_string($img);
        
    
    // WRITE FUNCTION
    function _fwrite($tmpname, $filename, $decode = 0) {
        $tmpFile = fopen($tmpname, 'r');
        if ($decode && file_exists($filename) ) unlink($filename);
        $file = fopen($filename, 'w');
        while (!feof($tmpFile)) {
            fwrite($file, (($decode)? base64_decode(fread($tmpFile, 8192)) : fread($tmpFile, 8192)));
        }
        fclose($file);
        fclose($tmpFile);
    }
    
    if ($table == "index") {
        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            _fwrite($_FILES['image']['tmp_name'], "../i/".$R->screen_name.".png", 1);
            if ($_POST["twitter"]) _fwrite("../i/".$R->screen_name.".png", $_FILES['image']['tmp_name']);
        }


        /*
         * twitter stuff
         */
        if ($_POST["twitter"]) {
            $params = array(
                'image' => "@{$_FILES['image']['tmp_name']};type=image/png;filename=tuitpix_".$R->screen_name.".png",
            );
            $code = $tmhOAuth->request('POST', $tmhOAuth->url("1/account/update_profile_image"),
                $params,
                true, // use auth
                true // multipart
            );
            if ($code == 200) tmhUtilities::pr(json_decode($tmhOAuth->response['response']));
            tmhUtilities::pr(htmlentities($tmhOAuth->response['response']));
            
            $code = $tmhOAuth->request('POST', $tmhOAuth->url('1/statuses/update'), array(
              'status' => 'I\'ve just made my pixel art avatar with @tuitpix! Check it here http://tuitpix.com/i/'.$R->screen_name.'.png'
            ));
            
            if ($code == 200) tmhUtilities::pr(json_decode($tmhOAuth->response['response']));
            tmhUtilities::pr(htmlentities($tmhOAuth->response['response']));
        }
        /*
         * twitter stuff
         */
    }

    $query = mysql_query("SELECT * FROM `".$table."` WHERE twid = '$twid'", $link);
    $arr = array();
    if ($query)
        while($row = mysql_fetch_array($query))
            $arr[] = $row;

    if ($arr[0]) {
        if (isset($gen)) $table = "index";
        $query = "UPDATE `".$table."` SET";
        if (isset($look )) $query.= " looking = ".$look .",";
        if (isset($sex  )) $query.= " sex     = ".$sex  .",";
        if (isset($gen  )) $query.= " gen     = '".$gen  ."',";
        if (isset($hair )) $query.= " hair    = '".$hair ."',";
        if (isset($beard)) $query.= " beard   = '".$beard."',";
        if (isset($wear )) $query.= " wear    = '".$wear ."',";
        if (isset($addon)) $query.= " addon   = '".$addon."',";
        if (isset($img  )) $query.= " img     = '".$img."',";
        $query = substr($query,0,-1);
        $query.= " WHERE twid = '".$twid."'";
        $query = mysql_query($query, $link);
        if ($query) echo "Your configuration has been updated :)";
    } else {
        if ($table == "index") {
            $query = "INSERT INTO `".$table."` ( twid, looking, sex, gen, hair, beard, wear, addon, img ) ";
            $query.= "VALUES ( '".$twid."', ".$look.", ".$sex.", '".$gen."', '".$hair."', '".$beard."', '".$wear."', '".$addon."', '".$img."' )";
            $query = mysql_query($query, $link);
            if ($query) echo "Welcome to Tuitpix!";
        } elseif ($table == "maker") {
            if (isset($gen)) $table = "index";
            $query = "INSERT INTO `".$table."` ( twid, ";
            if (isset($gen  )) { $hex = $gen;   $query.= " gen  "; }
            if (isset($hair )) { $hex = $hair;  $query.= " hair "; }
            if (isset($beard)) { $hex = $beard; $query.= " beard "; }
            if (isset($wear )) { $hex = $wear;  $query.= " wear "; }
            if (isset($addon)) { $hex = $addon; $query.= " addon "; }
            $query.= ") VALUES ( '".$twid."', '".$hex."' )";
            $query = mysql_query($query, $link);
            if ($query) echo "The new part has been restored.";
        }
    }
} else {
}
return;

?>