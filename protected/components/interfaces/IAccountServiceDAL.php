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
    public function updateByPK($pk, $data);
    public function insertByPK($data);
    public function getByConditions($conditions);
    public function getByAttributes($attributes);    
}
