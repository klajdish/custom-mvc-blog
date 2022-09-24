<?php
namespace App\Models;
use Core\Model;
use Core\Validate;

class CommentModel extends Model{
    

    public function __construct(){
        $this->tableName='comments';
        $this->primaryKey='id';
        $this->name="content";
    }

    public function commentRules(){
        return[
            'content' => [Validate::RULE_REQUIRED ,[Validate::RULE_MIN, 'min' =>1], [Validate::RULE_MAX, 'max' => 50]],
        ];
    }


    public function createComment($body){
        $body['post_id'] = $body['id'];
        $body['status'] = 0;
        unset($body['id']);
        return $this->createRow($body);
    }

    public function updateComment($id,$body){

        unset($body['id']);
        return $this->updateRow($id,$body);
    }

    public function delete($body){  
        return $this->deleteRow($body);
    }
}