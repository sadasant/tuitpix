<?

$R = array();
$style = "";
$login = "";
$totw = "";
$load = "";
$user = "";
$controls = "";

include 's/auth.php';
include 's/style.php';
include 's/bones.php';
include 's/lock.php';

if ($R) {
    include 's/load.php';
    $user.= $R->screen_name;
    $totw.= '<div id="img_save" onclick="tuitpix.SAVE()"></div>
             <div id="tw_save" onclick="tuitpix.SAVE(1)"></div>
             <div id="img_none" ></div>
             <div id="img_none" ></div>
             <div id="tw_logout"></div>
    ';
} else {
    $totw.= '<div id="tw_login"></div>';
    $controls.='
                <div id="subsub">
                    <div id="arrow_left"  class="float" onClick="tuitpix.setSkin(1)" ></div>
                    <div id="arrow_right" class="float" onClick="tuitpix.setSkin(-1)" ></div>
                </div>
    ';
}

$lang = ($_SESSION["lang"])? $_SESSION["lang"] : "eng";

$B = new Bones($_SERVER["SERVER_NAME"],$lang);

?>
<!DOCTYPE html>
<!-- sadasant :.~ -->
<!-- Go to http://sadasant.com/license.txt to read the license. -->

<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <meta name="description" content="Tuitpix is a free online HTML5 tool to configure, draw and publish pixel art avatars." />
        <meta name="keywords" content="Tuitpix online HTML5 tool pixelart pixel profile pictures avatars twitter" />
        <meta name="author" content="Daniel Rodriguez, http://sadasant.com/" />
        <link rel="shortcut icon" href="tuitpix.ico" />
        <link rel="stylesheet" type="text/css" media="screen" href="css/tuitpix.css">
        <style>
        <?=$style?>
        </style>
        <title>Tuitpix.com ~ HTML5 tool to configure, draw and publish pixel art avatars.</title>
    </head>
    <body>
    
        <div id="header">
            <h1 class="center">
                <div id="flag_vzla" title="Tuitpix en Español" class="<?=($lang == "esp")? "active" : "" ?>" ></div>
                <div id="logo" onClick="location.href=''" title="Tuitpix" ></div>
                <div id="logo_index" onClick="location.href=''" class="sublogo" title="Tuitpix" ></div>
                <div id="flag_engl" title="Tuitpix in English" class="<?=($lang == "eng")? "active" : "" ?>" ></div>
            </h1>
        </div>
        
        <?=$B->menu()?>

        <div id="help">
            <div id="help_text">
                <span>
                <?=file_get_contents("help/".$lang."_index_default.html")?>
                </span>
            </div>
        </div>

        <div id="content" class="center">
            <div id="left_menu">
                <div id="img_gen"    onClick="tuitpix.setControls(this)" class="active"></div>
                <div id="img_hair"   onClick="tuitpix.setControls(this)" ></div>
                <div id="img_beard"  onClick="tuitpix.setControls(this)"></div>
                <div id="img_wear"   onClick="tuitpix.setControls(this)"></div>
                <div id="img_addon"  onClick="tuitpix.setControls(this)"></div>
            </div>
            
            <div id="controls">
                <div id="main">
                    <div id="arrow_left"  class="float" onClick="tuitpix.setPrev()" ></div>
                    <div id="arrow_right" class="float" onClick="tuitpix.setNext()" ></div>
                </div>
                <div id="sub">
                    <div id="arrow_left"  class="float" onClick="tuitpix.look(true)" ></div>
                    <div id="arrow_right" class="float" onClick="tuitpix.look(false)" ></div>
                </div>
                <?=$controls?>
            </div>
            
            <!-- canvas -->
            <div id="loading"></div>
            <canvas id="avatar" width="301px" height="301px"></canvas>
            <!-- canvas -->
            
            <!-- <div id="colors"></div> -->
            <input id="colors" class="color" value="#0A0A0A"/>
            
            <div id="right_menu" >
                <div id="img_down" onClick="tuitpix.READY();"></div>
                <?=$totw?>
            </div>
        </div>
        
        <div id="footer">
            <div id="quote">
                <div id="text">
                    <a href="http://twitter.com/tuitpix" class="twitter-follow-button" data-show-count="false">Follow @tuitpix</a><br/>
                    <script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
                    <br/>
                </div>
                <div class="center"><small>
                    &copy; 2011 <a href="http://sadasant.com/">Daniel Rodríguez</a> 
                </small></div>
            </div>
        </div>
    </body>
    <script src="js/jquery/jqueryv1.5.2.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery/backgroundPosition.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/on/json.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/tuitpix/des.tuitpix.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/tuitpix/des.env.tuitpix.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jscolor/jscolor.js" type="text/javascript" charset="utf-8"></script>
    <script>
        tuitpix.location = "index";
        setTimeout('tuitpix.help("default")',700);
        tuitpix.USER = "<?=$user?>";
        tuitpix.LANG = "<?=$lang?>";
        var LOAD = null;
        <?=$load?>
    </script>
</html>
