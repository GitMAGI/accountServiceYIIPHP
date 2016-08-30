<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccountServiceBLL
 *
 * @author Genzo Hikari
 */
class AccountServiceBLL {
    private static $classNS = "components.BLL.AccountServiceBLL";        
    private static $attributesToHide = array('DigestPwd', 'updt_usrID', 'updt_date'); 
    private static $attributesToLock = array(
        'IDAccount', 
        'AccountExpires', 
        'AccountCreationDate', 
        'AccountLifeTime', 
        'UAC', 
        'PwdExpires', 
        'PwdLifeTime',
        'PwdUpdateDate',
        'PwdFailuresCount',
        'PwdMaxFailuresCount',
        'LastLoginDateTime',
        'LastLogoffDateTime',
        'LastLoginIP',
        'LastLoginMAC',
        'updt_date',
        'updt_usrID',        
        );
    
    private $dal;
    
    function __construct($idal){
        $this->dal = $idal;
    }
    
    // HIGH LEVEL APIs
    public function newAccountBLL($data){
        // 1. Create new Record
        // 2. Generate a Token
        // 3. Write Token into Token Table
        // 4. Send Token and Account ID by email (primary email)
    }
    public function activateAccountBLL($username, $token){
        
    }
    public function setAccountDetailsBLL($data, $username, $password){
        $result = $this->isUserLoggable($username, $password);
        if($result->success){
            $pk = $this->dal->getPKByRecord($result->data[0]);
            $result = $this->update($data, $pk, $result);
            if($result->success){
                $result = $this->read($username, $result);
            }
        }
        return $result;
    }
    public function getAccountDetailsBLL($username){
        return $this->read($username);
    }
    public function loginBLL($username, $password){
        $response = $this->isUserLoggable($username, $password);
        if($response->success){
            $response = $this->read($username, $response);
        }
        return $response;
    }
    public function setUserPasswordBLL($username, $pwdOld, $pwdNew){
        $result = $this->loginBLL($username, $pwdOld);
        
        $level = "info";
        $category = self::$classNS.".setUserPasswordBLL()";   
        //Yii::log(print_r($result->data[0], true), $level, $category);
        
        if($result->success){
            $pk = $this->dal->getPKByRecord($result->data[0]);
            //Yii::log(print_r($pk, true), $level, $category);
            $r = $this->read($username);
            if($r->success){
                $data = $r->data[0];
                $data['DigestPwd'] = $this->createDigest($pwdNew);
                $result = $this->update($data, $pk, $result);
                if($result->success){
                    $result = $this->read($username, $result);
                }
                $r = null;
            }                        
        }
        return $result;
    }
    
