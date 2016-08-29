<?php

class AccountController extends Controller implements IAccountService
{   
    public function actionTest(){
        //$id = 3;           
        //$resultAccount = self::getAccountDetailsByID($id);
        
        //$username = "admin2";           
        //$resultAccount = self::getAccountDetailsByUserName($username);
        
        //$cond = array('condition'=>"idAccount >= :id", 'params'=>array(":id"=>1));   
        //$resultAccount = self::getMatchesByConditions($cond);
        
        //$username = "lpaglionico";
        //$password = "semABC123";
        
        //$d = array('EmailRecovery'=>'ciccio.pasticcio@gmail.com', 'LastLoginIP'=>'192.168.1.1');
        
        //$resultAccount = self::setAccountDetailsByUserName($username, $password, $d);
        
        //$resultAccount = self::isUserLoggable($username, $password);
        
        echo "<pre>";
        //print_r($resultAccount);
        echo "\n\n";
        //echo password_hash($password, PASSWORD_DEFAULT);
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
        return  AccountServiceBLL::getAccountDetailsByUserNameBLL($username);
    }

    
    
    /**
     * @param string The UserName of The Account
     * @param Account
     * @return Result
     * @soap
     */
    public static function setAccountDetailsByUserName($username, $password, $data) {
        return AccountServiceBLL::setAccountDetailsByUserNameBLL($username, $password, $data);
    }
    
    /**
     * @param string UserName to evaluate
     * @param string Password to evaluate
     * @return Result
     * @soap
     */
    public static function isUserLoggable($username, $password) {
        return AccountServiceBLL::isUserLoggableBLL($username, $password);
    }

    
    
    public static function getMatchesByConditions($conditions) {
        return AccountServiceBLL::getMatchesByConditionBLL($conditions);
    }

}