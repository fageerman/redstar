<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Redstar\UserBundle\Utilities;

use Symfony\Component\Security\Core\Util\SecureRandom;

/**
 * Description of TokenGenerator
 *
 * @author Ferdinand Geerman
 */
class TokenGenerator {

    public function generateToken()
    {
        $generator= new SecureRandom();
        $random = $generator->nextBytes(16);
        
        return md5($random);
    }
}
