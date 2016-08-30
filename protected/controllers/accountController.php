<?php

class AccountController extends Controller implements IAccountService
{   
    public function actionTest(){
        //$id = 3;           
        //$resultAccount = self::getAccountDetailsByID($id);
        
        //$username = "admin";           
        //$resultAccount1 = self::getAccountDetailsByUserName($username);
        
        
        //$cond = array('condition'=>"idAccount >= :id", 'params'=>array(":id"=>1));   
        //$resultAccount = self::getMatchesByConditions($cond);
        
        $username = "test";
        $password = "test";
        
        //$d = array('EmailRecovery'=>'ciccio.pasticcio@gmail.com', 'LastLoginIP'=>'192.168.1.1');
        
        //$resultAccount = self::setAccountDetailsByUserName($username, $password, $d);
        
        $resultAccount2 = self::login($username, $password);
        //$resultAccount2 = self::setUserPasswordByUserName($username, $password, "test2");
        
        echo "<pre>";
        //print_r($resultAccount1);
        //echo "\n\n";
        print_r($resultAccount2);
        echo "\n\n";
        echo password_hash($password, PASSWORD_DEFAULT);
        //print_r($_SERVER);
        echo "</pre>";
    }
    
    public function actions()
    {
        return array(
            'dbservice'=>array(
                'class'=>'CWebServiceAction',
            ),
            'classMap'=>array(
                'Result'=>'Result',
            ),
        );
    }

    /**
     * @param int The ID of The Account
     * @return Result
     * @soap
     */
    public static function getAccountDetailsByID($id) {
        $dal = new AccountDAL();
        $bll = new AccountServiceBLL($dal);
        return $bll->getAccountDetailsByIDBLL($id);
    }
    
    /**
     * @param string The UserName of The Account
     * @return Result
     * @soap
     */
    public static function getAccountDetailsByUserName($username) {
        $dal = new AccountDAL();
        $bll = new AccountServiceBLL($dal);
        return  $bll->getAccountDetailsBLL($username);
    }

    
    
    /**
     * @param string The UserName of The Account
     * @param Account
     * @return Result
     * @soap
     */
    public static function setAccountDetailsByUserName($username, $password, $data) {
        $dal = new AccountDAL();
        $bll = new AccountServiceBLL($dal);
        return $bll->setAccountDetailsByUserNameBLL($username, $password, $data);
    }
    
    /**
     * @param string UserName to evaluate
     * @param string Password to evaluate
     * @return Result
     * @soap
     */
    public static function login($username, $password) {
        $dal = new AccountDAL();
        $bll = new AccountServiceBLL($dal);
        return $bll->loginBLL($username, $password);
    }

    public static function setUserPasswordByUserName($username, $oldPwd, $newPwd){
        $dal = new AccountDAL();
        $bll = new AccountServiceBLL($dal);
        return $bll->setUserPasswordBLL($username, $oldPwd, $newPwd);
    }
    
    
    public static function getMatchesByConditions($conditions) {
        $dal = new AccountDAL();
        $bll = new AccountServiceBLL($dal);
        return $bll->getMatchesByConditionBLL($conditions);
    }

}