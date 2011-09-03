<?

$R = array();
$style = "";
$load = "";
$leftmenu = "";
$rightmenu = "";
$user = "";

include 's/auth.php';
include 's/style.php';
include 's/bones.php';

if ($R) {
    $user.= $R->screen_name;
    $leftmenu.= '
                <div id="img_gen"   onClick="tuitpix.setActive(this)" class="active"></div>
                <div id="img_hair"  onClick="tuitpix.setActive(this)" ></div>
                <div id="img_beard" onClick="tuitpix.setActive(this)"></div>
                <div id="img_wear"  onClick="tuitpix.setActive(this)"></div>
                <div id="img_addon" onClick="tuitpix.setActive(this)"></div>
    ';
    $rightmenu.= '
                <div id="tw_logout"></div>
                <div id="img_save" onclick="tuitpix.GO()" title="Save"></div>
    ';
} else {
    $rightmenu.= '
        <div id="tw_login"></div>
        <div id="img_none" ></div>
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
        <meta name="description" content="Tuitpix's maker is a HTML5 tool to draw pixelated parts to for your custom avatar." />
        <meta name="keywords" content="Tuitpix HTML5 tool pixelart pixel profile avatar twitter draw" />
        <meta name="author" content="Daniel Rodriguez, http://sadasant.com/" />
        <link rel="shortcut icon" href="tuitpix.ico" />
        <link rel="stylesheet" type="text/css" media="screen" href="css/tuitpix.css">
        <style>
        <?=$style?>
        </style>
        <title>Tuitpix's Maker ~ Draw and save your own pixelated parts.</title>
    </head>
    <body>

        <div id="header">
            <h1 class="center">
                <div id="flag_vzla" title="Tuitpix en Español" class="<?=($lang == "esp")? "active" : "" ?>" ></div>
                <div id="logo" onClick="location.href=''" title="Tuitpix" ></div>
                <div id="logo_maker" onClick="location.href=''" class="sublogo" title="Tuitpix" ></div>
                <div id="flag_engl" title="Tuitpix in English" class="<?=($lang == "eng")? "active" : "" ?>" ></div>
            </h1>
        </div>

        <?=$B->menu()?>
        
        <div id="help">
            <div id="help_text">
                <span>
                <?=file_get_contents("help/".$lang."_maker_default.html")?>
                </span>
            </div>
        </div>

        <div id="content" class="center">
            <div id="left_menu">
                <?=$leftmenu?>
            </div>
                        
            <!-- canvas -->
            <div id="loading" style="display:none"></div>
            <canvas id="maker" width="301px" height="301px" title="Your custom part." ></canvas>
            <!-- canvas -->
            
            <div id="right_menu">
                <?=$rightmenu?>
                <div id="img_boy"  onClick="tuitpix.setGender()"   class="gen" ></div>
                <div id="img_brsh" onClick="tuitpix.setTool(this)" class="inuse" ></div>
                <div id="img_ersr" onClick="tuitpix.setTool(this)" ></div>
                <input id="colors" class="color_maker" value="#369aa9"/>
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
    <script src="js/tuitpix/maker.tuitpix.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/tuitpix/env.tuitpix.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jscolor/jscolor.js" type="text/javascript" charset="utf-8"></script>
    <script>
        tuitpix.location = "maker";
        setTimeout('tuitpix.help("default")',700);
        tuitpix.USER = "<?=$user?>";
        tuitpix.LANG = "<?=$lang?>";
        var LOAD = "";
    </script>
</html>
