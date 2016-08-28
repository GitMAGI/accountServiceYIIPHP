<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lib
 *
 * @author Genzo Hikari
 */
class Lib {
    public static function associativeArray2PlainText($array){
        $i = 0;
        $len = count($array);
        $result = "";
        foreach($array as $k=>$v){
            $result.= is_array($v) ? $k."=>"."mixed" : $k."=>".$v;
            if($i<$len-1){
                $result.=" | ";
            }
            $i++;
        }
        return $result;
    }
    public static function plainArray2PlainText($array){
        $i = 0;
        $len = count($array);
        $result = "";
        foreach($array as $data){
            $result.=$data;
            if($i<$len-1){
                $result.=" | ";
            }
            $i++;
        }
        return $result;
    }
    
    // Function to get the client IP address
    public static function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    
    public static function microtimeToHISmS($duration){
        $hours = sprintf("%02d", ($duration/60/60));
        $minutes = sprintf("%02d", ($duration/60)-$hours*60);
        $seconds = sprintf("%02d", $duration-$hours*60*60-$minutes*60);
        $milliseconds_ = explode('.', sprintf("%0.3f",$duration));
        $milliseconds = sprintf("%03d", ($milliseconds_[1]));
        
        $desc = "(hh:mm:ss.ms)";
        
        return $hours.":".$minutes.":".$seconds.".".$milliseconds." ".$desc;
    }
}
