<?php

namespace Redstar\SecurityBundle\EventListeners;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityRequestListener
{
    private $securityContext = null;
    private $user = null;
    
    public function __construct(SecurityContext $securityContext) {
        $this->securityContext = $securityContext;
    }


    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            // don't do anything if it's not the master request
            return;
        }
        $request = $event->getRequest();
        
        $token = $this->securityContext->getToken();
        if($token instanceof AnonymousToken){
            echo "user not logged in";
        }elseif($token instanceof UsernamePasswordToken){
            echo "user: " . $token->getUsername() . "\n\r";
            echo "role: " . $token->getRoles()[0]->getName();            
        }
    
        //$this->user = $this->securityContext->getToken()->getUser();
//        if ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
//            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
//            $response = new Response('auth');
//            $response->setStatusCode(200);
//            $event->setResponse($response);
//        }
//        else{
//            return;//$response = $response = new Response('not logged in');
//        }
        //var_dump($this->user);die;
        
        // Customize your response object to display the exception details
        

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
//        if ($exception instanceof HttpExceptionInterface) {
//            $response->setStatusCode($exception->getStatusCode());
//            $response->headers->replace($exception->getHeaders());
//        } else {
//            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
//        }

        // Send the modified response object to the event
        
    }
}