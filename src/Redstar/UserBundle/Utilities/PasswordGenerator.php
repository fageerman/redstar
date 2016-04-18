<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Redstar\UserBundle\Utilities;

/**
 * Description of PasswordGenerator
 *
 * @author Ferdinan Geerman
 */
class PasswordGenerator {
    
    
    private $password;
    
    function generatePpassword($length = 8) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $this->password = substr( str_shuffle( $chars ), 0, $length );
    return $this->password;
    }
    
}
