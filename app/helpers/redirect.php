<?php

function redirect($to)
{
    return header('Location: '.$to);
}

function setMessageAndRedirect($index, $message, $redirectTo)
{
    setFlash($index, $message); // sete a mensagem
    return redirect($redirectTo); // faz o redirecionamento 
}
