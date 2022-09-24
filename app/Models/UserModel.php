<?php
namespace App\Models;
use Core\Model;
use Core\Validate;

class UserModel extends Model{
    

    public function __construct(){
        $this->tableName='users';
        $this->primaryKey='id';
        $this->name="firstname";
    }


    public function registerRules(){
        return[
            'firstname' => [Validate::RULE_REQUIRED],
            'lastname' => [Validate::RULE_REQUIRED],
            'email' => [Validate::RULE_REQUIRED, Validate::RULE_EMAIL, Validate::RULE_EMAIL_UNIQUE],
            'password' => [Validate::RULE_REQUIRED, [Validate::RULE_MIN, 'min' =>8], [Validate::RULE_MAX, 'max' => 24]],
            'confirmPassword' => [Validate::RULE_REQUIRED, [Validate::RULE_MATCH, 'match' => 'password']],
        ];
    }

    public function adminRegisterRules(){
        return[
            'role' => [Validate::RULE_REQUIRED],
            'firstname' => [Validate::RULE_REQUIRED],
            'lastname' => [Validate::RULE_REQUIRED],
            'email' => [Validate::RULE_REQUIRED, Validate::RULE_EMAIL, Validate::RULE_EMAIL_UNIQUE],
            'password' => [Validate::RULE_REQUIRED, [Validate::RULE_MIN, 'min' =>8], [Validate::RULE_MAX, 'max' => 24]],
            'confirmPassword' => [Validate::RULE_REQUIRED, [Validate::RULE_MATCH, 'match' => 'password']],
        ];
    }

    public function updateRules(){
        return[
            'role' => [Validate::RULE_REQUIRED],
            'firstname' => [Validate::RULE_REQUIRED],
            'lastname' => [Validate::RULE_REQUIRED],
            'email' => [Validate::RULE_REQUIRED, Validate::RULE_EMAIL, Validate::RULE_EMAIL_UNIQUE],
            'password' => [Validate::RULE_REQUIRED,[Validate::RULE_MIN, 'min' =>8], [Validate::RULE_MAX, 'max' => 24]],
        ];
    }

    public function loginRules(){
        return[
            'email' => [Validate::RULE_REQUIRED],
            'password' => [Validate::RULE_REQUIRED],
        ];
    }

    public function checkEmail($email){
        $user =$this->getWithCondition(['email'=>$email]);
        if($user){
            return $user[0]->id;
        }
        return false;
    }

    public function register($body){

        $user =$this->getWithCondition(['email'=>$body['email']]);
        if($user){
            return false;
        }

        unset($body['confirmPassword']);
        return $this->createRow($body);
    }


    public function update($id,$body){
        unset($body['user_id']);
        return $this->updateRow($id,$body);

    }

    public function delete($params){
        
        return $this->deleteRow($params);
    }



    public function login($body){
        $password = $body['password'];
        unset($body['password']);
        $user =$this->getWithCondition($body);

        if($user){
            if(password_verify($password, $user[0]->password)){
                return $user;
            }
        }
        return false;
    }
}