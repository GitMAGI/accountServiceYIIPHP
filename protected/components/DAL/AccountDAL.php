<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccountDAL
 *
 * @author Genzo Hikari
 */
class AccountDAL implements IAccountServiceDAL{
    private static $classNS = "components.DAL.AccountDAL";   
    
    //Get Primary key array($k=>$v)
    //$model->tableSchema->primaryKey;
    public function getPKByRecord($record){
        $level ="info";
        $category = self::$classNS.".getPKByRecord()";
        $pk = Account::model()->tableSchema->primaryKey;
        if(!is_array($pk) && count($pk)==1){
            $tmp = array();
            array_push($tmp, $pk);
            $pk = $tmp;
        }
        //Yii::log(print_r($pk, true), $level, $category);
        $pkData = array();
        foreach($pk as $p){
            if(isset($record[$p])){
                $pkData[$p] = $record[$p];
            }
            else{
                $msg = "Error occurred in ".$category."! Bad data PK retrieving. No $p found in the data record!";
                throw new Exception($msg);
            }
        }
        return $pkData;
    }
    
    public function getByConditions($conditions) {
        return Account::model()->findAll($conditions); 
    }
    public function getByAttributes($attributes) {
        return Account::model()->findAllByAttributes($attributes); 
    }

    public function insertByPK($data) {
        $category = self::$classNS.".updateByPK()";
        
        $model = new Account();
        foreach($data as $k=>$v){
            if($model->hasAttribute($k)){
                $model->$k = $v;
            }
            else{
                $msg = "Error occurred in ".$category."! Bad data object passed to DAL. No $k found in the data model!";
                throw new Exception($msg);
            }            
        }
        return $model->save();
    }

    public function updateByPK($pk, $data) {
        $level ="info";
        $category = self::$classNS.".updateByPK()";
        //Yii::log(print_r($pk, true), $level, $category);
        //Yii::log(print_r($data, true), $level, $category);
        $model = Account::model()->findByPk($pk);
        foreach($data as $k=>$v){            
            if($model->hasAttribute($k)){
                $model->$k = $v;
            }
            else{
                $msg = "Error occurred in ".$category."! Bad data object passed to DAL. No $k found in the data model!";
                throw new Exception($msg);
            }            
        }
        return $model->save();
    }    
    
}
