<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Genzo Hikari
 */
interface IAccountService {
    public static function getAccountDetailsByID($id);
    public static function getAccountDetailsByUserName($username);
    
    public static function setAccountDetailsByUserName($username, $password, $data);
    public static function login($username, $password);
    
    public static function getMatchesByConditions($conditions);
}
