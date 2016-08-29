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
        $category = self::$classNS.".getPKByRecord()";
        $pk = Account::model()->tableSchema->primaryKey;
        $pkData = array();
        foreach($pk as $p){
            if(isset($record[$p])){
                $pkData[$p] = $record[$p];
            }
            else{
                $msg = "Error occurred in ".$category."! Bad data PK retrievingL. No $p found in the data record!";
                throw new Exception($msg);
            }
        }
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
        $category = self::$classNS.".updateByPK()";
        
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
