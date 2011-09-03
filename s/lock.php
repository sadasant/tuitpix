<?

if (!$_SESSION["unlock"]) {
    if(!$_POST["code"] || $_POST["code"] !== "R00fR00fR00f") {
        ?>
            <html>
                <head>
                    <title>Tuitpix's Cerberus</title>
                </head>
                <body>
                    <form action="" method="post" style="text-align:center">
                        <img src="img/lock.png"/ align="center"><br/>
                        <b style="letter-spacing:7px;font-size:14px;">GIMME THEH COED</b> <br/>
                        <input name="code" type="text" value=""/>
                    </form>
                </body>
            </html>
        <?    
        die();
    } else {
        $_SESSION["unlock"] = true;
    }
}

?>