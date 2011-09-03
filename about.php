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

if ($R) {
    include 's/load.php';
    $user.= $R->screen_name;
    $totw.= '<div id="img_save" onclick="tuitpix.SAVE()"></div>
             <div id="tw_save" onclick="tuitpix.SAVE(1)"></div>
             <div id="img_none" ></div>
             <div id="img_none" ></div>
             <div id="tw_logout"></div>
    ';
    $FS.= '<iframe src="http://www.formspring.me/widget/view/tuitpix?&size=large&bgcolor=%23'.$R->profile_sidebar_fill_color.'&fgcolor=%23'.$R->profile_text_color.'" frameborder="0" scrolling="no" width="400" height="275" style="border:none;"><a href="http://www.formspring.me/tuitpix">http://www.formspring.me/tuitpix</a></iframe>';
} else {
    $totw.= '<div id="tw_login"></div>';
    $FS.= '<iframe src="http://www.formspring.me/widget/view/tuitpix?&size=large&bgcolor=%230A0A0A&fgcolor=%23555555" frameborder="0" scrolling="no" width="400" height="275" style="border:none;"><a href="http://www.formspring.me/tuitpix">http://www.formspring.me/tuitpix</a></iframe>';
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
        <meta name="description" content="Tuitpix is a free online HTML5 tool to configure, draw and publish pixelart avatars." />
        <meta name="keywords" content="Tuitpix online HTML5 tool pixelart pixel profile pictures avatars twitter" />
        <meta name="author" content="Daniel Rodriguez, http://sadasant.com/" />
        <link rel="shortcut icon" href="tuitpix.ico" />
        <link rel="stylesheet" type="text/css" media="screen" href="css/tuitpix.css">
        <style>
        <?=$style?>
        #help { position:relative; display:block; width:427px; height:auto; margin-left:-62px; text-align:justify; }
        #help img { margin-left:14px; }
        </style>
        <title>Tuitpix.com ~ HTML5 tool to configure, draw and publish pixelart avatars.</title>
        <script>
            function mailto(who,where){
                location.href="mailto:"+who+"@"+where;
            }
        </script>
    </head>
    <body>
    
        <div id="header">
            <h1 class="center">
                <div id="flag_vzla" title="Tuitpix en Español" class="<?=($lang == "esp")? "active" : "" ?>" ></div>
                <div id="logo" onClick="location.href=''" title="Tuitpix" ></div>
                <div id="logo_about" onClick="location.href=''" class="sublogo" title="Tuitpix" ></div>
                <div id="flag_engl" title="Tuitpix in English" class="<?=($lang == "eng")? "active" : "" ?>" ></div>
            </h1>
        </div>
        
        <?=$B->menu()?>

        <div id="content" class="center">
            <div id="help">
                <div id="help_text">
                    <span>
                        <? if ($lang == "eng") { ?>
                            <br/>
                            <center>
                                <b>About Tuitpix</b>
                            </center>
                            <img src="i/tuitpix.png" align=right width=140px/>
                            <br/>
                            <b>Menu:</b>
                            <ul>
                                <li><a href="#!GOAL">The Goal.</a></li>
                                <li><a href="#!METHOD">Method.</a></li>
                                <li><a href="#!BACKLOG">Backlog.</a></li>
                                <li><a href="#!LICENSES">Licenses.</a></li>
                                <li><a href="#!FEEDBACK">Feedback.</a></li>
                            </ul>
                            <br/>
                            <div id="!GOAL"><br/><b>The Goal:</b></div>
                            <img src="i/sadasant.png" align=right width=140px />
                            <br/>
                            Tuitpix.com is a website made by @sadasant
                            during his studies on <em>canvas</em> and <em>image manipulations</em>. It's intended to be a free online tool
                            to configure, draw, save and publish <em>pixel art avatars</em> over <em>social networks</em>.
                            <br/><br/>
                            <div id="!METHOD"><br/><b>Method:</b></div>
                            <br/>
                            It has been developed and designed in a minimalist and fast way, using free opensource programs such as <em>GIMP</em>, <em>Aptana</em>, <em>VIM</em>, <em>Firefox</em> and <em>Chromium</em> over <em>GNU/Linux</em>, <em>HTML5</em>, <em>CSS3</em> and <em>JavaScript</em> for all the image-manipulations and some <em>PHP</em> code to the storing process and the social networks integration.
                            <br/><br/>
                            I (@sadasant) have to thank to all open knowledge, such as the posts made on blogs and forums about this technologies, like <a href="http://html5stars.com/?p=99">this post</a> about saving canvas on the server. I've also used third-party libraries, such as <em><a href="https://github.com/themattharris/tmhOAuth">tmhOAuth</a></em>, <em><a href="http://jquery.com">jQuery</a></em> and <em><a href="http://jscolor.com/">jsColor</a></em>.
                            <br/><br/>
                            Tuitpix is also available thanks to the testing process made with the next twitter users:
                            <br/><br/>
                            <center>
                                @schiapu @GeeketCarlos @AITBW
                            <br/>
                                @Rober_Vs @Jobliz @ThePurpleSong
                            <br/>
                                @WeAreGeek @joserojas
                            </center>
                            <br/>
                            If you like the site, please follow them, they're amazing people, and they've done a great work. Or do it for karma.
                            <br/><br/>
                            Finally, a big thanks to my family, for their patience, comprehension and support:
                            <br/><br/>
                            <center>
                                <a href="http://www.tecnosoluciones.com">TecnoSoluciones</a>
                            </center>
                            <br/>
                            <div id="!BACKLOG"><br/><b>Backlog:</b></div>
                            <br/>
                            <em>The messy list of things that should work:</em>
                            <ul>
                                <li>Generate all the canvas images with an external light-weight JSON.</li>
                                <li>Random skin changes when the <a href="index.php">main page</a> is loaded without a saved configuration.</li>
                                <li>Load JSON with all the list of parts and loop over them to change the selected section (gender, hair, facial hair, wear, add-ons).</li>
                                <li>In the <a href="index.php">main page</a>, right clicking on any pixel inside the canvas should prompt a color picker which should allow the user to change all the equal colors of the pixels on the selected part.</li>
                                <li>In the <a href="maker.php">maker</a>, right clicking on any pixel inside the canvas should change the brush color.</li>
                                <li>Show a help element near of every hovered button.</li>
                                <li>Connect with a twitter account and customize the pages with it's information.</li>
                                <li>Save the current configuration of parts on the server, as well as an image in an especific URL.</li>
                                <li>Save the current image on the twitter profile.</li>
                                <li>Draw your custom parts on the <a href="maker.php">maker</a> and use them on the <a href="index.php">main page</a>.</li>
                                <li>Do all the above even with the image flipped horizontally.</li>
                                <li>Change the language between English and Spanish.</li>
                                <li>Divide the parts by category.</li>
                            </ul>
                            <br/>
                            <em>Upcomming features:</em>
                            <ul>
                                <li>MOAR browser compatibility.</li>
                                <li>MOAR parts.</li>
                                <li>MOAR social networks.</li>
                                <li>I really want to make a canvas drawing open-source library, but give me time, I still have a lot to learn.</li>
                                <li>A "ctrl+z" in the maker.</li>
                            </ul>
                            <br/>
                            <center>Follow @tuitpix to get real-time updates!</center>
                            <br/><br/>
                            <div id="!LICENSES"><br/><b>Licenses:</b></div>
                            <br/>
                            All the programming codes in any form or type inside <a href="http://tuitpix.com/">tuitpix.com</a> that does not explicitly says that belongs to another license is under the next copyright:
                            <ul>
                                <li>Copyright &copy; 2011 Daniel Rodriguez [<a href="" onclick="mailto('djrs','sadasant');">send mail</a>]</li>
                                <li>MIT License [<a href="http://www.opensource.org/licenses/mit-license.php">view</a>]</li>
                            </ul>
                            <br/>
                            <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-sa/3.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/StillImage" property="dct:title" rel="dct:type">All the images, texts and interactive content that is or is not strictly asociated with the code, but belongs to the site tuitpix.com</span> is made by <a xmlns:cc="http://creativecommons.org/ns#" href="http://tuitpix.com/" property="cc:attributionName" rel="cc:attributionURL">Daniel Rodríguez</a>, and is licensed under a:<br/> <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License</a>.<br />Permissions beyond the scope of this license may be available at <a xmlns:cc="http://creativecommons.org/ns#" href="http://sadasant.com/" rel="cc:morePermissions">http://sadasant.com/</a>.
                            <br/>
                            <br/>
                            <div id="!FEEDBACK"><br/><b>Feedback:</b></div>
                        <? } else { ?>
                            <br/>
                            <center>
                                <b>Sobre Tuitpix</b>
                            </center>
                            <img src="i/tuitpix.png" align=right width=140px/>
                            <br/>
                            <b>Menu:</b>
                            <ul>
                                <li><a href="#!META">La Meta.</a></li>
                                <li><a href="#!METODO">El Método.</a></li>
                                <li><a href="#!PORHACER">Por hacer.</a></li>
                                <li><a href="#!LICENCIAS">Licencias.</a></li>
                                <li><a href="#!OPINION">Tu Opinión.</a></li>
                            </ul>
                            <br/>
                            <div id="!META"><br/><b>La Meta:</b></div>
                            <br/>
                            <img src="i/sadasant.png" align=right width=140px />
                            Tuitpix.com es un sitio web hecho por @sadasant
                            durante sus estudios sobre <em>la etiqueta canvas</em> y <em>manipulación de imágenes</em>. Está destinado a ser una herramienta gratis y en línea
                            para configurar, dibujar, salvar y publicar <em>imágenes de perfil al estilo pixel art</em> a través de las <em>redes sociales</em>.
                            <br/><br/>
                            <div id="!METODO"><br/><b>Method:</b></div>
                            <br/>
                            Esta herramienta está diseñada y desarrollada de una manera rápida y minimalista, haciendo uso de programas grátis y de código abierto, tales como <em>GIMP</em>, <em>Aptana</em>, <em>VIM</em>, <em>Firefox</em> y <em>Chromium</em> sobre <em>GNU/Linux</em>, <em>HTML5</em>, <em>CSS3</em> y <em>JavaScript</em> para el manejo de imágenes. Además del uso de <em>PHP</em> para distintos procesos de almacenamiento de configuraciones y la integración con las redes sociales.
                            <br/><br/>
                            Yo (@sadasant) tengo que agradecer a todo el conocimiento libre, tales como las publicaciones hechas en blogs sobre este tipo de tecnologías, como <a href="http://html5stars.com/?p=99">esta</a> que trata de una técnica para almacenar los datos de la etiqueta canvas en el servidor. También he utilizado librerías externas, tales como <em><a href="https://github.com/themattharris/tmhOAuth">tmhOAuth</a></em>, <em><a href="http://jquery.com">jQuery</a></em> y <em><a href="http://jscolor.com/">jsColor</a></em>.
                            <br/><br/>
                            Tuitpix también está disponible por la revisiones, consejo y apoyo constante de los siguientes usuarios:
                            <br/><br/>
                            <center>
                                @schiapu @GeeketCarlos @AITBW
                            <br/>
                                @Rober_Vs @Jobliz @ThePurpleSong
                            <br/>
                                @WeAreGeek @joserojas
                            </center>
                            <br/>
                            Si te gusta el sitio, por favor síguelos, son personas maravillosas y han hecho un muy buen trabajo. ¡Hazlo por el "karma"!
                            <br/><br/>
                            Finalmente, agradezco a mi familia por su paciencia, comprensión y soporte:
                            <br/><br/>
                            <center>
                                <a href="http://www.tecnosoluciones.com">TecnoSoluciones</a>
                            </center>
                            <br/>
                            <div id="!PORHACER"><br/><b>Por Hacer:</b></div>
                            <br/>
                            <em>La lista desordenada de cosas que Tuitpix debería poder hacer:</em>
                            <ul>
                                <li>Generar todas las imágenes y partes mediante una serie de JSONs ligeros.</li>
                                <li>Proveer de una configuración básica y variable cuando la <a href="index.php">página principal</a> es recargada sin una configuración guardada.</li>
                                <li>Cargar un JSON de partes y recorrerlo para cambiar el tipo de parte seleccionado (género, cabello, cabello facial, vestimenta y añadidos).</li>
                                <li>En la <a href="index.php">página principal</a>, hacer click derecho sobre cualquier parte del canvas debería mostrar un selector de color que permita al usuario cambiar los colores de las partes seleccionadas.</li>
                                <li>En la <a href="maker.php">herramienta de dibujo</a>, el click derecho debería permitir cambiar el color del pincel de dibujo.</li>
                                <li>Mostrar ayudas cerca de los botones.</li>
                                <li>Conectar con la cuenta de twitter y personalizar las páginas con la información del usuario.</li>
                                <li>Salvar la configuración del usuario en el servidor, así como la imagen en una URL particular.</li>
                                <li>Salvar la imagen actual en el perfil de twitter.</li>
                                <li>Permitir al usuario dibujar partes adicionales en la <a href="maker.php">herramienta de dibujo</a>, de manera que luego puedan ser usadas en la <a href="index.php">página principal</a>.</li>
                                <li>Hacer todo lo anterior pero con la imagen volteada horizontalmente.</li>
                                <li>Escoger entre los idiomas Ingles y Español.</li>
                                <li>Dividir las partes por categorías.</li>
                            </ul>
                            <br/>
                            <em>Próximas Características:</em>
                            <ul>
                                <li>Más compatibilidad entre navegadores.</li>
                                <li>Más partes.</li>
                                <li>Más redes sociales.</li>
                                <li>Quizás una librería para dibujar (tengo que aprender muchas cosas antes).</li>
                                <li>Un "ctrl+z" en la herramienta de dibujo.</li>
                            </ul>
                            <br/>
                            <center>¡Sigue a @tuitpix para obtener actualizaciones a tiempo real!</center>
                            <br/><br/>
                            <div id="!LICENCIAS"><br/><b>Licencias:</b></div>
                            <br/>
                            Todos los códigos de programación en todas sus formas que estén dentro de <a href="http://tuitpix.com/">tuitpix.com</a> y no pertenecen explícitamente a otra licencia, poseen el siguiente copyright:
                            <ul>
                                <li>Copyright &copy; 2011 Daniel Rodriguez [<a href="" onclick="mailto('djrs','sadasant');">send mail</a>]</li>
                                <li>Licencia MIT [<a href="http://www.opensource.org/licenses/mit-license.php">ver</a>]</li>
                            </ul>
                            <br/>
                            <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-sa/3.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/StillImage" property="dct:title" rel="dct:type">Todas las imágenes, texto y contenido interactivo que esté o no esté asociado estrictamente con el código, pero se encuentre dentro de tuitpix.com</span> fue hecho por <a xmlns:cc="http://creativecommons.org/ns#" href="http://tuitpix.com/" property="cc:attributionName" rel="cc:attributionURL">Daniel Rodríguez</a>, y está registrado por esta licencia:<br/> <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License</a>.<br />Otros permisos adicionales pueden ser requeridos en: <a xmlns:cc="http://creativecommons.org/ns#" href="http://sadasant.com/" rel="cc:morePermissions">http://sadasant.com/</a>.
                            <br/>
                            <br/>
                            <div id="!OPINION"><br/><b>Tu opinión:</b></div>
                        <? } ?>
                        <?=$FS?>
                    </span>
                </div>
            </div>
            <div id="footer">
                <div id="quote">
                   <div class="center">
                        <small>&copy; 2011 <a href="http://sadasant.com/">Daniel Rodríguez</a></small>
                        <br/>
                        <br/>
                    </div>
                </div>
            </div>
        </div>
        <script>var tuitpix = {};</script>
        <script src="js/jquery/jqueryv1.5.2.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/jquery/backgroundPosition.js" type="text/javascript" charset="utf-8"></script>
        <script src="http://platform.twitter.com/anywhere.js?id=Cq7JSjwGt6ie9IJQABKA&v=1" type="text/javascript"></script>
        <script type="text/javascript">
           twttr.anywhere(function (T) {
                T("#help_text").hovercards();
            });
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
            
            tuitpix.LANG = "<?=$lang?>";

            $('#flag_vzla').click( function () {
                if (tuitpix.LANG == "esp") return;
                $.get('s/lang.php',{ lang: "esp" },
                    function(){
                        window.location = "about.php";
                    }
                );
                $("#flag_engl").attr("class","");
                $("#flag_vzla").attr("class","active");
            });
            $('#flag_engl').click( function () {
                if (tuitpix.LANG == "eng") return;
                $.get('s/lang.php',{ lang: "eng" },
                    function(){
                        window.location = "about.php";
                    }
                );
                $("#flag_vzla").attr("class","");
                $("#flag_engl").attr("class","active");
            });

        </script>
    </body>
</html>
