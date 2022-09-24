<?php
namespace App\Models;
use Core\Model;
use Core\Validate;

class CategoryModel extends Model{
    

    public function __construct(){
        $this->tableName='categories';
        $this->primaryKey='id';
        $this->name="name";
    }

    public function newCategoryRules(){
        return[
            'name' => [Validate::RULE_REQUIRED ,[Validate::RULE_MIN, 'min' =>4], [Validate::RULE_MAX, 'max' => 24]],
            'description' => [Validate::RULE_REQUIRED ,[Validate::RULE_MIN, 'min' =>8], [Validate::RULE_MAX, 'max' => 400]],
        ];
    }

    public function updateCategoryRules(){
        return[
            'name' => [Validate::RULE_REQUIRED ,[Validate::RULE_MIN, 'min' =>4], [Validate::RULE_MAX, 'max' => 24]],
            'description' => [Validate::RULE_REQUIRED ,[Validate::RULE_MIN, 'min' =>8], [Validate::RULE_MAX, 'max' => 400]],
        ];
    }

    public function addNewCategory($body){
        
        return $this->createRow($body);
    }

    public function updateCategory($id,$body){
        unset($body['id']);
        return $this->updateRow($id,$body);

    }

    public function delete($params){
        
        return $this->deleteRow($params);
    }

}