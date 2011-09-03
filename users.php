<?

$R = array();
$style = "";
$login = "";
$totw = "";
$load = "";
$user = "";
$FS = "";

include 's/auth.php';
include 's/style.php';
include 's/bones.php';

include 's/lock.php';

if ($R) {
    include 's/load.php';
    $user.= $R->screen_name;
} else {
}

$files = array();
if($dir = opendir('i')){
    while(($file = readdir($dir)) != false){
        if($file != "." && $file != ".." && $file != ".htaccess" && $file != "index.php" && $file != "index.html"){
            $user = explode(".",$file);
            $files[$user[0]] = filemtime("i/".$file);
        }
    }
}
arsort($files);
$jsval = "    USERS.push(";
foreach($files as $k => $v) {
        $jsval .= " '$k',";
}
$jsval = substr($jsval, 0, $jsval.length - 1);
$jsval.= ");";

$lang = ($_SESSION["lang"])? $_SESSION["lang"] : "eng";

$B = new Bones($_SERVER["SERVER_NAME"],$lang);

?>
<!DOCTYPE html>
<!-- sadasant :.~ -->
<!-- Go to http://sadasant.com/license.txt to read the license. -->

<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <meta name="description" content="Tuitpix is a free online HTML5 tool to configure, draw and publish pixelart avatars." />
        <meta name="keywords" content="Tuitpix online HTML5 tool pixelart pixel profile pictures avatars twitter" />
        <meta name="author" content="Daniel Rodriguez, http://sadasant.com/" />
        <link rel="shortcut icon" href="tuitpix.ico" />
        <link rel="stylesheet" type="text/css" media="screen" href="css/tuitpix.css">
        <style>
        <?=$style?>
        
        #help { position:relative; display:block; width:287px; height:auto; margin-left:14px; text-align:center; }
        </style>
        <title>Tuitpix.com ~ HTML5 tool to configure, draw and publish pixelart avatars.</title>
    </head>
    <body>
    
        <div id="header">
            <h1 onClick="location.href=''" class="center">
                <div id="logo" title="Tuitpix" ></div>
                <div id="logo_users" class="sublogo" title="Tuitpix" ></div>
            </h1>
        </div>
        
        <?=$B->menu()?>

        <div id="content" class="center">
            <div id="left_menu">
                    <div id="arrow_left"  class="float" onClick="" style="margin-left:14px;"></div>
            </div>
            
            <!-- canvas -->
            <canvas id="avatar" width="301px" height="301px" title="Is that you?" ></canvas>
            <!-- canvas -->
            
            <!-- <div id="colors"></div> -->
            <input id="colors" class="color" value="#0A0A0A"/>
            
            <div id="right_menu" >
                    <div id="arrow_right" class="float" onClick="" ></div>
            </div>

            <div id="help">
                <div id="help_text">
                    <span>
                    </span>
                </div>
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

        <script>
            var tuitpix = {};
            var USERS = [];
            <?=$jsval?>
        </script>
        <script src="js/jquery/jqueryv1.5.2.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/jquery/backgroundPosition.js" type="text/javascript" charset="utf-8"></script>
        <script src="http://platform.twitter.com/anywhere.js?id=Cq7JSjwGt6ie9IJQABKA&v=1" type="text/javascript"></script>
        <script type="text/javascript">
            /* MENU */
            $("#menu").hover( function() {
                if (!tuitpix.widgets.submenu) $("#menu").css({ backgroundPosition: "0px 0px" });
            }, function() {
                if (!tuitpix.widgets.submenu) $("#menu").css({ backgroundPosition: "0px -49px" });
            });
            $("#menu").click( function() {
                $("#menu").css({ backgroundPosition: "-49px 0px" });
                $("#submenu").fadeIn(140);
            });
            $("body").mouseup( function() {
                $("#menu").css({ backgroundPosition: "0px -49px" });
                $("#submenu").fadeOut(140);
            });

            var nUser = -1;
            function through_users(v) {
                if (v > 0) nUser = (nUser+v == USERS.length)? 0 : nUser + v;
                if (v < 0) nUser = (nUser == 0)? USERS.length-1 : nUser + v;
                $("canvas").css("background","url(i/"+USERS[nUser]+".png)");
                $("#help_text span").html((nUser+1)+'/'+USERS.length+' &nbsp;&nbsp; @'+USERS[nUser]+' &nbsp;&nbsp;&nbsp; <a href="http://tuitpix.com/i/'+USERS[nUser]+'.png">link&rarr;</a>');
                twttr.anywhere(function (T) {
                    T("#help_text").hovercards();
                });
            }

            $("#arrow_left").click(function () { through_users(-1) });
            $("#arrow_right").click(function () { through_users(1) });
            
            $("#arrow_right").click();
        </script>
    </body>
</html>
