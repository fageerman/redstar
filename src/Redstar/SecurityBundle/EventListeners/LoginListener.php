<?php

namespace Redstar\SecurityBundle\EventListeners;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\EntityManager;

/**
 * Description of LoginListener
 *
 * @author Ferdinand Geerman
 */
class LoginListener {
    
/** @var \Symfony\Component\Security\Core\SecurityContext */
    private $securityContext;

    /** @var \Doctrine\ORM\EntityManager */
    private $em;

    /**
     * Constructor
     * 
     * @param SecurityContext $securityContext
     * @param Doctrine        $doctrine
     */
    public function __construct(SecurityContext $securityContext, EntityManager $doctrine)
    {
        $this->securityContext = $securityContext;
        $this->em              = $doctrine;
    }

    /**
     * Do the magic.
     * 
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        if ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
               
        }

        if ($this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
               
        }

        //Set the login time for the user.
        $user = $event->getAuthenticationToken()->getUser();
        $user->setLastLogin(new \DateTime());
        $this->em->flush();
    }
}
