<?php
if ($_GET['randomId'] != "dxhPhDNgavOKdje3bSqDX28CyONWiVToD9jK0RTQ6asJU3DH3VQmPuNERyv5CGez") {
    echo "Access Denied";
    exit();
}

// display the HTML code:
echo stripslashes($_POST['wproPreviewHTML']);

?>  
