<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Result
 *
 * @author Genzo Hikari
 */
class Result {
    /**
     * @var string[] Errors
     * @soap
     */
    public $errors = array();
    /**
     * @var string[] Warnings
     * @soap
     */
    public $warnings = array();
    /**
     * @var string[] Messages
     * @soap
     */
    public $messages = array();
    /**
     * @var boolean Ststus of Operation 
     * @soap
     */
    public $success = false;
    /**
     * @var mixed Data
     * @soap
     */
    public $data = array();
    
    private static $classNS = "components.Result";    

    function Result(){
        $level = "info";
        $category = self::$classNS.".Result()";
        $msg = "Result Construction ...";
        Yii::log($msg, $level, $category);
        $msg = "Result object successfully constructed!";
        Yii::log($msg, $level, $category);       
    }
    
    public function addData($dataList){
        $level = "info";
        $category = self::$classNS.".addData()";
        try{
            $msg = "Adding ".count($dataList)." items ...";
            Yii::log($msg, $level, $category);
            
            $count = 0;
            foreach($dataList as $dataItem){
                $count++;
                $msg = "Cloning for item ".$count." ...";
                Yii::log($msg, $level, $category);
                
                $tmp = clone $dataItem;                
                                
                $msg = "Cloning done!";
                Yii::log($msg, $level, $category);
                
                array_push($this->data, $tmp);
                
                $msg = "Item successfully added to results!";
                Yii::log($msg, $level, $category);
            }
            $msg = "Added ".count($dataList)." items successfully!";
            Yii::log($msg, $level, $category);
            
            $this->success = true;
        }
        catch(Exception $e){
            $this->success = false;
            $msg = "ServiceError: [Result] - Error During result composing. Exception Occurred:\n".$e->getMessage();            
            array_push($this->data, $msg);
            
            Yii::log("Exception Occurred:\n".$e->getMessage(), "error", $category);
        }
    }
    
    public function addData($dataList, $atts2Hide){
        $level = "info";
        $category = self::$classNS.".addData()";
        try{
            $msg = "Adding ".count($dataList)." items ...";
            Yii::log($msg, $level, $category);
            
            $count = 0;
            foreach($dataList as $dataItem){
                $count++;
                $msg = "Cloning and attributes hiding for item ".$count." ...";
                Yii::log($msg, $level, $category);
                
                $tmp = clone $dataItem;
                if(isset($atts2Hide) && !empty($atts2Hide)){
                  foreach($atts2Hide as $toUnset){
                        unset($tmp->$toUnset);
                    }  
                }
                                
                $msg = "Cloning and attributes hiding done!";
                Yii::log($msg, $level, $category);
                
                array_push($this->data, $tmp);
                
                $msg = "Purged item successfully added to results!";
                Yii::log($msg, $level, $category);
            }
            $msg = "Added ".count($dataList)." items successfully!";
            Yii::log($msg, $level, $category);
            
            $this->success = true;
        }
        catch(Exception $e){
            $this->success = false;
            $msg = "ServiceError: [Result] - Error During result composing. Exception Occurred:\n".$e->getMessage();            
            array_push($this->data, $msg);
            
            Yii::log("Exception Occurred:\n".$e->getMessage(), "error", $category);
        }
    }
    public function clearData(){
        $this->data = array();
    }
    
    public function addMessage($msg){
        array_push($this->messages, $msg);
    }
    public function addWarning($warning){
        array_push($this->warnings, $warning);
    }
    public function addError($error){
       array_push($this->errors, $error);
    }
}
