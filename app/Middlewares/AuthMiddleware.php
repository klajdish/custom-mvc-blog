<?php
namespace App\Middlewares;



class AuthMiddleware{

    public function execute()
    {
        if(isLoggedIn()){
            setFlash('middleware_error',"you can't access this page");
            redirect('/');       
        }

        return false;

    }
}