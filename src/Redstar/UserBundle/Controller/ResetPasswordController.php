<?php

namespace Redstar\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Redstar\UserBundle\Entity\User;
use Redstar\UserBundle\Form\ForgotPasswordType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResetPasswordController extends Controller
{
       
    public function forgotPasswordAction(Request $request)
    {
        $form = $this->createForm($this->get('redstar_user_forgot_password_form'));
        
        /* If the request is submitted: 
         * 1.Check if the email is valid.
         * 2.Check if the user has already request the maximum number of 
         *   request defined in the configuration..
         */
        if($request->getMethod() === Request::METHOD_POST)
        {
            $form->handleRequest($request);
            $data = $form->getData();
            
            if($form->isValid())
            {
                $user = $this->getDoctrine()->getRepository('Redstar\UserBundle\Entity\User')->findOneBy(array(
                    'email'=>$data['email']
                ));
                /*
                 * Check if there is a user with that emailaddress.
                 */
                if(null === $user){
                    $form->addError(new FormError('User not found'));
                }
                /*
                 * Checks if password reset request has expired.
                 */
                elseif(null !== $user && $user->isPasswordRequestNonExpired($this->container->getParameter('redstar_user_request_ttl'))){
                       return $this->render('RedstarUserBundle:ResetPassword:request-exceeded.html.twig');
                }
                /*
                 * Check if everything is fine and the request can continue.
                 */
                elseif(null !== $user && !$user->isPasswordRequestNonExpired($this->container->getParameter('redstar_user_request_ttl'))){
                    $token = $this->get('redstar_user_generate_token')->generateToken();
                    $user->setConfirmationToken($token);
                    $user->setPasswordRequestedAt(new \DateTime());
                    $this->get('redstar_user_manager')->flushUser($user);
                   
                    /*
                     * Send the user a confirmation email with a confirmation link.
                     */
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Request Reset Password')
                        ->setFrom($this->getParameter('redstar_user_email_sender'))
                        ->setTo($user->getEmail())
                        ->setBody(
                                $this->renderView(
                                        'RedstarUserBundle:ResetPassword:_email-password-reset.html.twig', array(
                                            'user'=>$user,
                                        ))
                                );
                    $this->get('mailer')->send($message);
                    
                    return  $this->redirectToRoute('redstar_user_check_mail', array(
                        'email'=>$this->getObfuscatedEmail($user)
                    ));
                }
            }
        }
        
        return $this->render('RedstarUserBundle:ResetPassword:forgot-password.html.twig', array(
            'form'=>$form->createView()
        ));
    }
    
    public function checkMailAction(Request $request)
    {
         $email = $request->query->get('email');
        
        /*Checks if the user arrived here by a redirect from the forgot-password url and has not typed the url to be here.*/
        if(empty($email) && $request->headers->get('referer') !== $request->getSchemeAndHttpHost() . $request->getHost() . '/forgot-password')
        {
            return $this->redirectToRoute('redstar_user_forgot_password');
        }
        
        return $this->render('RedstarUserBundle:ResetPassword:check-mail.html.twig');
    }
    
    public function resetPasswordAction(Request $request, $token)
    {
        $user = $this->get('redstar_user_manager')->findUserBy(array(
                'confirmationToken' =>$token
        ));
        
        /*Check if there is a user with that token*/
        if(!$user instanceof UserInterface )
        {
           return $this->render('RedstarUserBundle:ResetPassword:invalid-token.html.twig');
        }
        
        /*Check if the confirmationToken has expired. If yes? set the confirmationToken to null.*/
        if(!$user->isPasswordRequestNonExpired($this->container->getParameter('redstar_user_token_expire_ttl'))){
            $user->setConfirmationToken(null);
            $this->get('redstar_user_manager')->flushUser($user);
            return $this->render('RedstarUserBundle:ResetPassword:invalid-token.html.twig');
        }
        
        /*
         * If user exists with the given token and the request has not expired yet, 
         * prepare reset-password 
         */
        $form = $this->createForm('reset_password');
        
        /* Pass the token as a hidden field for security check so
         * the username entered in the reset password form matches the token for that user.
         */
        $form->get('token')->setData($token);
        
        if($request->getMethod() == Request::METHOD_POST)
        {
            $form->handleRequest($request);
            
            if($form->isValid())
            {
                $data = $form->getData();
                /*Get the user by confirmationToken*/
                $user = $this->get('redstar_user_manager')->findUserBy(array(
                        'confirmationToken' =>$data['token']
                ));
                              
                /* Check if the token in the request does match the confirmationToken 
                 * in the database.
                 */
                if(null !== $user) {
                    $this->get('redstar_user_manager')->setUserPassword($user,$data['password']);
                    $user->setConfirmationToken(null);
                    $this->get('redstar_user_manager')->flushUser($user);
                    $this->addFlash('info', 'Password reset is succesful.');
                    return $this->redirectToRoute('redstar_security_login');
                } 
                
                /* If the token in the request does
                 * not match the confirmationToken in the database, add error to form
                 */
                elseif (null !== $user) {
                   return $this->render('RedstarUserBundle:ResetPassword:invalid-token.html.twig');
                } 
            }
            
            return $this->render('RedstarUserBundle:ResetPassword:reset-password.html.twig', array(
                'form'=>$form->createView()
            ));
        }
        
        
        
        return $this->render('RedstarUserBundle:ResetPassword:reset-password.html.twig', array(
            'form'=>$form->createView()
        ));
    }
    
    
    public function cancelResetPasswordAction($token)
    {
        $user = $this->get('redstar_user_manager')->findUserBy(array(
            'confirmationToken'=>$token
        ));
        
        if($user)
        {
            $user->setConfirmationToken(null);
            $this->get('redstar_user_manager')->flushUser($user);
        }
        elseif (!$user) 
        {
            return $this->render('RedstarUserBundle:ResetPassword:invalid-token.html.twig');
        }
        
        return $this->render('RedstarUserBundle:ResetPassword:cancel-reset-password.html.twig');
    }

    protected function getObfuscatedEmail(UserInterface $user)
    {
        $email = $user->getEmail();
        if (false !== $pos = strpos($email, '@')) {
            $email = '...' . substr($email, $pos);
        }
        return $email;
    }
    
    
    
   
}
