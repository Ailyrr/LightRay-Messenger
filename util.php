<?php

function init_php_session() : bool {
    if(!session_id()){

        session_start();
        session_regenerate_id();
        return true;
    }

    return false;
}

function clean_php_session() : void {
    session_unset();
    session_destroy();
    mysqli_close($conn);
    header("Location: index.php");

}

function is_logged() : bool {
    return true;
}

?>