    // MEDIUM LEVEL APIs
    private function isUserLoggable($username, $password, &$response=null){
        $start = microtime(true);   
        
        $level = "info";
        $category = self::$classNS.".login()";        
        
        if($response == null){
            $response = new Result();
            //Write Log
            Yii::log("Response object built!", $level, $category);
        }
        $response->clearData();
        
        try{
            $attributes = array('UserName'=>$username);        
            Yii::log("Quering the storage through attributes: ".Lib::associativeArray2PlainText($attributes), $level, $category);
            $data = $this->dal->getByAttributes($attributes);
            
            $msg_ = isset($data) ? count($data)." Items!" : "Null - An error occurred!";
            Yii::log("Retrieved: ".$msg_, $level, $category);
            
            if(count($data) == 0){
                $t_dur = microtime(true) - $start;
                $t_dur_str = Lib::microtimeToHISmS($t_dur);

                $response->success = false;
                
                $response->addError("No $username Account found!");
                
                $response->addMessage("Operation time: ".$t_dur_str);

                Yii::log("Operation Completed in ".$t_dur_str, $level, $category);

                return $response;
            }
            
            $response = $this->checkUniqueRecord($data, $response);
            if(!$response->success){
                $t_dur = microtime(true) - $start;
                $t_dur_str = Lib::microtimeToHISmS($t_dur);

                $response->addMessage("Operation time: ".$t_dur_str);

                Yii::log("Operation Completed in ".$t_dur_str, $level, $category);

                return $response;
            }
            
            $response = $this->checkUACAccount($data[0], $response);
            if(!$response->success){
                $t_dur = microtime(true) - $start;
                $t_dur_str = Lib::microtimeToHISmS($t_dur);

                $response->addMessage("Operation time: ".$t_dur_str);

                Yii::log("Operation Completed in ".$t_dur_str, $level, $category);

                return $response;
            }
            if(!$this->checkPassword($password, $data[0]['DigestPwd'])){
                $t_dur = microtime(true) - $start;
                $t_dur_str = Lib::microtimeToHISmS($t_dur);

                $response->addMessage("Operation time: ".$t_dur_str);
                $response->addError("Password doesn't match!");
                $response->success = false;

                Yii::log("Operation Completed in ".$t_dur_str, $level, $category);

                return $response;
            }
            $response = $this->checkUACPassword($data[0], $response);
            if(!$response->success){
                $t_dur = microtime(true) - $start;
                $t_dur_str = Lib::microtimeToHISmS($t_dur);

                $response->addMessage("Operation time: ".$t_dur_str);

                Yii::log("Operation Completed in ".$t_dur_str, $level, $category);

                return $response;
            }
            
        }
        catch(Exception $ex){
            $msg = 'Error Occurred! '.$ex->getMessage();
            $response->success = false;
            $response->addError($msg);
            //Write Log
            Yii::log($msg, "error", $category);
        }
        
        $t_dur = microtime(true) - $start;
        $t_dur_str = Lib::microtimeToHISmS($t_dur);
        
        $response->addMessage("Operation time: ".$t_dur_str);
        
        Yii::log("Operation Completed in ".$t_dur_str, $level, $category);
        
        return $response;
    }
    private function read($username, &$response=null){
        $start = microtime(true);   
        
        $level = "info";
        $category = self::$classNS.".read()";        
        
        if($response == null){
            $response = new Result();
            //Write Log
            Yii::log("Response object built!", $level, $category);
        }
        $response->clearData();
        
        try{
            $attributes = array('UserName'=>$username);        
            Yii::log("Quering the storage through attributes: ".Lib::associativeArray2PlainText($attributes), $level, $category);
            $data = $this->dal->getByAttributes($attributes);
            
            $msg_ = isset($data) ? count($data)." Items!" : "Null - An error occurred!";
            Yii::log("Retrieved: ".$msg_, $level, $category);
            
            if(isset($data)){
                $response->addData($data, self::$attributesToHide);         
            }
        }
        catch(Exception $ex){
            $msg = 'Error Occurred! '.$ex->getMessage();
            $response->success = false;
            $response->addError($msg);
            //Write Log
            Yii::log($msg, "error", $category);
        }
        
        $t_dur = microtime(true) - $start;
        $t_dur_str = Lib::microtimeToHISmS($t_dur);
        
        $response->addMessage("Operation time: ".$t_dur_str);
        
        Yii::log("Operation Completed in ".$t_dur_str, $level, $category);
        
        return $response;
    }
    private function update($data, $pk, &$response=null){
        $start = microtime(true);   
        
        $level = "info";
        $category = self::$classNS.".update()";        
        
        if($response == null){
            $response = new Result();
            //Write Log
            Yii::log("Response object built!", $level, $category);
        }
        $response->clearData();
        
        try{
            // Filter data to write
            Yii::log(print_r($data, true), $level, $category);
            $tmp = $this->data2WriteFilter($data, self::$attributesToLock);
            $response->addWarning($tmp['warning']);
            $data_ = $tmp['data'];
            
            if($this->dal->updateByPK($pk, $data_)){
                $msg = "DB Row for ".Lib::associativeArray2PlainText($pk)." successfully updated!";
                Yii::log($msg, $level, $category);
                $response->addMessage($msg);
                $response->success = true;                             
            }
            else{
                $msg = 'Updating failed! '.'No DB Rows updated!';
                $response->success = false;
                $response->addError($msg);
                //Write Log
                Yii::log($msg, "error", $category);
            } 
        }
        catch(Exception $ex){
            $msg = 'Error Occurred! '.$ex->getMessage();
            $response->success = false;
            $response->addError($msg);
            //Write Log
            Yii::log($msg, "error", $category);
        }
        
        $t_dur = microtime(true) - $start;
        $t_dur_str = Lib::microtimeToHISmS($t_dur);
        
        $response->addMessage("Operation time: ".$t_dur_str);
        
        Yii::log("Operation Completed in ".$t_dur_str, $level, $category);
        
        return $response;
    }
    private function write($data, &$response=null){
        $start = microtime(true);   
        
        $level = "info";
        $category = self::$classNS.".write()";        
        
        if($response == null){
            $response = new Result();
            //Write Log
            Yii::log("Response object built!", $level, $category);
        }
        $response->clearData();
        
        try{
            // Filter data to write
            $tmp = $this->data2WriteFilter($data, self::$attributesToLock);
            $response->addWarning($tmp['warning']);
            $data_ = $tmp['data'];
            
            if($this->dal->insertByPK($data_)){
                $msg = "DB Row for successfully inserted!";
                Yii::log($msg, $level, $category);
                $response->addMessage($msg);
                $response->success = true;                             
            }
            else{
                $msg = 'Updating failed! '.'No DB Rows updated!';
                $response->success = false;
                $response->addError($msg);
                //Write Log
                Yii::log($msg, "error", $category);
            } 
        }
        catch(Exception $ex){
            $msg = 'Error Occurred! '.$ex->getMessage();
            $response->success = false;
            $response->addError($msg);
            //Write Log
            Yii::log($msg, "error", $category);
        }
        
        $t_dur = microtime(true) - $start;
        $t_dur_str = Lib::microtimeToHISmS($t_dur);
        
        $response->addMessage("Operation time: ".$t_dur_str);
        
        Yii::log("Operation Completed in ".$t_dur_str, $level, $category);
        
        return $response;
    }
    
