<?php

//verifica se está logado 
function user()
{

    if (isset($_SESSION[LOGGED])) {
        return $_SESSION[LOGGED];
    }
}

// se exite a sesão ou não 
function logged(): bool
{
    return isset($_SESSION[LOGGED]);
}
