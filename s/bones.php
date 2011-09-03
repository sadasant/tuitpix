<?

class Bones {
    var $lang,
        $site;
    
    function Bones ($site,$lang) {
        $this->lang = $lang;
    }

    function menu () {
        $lang  = ($this->lang == "eng");
        $index = ($lang)? "HTML5 tool to create pixel art avatars" : "Herramienta HTML5 para crear avatares pixel art";
        $maker = ($lang)? "Pixel Art Drawing Tool"  : "Herramienta de Dibujo Pixel Art";
        $about = ($lang)? "About Tuitpix" : "Sobre Tuitpix";
        $menu  = '
            <div id="menu">
                <div id="submenu">
                     <a href="index.php" title="Tuitpix ~ '.$index.'."><div id="submenu_index" ></div></a>
                     <a href="maker.php" title="Tuitpix\'s Maker ~ '.$maker.'."><div id="submenu_maker" ></div></a>
                     <a href="about.php" title="Tuitpix ~ '.$about.'."><div id="submenu_about" ></div></a>
                </div>
            </div>
        ';
        return $menu;
    }
        
}

?>
