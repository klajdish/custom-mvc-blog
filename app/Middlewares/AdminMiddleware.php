<?php
namespace App\Middlewares;



class AdminMiddleware{

    public function execute()
    {    
        if(!isLoggedIn()){
            setFlash('middleware_error',"you can't access this page");
            redirect('/'); 
        }

        if(isLoggedIn() && isLoggedIn()->role != 1){
            setFlash('middleware_error',"you can't access this page");
            redirect('/admin');      
        }
    }
}