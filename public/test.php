<?php
    if(isset($_GET['pw']) && isset($_GET['login'])){
     $pw = hash('sha512', $_GET['pw'] . $_GET['login']);
     echo "pw =" . $pw . "<br>" . $_GET['pw'] . "<br>" . $_GET['login'];
    }
    else {
        echo "et antanut arvoja ";
    }

?>
