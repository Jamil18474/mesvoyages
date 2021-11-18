<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Tests;

use App\Entity\Visite;
use PHPUnit\Framework\TestCase;

/**
 * Description of VisiteTest
 *
 * @author Jamil
 */
class VisiteTest extends TestCase {
    
    public function testGetDatecreationString() {
        $visite = new Visite();
        $visite->setDatecreation(new \DateTime("2021-06-26"));
        $this->assertEquals("26/06/2021", $visite->getDatecreationString());
    }
}
