<?php

function render($view,$params = [])
{
    return app()->get('view')->renderView($view,$params);
}


function redirect($path)
{
    return app()->get('view')->redirect($path);
}


function setLayout($layout){
    app()->get('view')->setLayout($layout);
}
