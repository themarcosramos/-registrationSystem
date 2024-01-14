<?php


function setFlash($index, $message)
{
    // se não existe o index na flash  da sessão
    if (!isset($_SESSION['flash'][$index])) {

          //crio a sessão    
        $_SESSION['flash'][$index] = $message;
    }
}

function getFlash($index, $style = "color:red")
{

    if (isset($_SESSION['flash'][$index])) {

       
        $flash = $_SESSION['flash'][$index];
        unset($_SESSION['flash'][$index]);

        return "<span style='$style'>$flash</span>";
    }
}
