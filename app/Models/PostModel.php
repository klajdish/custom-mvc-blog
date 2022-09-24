<?php
namespace App\Models;
use Core\Model;
use Core\Validate;

class PostModel extends Model{
    

    public function __construct(){
        $this->tableName='posts';
        $this->primaryKey='id';
        $this->name="title";

    }


    public function newPostRules(){
        return[
            'title' => [Validate::RULE_REQUIRED ,[Validate::RULE_MIN, 'min' =>4], [Validate::RULE_MAX, 'max' => 24]],
            'description' => [Validate::RULE_REQUIRED,[Validate::RULE_MIN, 'min' =>8], [Validate::RULE_MAX, 'max' => 400]],
            'image_path' => [Validate::RULE_REQUIRED,Validate::RULE_IMAGE],
        ];
    }

    public function getUpdateRules(){
        return[
            'title' => [Validate::RULE_REQUIRED ,[Validate::RULE_MIN, 'min' =>4], [Validate::RULE_MAX, 'max' => 24]],
            'description' => [Validate::RULE_REQUIRED,[Validate::RULE_MIN, 'min' =>8], [Validate::RULE_MAX, 'max' => 400]],
            'image_path' => [Validate::RULE_IMAGE],
        ];
    }

    public function addNewPost($body){
        
        return $this->createRow($body);
    }

    public function updatePost($id,$body){
        
        unset($body['id']);
        return $this->updateRow($id,$body);

    }

    public function delete($params){
        
        return $this->deleteRow($params);
    }
}