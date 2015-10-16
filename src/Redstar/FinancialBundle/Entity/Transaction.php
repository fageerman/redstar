<?php

namespace Redstar\FinancialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="redstar_debit_credit")
 */
class Transaction
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;
    
    /**
     * @ORM\Column(type="string", lenght="256")
     */
    private $description;
    
    /**
     * 
     * @ORM\Column(name="transaction_type", type="decimal", precision="2")
     */
    private $transactionType;
    
    /**
     *
     * @ORM\Column(name="transaction_direction", type="string")
     */
    private $transactionDirection;
    
    /**
     * @ORM\Column(type="decimal", precision="2")
     */
    private $amount;
    
    /**
     * @ORM\Column(name="executed_by", type="string")
     */
    private $transactBy;
    
    
    
    
    
    
    
    

}