    // LOW LEVEL APIs
    private function checkUniqueRecord($data, &$Result=null){
        $start = microtime(true);   
        
        $level = "info";
        $category = self::$classNS.".checkUniqueRecord()";   
        
        try{
            if(!isset($Result)){
                $Result = new Result();  
                //Write Log
                Yii::log("Response object built!", $level, $category);
            }
            
            if(isset($data) && is_array($data)){
                if(count($data)==0){
                    $msg = "No data feed to the function!";
                    $Result->success = false;
                    $Result->addError($msg);
                    //Write Log
                    Yii::log($msg, "error", $category);
                }
                if(count($data)>1){
                    $msg = "More than one record passed to the function!";
                    $Result->success = false;
                    $Result->addError($msg);
                    //Write Log
                    Yii::log($msg, "error", $category);
                }
                if(count($data)==1){
                    $Result->success = true;
                }
            }
            else{
                $msg = "Bad data for processing!";
                $Result->success = false;
                $Result->addError($msg);
                //Write Log
                Yii::log($msg, "error", $category);
            }
        } 
        catch (Exception $ex) {
            $msg = 'Error Occurred! '.$ex->getMessage();
            $Result->success = false;
            $Result->addError($msg);
            //Write Log
            Yii::log($msg, "error", $category);
        }
        
        $t_dur = microtime(true) - $start;
        $t_dur_str = Lib::microtimeToHISmS($t_dur);
        
        Yii::log("Operation Completed in ".$t_dur_str, $level, $category);
        
        return $Result;
    }
    private function checkUACAccount($data, &$Result=null){
        $start = microtime(true);   
        
        $level = "info";
        $category = self::$classNS.".checkUACAccount()";   
        
        try{
            if(!isset($Result)){
                $Result = new Result();  
                //Write Log
                Yii::log("Response object built!", $level, $category);
            }

            //Yii::log(print_r($data, true), $level, $category);
            
            //Check $data
            if(isset($data) && isset($data['UAC'])){
                switch($data['UAC']){
                    case 100:
                        // Account Expired
                        $msg = "The Account expired";
                        $Result->success = false;
                        $Result->addError($msg);
                        Yii::log($msg, $level, $category);
                        break;
                    case 110:
                        // Account locked
                        $msg = "The Account is locked";
                        $Result->success = false;
                        $Result->addError($msg);
                        Yii::log($msg, $level, $category);
                        break;
                    case 120:
                        // Account disabled
                        $msg = "The Account is disabled";
                        $Result->success = false;
                        $Result->addError($msg);
                        Yii::log($msg, $level, $category);
                        break;
                    case 130:
                        // Account Inactive
                        $msg = "The Account has to be activated";
                        $Result->success = false;
                        $Result->addError($msg);
                        Yii::log($msg, $level, $category);
                        break;
                    default:
                        $msg = "Account active!";
                        $Result->success = true;
                        $Result->addMessage($msg);
                        Yii::log($msg, $level, $category);
                        break; 
                }
            }
            else{
                $msg = "Bad data passed to the function!";
                $Result->success = false;
                $Result->addError($msg);
                Yii::log($msg, 'error', $category);
            }
        }
        catch (Exception $ex) {
            $msg = 'Error Occurred! '.$ex->getMessage();
            $Result->success = false;
            $Result->addError($msg);
            //Write Log
            Yii::log($msg, "error", $category);
        }
        
        $t_dur = microtime(true) - $start;
        $t_dur_str = Lib::microtimeToHISmS($t_dur);
        
        Yii::log("Operation Completed in ".$t_dur_str, $level, $category);
        
        return $Result;
    }
    private function checkUACPassword($data, &$Result=null){
        $start = microtime(true);   
        
        $level = "info";
        $category = self::$classNS.".checkUACPassword()";   
        
        try{
            if(!isset($Result)){
                $Result = new Result();  
                //Write Log
                Yii::log("Response object built!", $level, $category);
            }

            //Check $data
            if(isset($data) && isset($data['UAC'])){
                switch($data['UAC']){
                    case 210:
                        // Pwd Expired
                        $msg = "Password Expired!";
                        $Result->success = false;
                        $Result->addError($msg);
                        Yii::log($msg, $level, $category);
                        break;
                    case 211:
                        // Must change pwd next logon
                        $msg = "Password Must be Changed!";
                        $Result->success = false;
                        $Result->addError($msg);
                        Yii::log($msg, $level, $category);
                        break;
                    case 200:
                        $msg = "Password active!";
                        $Result->success = true;
                        $Result->addMessage($msg);
                        Yii::log($msg, $level, $category);
                        break;
                    default:
                        $msg = "Error! Unknown UAC!";
                        $Result->success = false;
                        $Result->addMessage($msg);
                        Yii::log($msg, $level, $category);
                        break;
                }
            }
            else{
                $msg = "Bad data passed to the function!";
                $Result->success = false;
                $Result->addError($msg);
                Yii::log($msg, 'error', $category);
            }
        }
        catch (Exception $ex) {
            $msg = 'Error Occurred! '.$ex->getMessage();
            $Result->success = false;
            $Result->addError($msg);
            //Write Log
            Yii::log($msg, "error", $category);
        }
        
        $t_dur = microtime(true) - $start;
        $t_dur_str = Lib::microtimeToHISmS($t_dur);
        
        Yii::log("Operation Completed in ".$t_dur_str, $level, $category);
        
        return $Result;
    }
    private function checkPassword($password, $DigestPwd){
        return password_verify($password, $DigestPwd);
    }
    private function createDigest($password){
        return password_hash($password, PASSWORD_DEFAULT);
    } 
    private function data2WriteFilter($data, $atts2Lock){
        $start = microtime(true);  
        
        $level = "info";
        $category = self::$classNS.".data2WriteFilter()";   
        
        $warnings = array();
        
        $data_ = array();
        if(isset($data)){
            foreach ($data as $key => $value) {
                if(!in_array($key, $atts2Lock)){
                    $data_[$key] = $value;
                }
                else{
                    $msg = "The attribute $key is not writeable. This request will be ignored!";
                    array_push($warnings, $msg);
                }
            } 
            $msg = "Filtered ".count($data_)." attributes.";
            Yii::log($msg, $level, $category);
        }
        else{
            $msg = 'Bad data passed to function '.'data2WriteFilter()';
            Yii::log("Bad data (null or not an array) passed to the function.", "error", $category);
            throw new Exception($msg);
        }
        
        $t_dur = microtime(true) - $start;
        $t_dur_str = Lib::microtimeToHISmS($t_dur);
        
        Yii::log("Operation Completed in ".$t_dur_str, $level, $category);
        
        return array("data"=>$data_, "warning"=>$warnings);
    }
    
}
