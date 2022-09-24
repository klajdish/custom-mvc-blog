<?php
namespace Core;


class Validate{
    public const RULE_REQUIRED= 'required';
    public const RULE_EMAIL= 'email';
    public const RULE_EMAIL_UNIQUE= 'email_unique';
    public const RULE_MIN= 'min';
    public const RULE_MAX= 'max';
    public const RULE_MATCH= 'matched';
    public const RULE_IMAGE= 'image';

    public $errors;

    public function __construct(){

    }

    public function validate($rules,$params, $model=null){

        // var_dump($params);die;
        foreach($rules as $attribute => $rules){
            if(!isset($params[$attribute])){
                continue;
            }

            $value = $params[$attribute];

            foreach($rules as $rule){

                $ruleName = $rule;
                if(!is_string($ruleName)){
                    $ruleName = $rule[0];
                }

                if($ruleName === self::RULE_REQUIRED && !$value){
                    $this->addError($attribute, self::RULE_REQUIRED,$rule);
                }


                if($ruleName === self::RULE_EMAIL && !filter_var($value,FILTER_VALIDATE_EMAIL)){
                    $this->addError($attribute, self::RULE_EMAIL,$rule);
                }
                if(is_string($value)  && $ruleName === self::RULE_EMAIL_UNIQUE){
                
                    $id = $model->checkEmail($value);

                    if(isset($params['user_id']) && $id && ($id != $params['user_id'])){
                        $this->addError($attribute, self::RULE_EMAIL_UNIQUE,$rule);

                    }elseif(!isset($params['user_id']) && $id){

                        $this->addError($attribute, self::RULE_EMAIL_UNIQUE,$rule);
                    }
                }

                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min'] ){
                    $this->addError($attribute, self::RULE_MIN,$rule);
                }

                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max'] ){
                    $this->addError($attribute, self::RULE_MAX,$rule);
                }

                if($ruleName === self::RULE_MATCH && $value !== $params['password']){
                    $this->addError($attribute, self::RULE_MATCH,$rule);
                }

                if($ruleName === self::RULE_IMAGE && is_array($value)){
                    // var_dump($value);die;
                    $this->validateImage($value,$rule,$attribute);
                }
            }
            
        }
        // die;
        return empty($this->errors);

    }

    public function addError(string $attribute,  string $rule, $params){


        $message = $this->errorMessages()[$rule] ?? '';
        if(is_array($params) || is_object($params)){
            foreach($params as $key => $value){
                $message = str_replace("{{$key}}",$value,$message);
            }
        }
        $this->errors[$attribute][]= $message;
    }

    public function errorMessages(){
        return [
            self::RULE_REQUIRED => 'this field is required',
            self::RULE_EMAIL => 'this field must be valid email',
            self::RULE_EMAIL_UNIQUE => 'this email already exists',
            self::RULE_MIN => 'min length must be {min}',
            self::RULE_MAX => 'max length must be {max}',
            self::RULE_MATCH => 'the field must be the same as {match}',
            'RULE_VALID_EXTENSION' => "Upload valiid images. Only PNG and JPEG are allowed.",
            'RULE_FILE_SIZE' => "Image size exceeds 4MB",
            'RULE_FILE_DIMENSION' => "Image dimension should be within 300X200",

        ];
    }

    public function hasError($attribute){

        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute){
        return $this->errors[$attribute][0] ?? false;
    }


    public function validateImage($file,$rule,$attribute){

        $fileinfo = @getimagesize($file["tmp_name"]);
        $width = $fileinfo[0];
        $height = $fileinfo[1];
        
        $allowed_image_extension = array(
            "png",
            "jpg",
            "jpeg"
        );
        
        // Get image file extension
        $file_extension = pathinfo($file["name"], PATHINFO_EXTENSION);
        
        if (! in_array($file_extension, $allowed_image_extension)) {
            $this->addError($attribute, 'RULE_VALID_EXTENSION',$rule);
        }    
        else if (($file["size"] > 4000000)) {
            $this->addError($attribute, 'RULE_FILE_SIZE',$rule);
        }    
        else if ($width > "4000" || $height > "4000") {
            $this->addError($attribute, 'RULE_FILE_DIMENSION',$rule);
        }
       
    }
}