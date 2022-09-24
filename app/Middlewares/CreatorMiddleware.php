<?php
namespace App\Middlewares;



class CreatorMiddleware{

    public function execute()
    {
        if((!isLoggedIn() || (isLoggedIn()->role==3))){
            setFlash('middleware_error',"you can't access this page");
            redirect('/');        
        }
    }
}