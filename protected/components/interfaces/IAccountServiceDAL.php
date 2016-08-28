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
interface IAccountServiceDAL {
    public static function updateByPK($pk, $data);
    public static function insertByPK($data);
    public static function getByConditions($conditions);
    public static function getByAttributes($attributes);    
}
