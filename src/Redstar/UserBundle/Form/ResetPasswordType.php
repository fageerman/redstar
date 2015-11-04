<?php

namespace Redstar\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Description of ForgotPasswordType
 *
 * @author Ferdinand Geerman
 */
class ResetPasswordType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
       
        $builder
                ->add('password', 'repeated', array(
                    'type'=>'password',
                    'invalid_message' => 'The password fields must match.',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => true,
                    'first_options'  => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat Password'),
                ))
                ->add('token','hidden')
                ->add('submit', 'submit', array('label'=>'Reset Password'));
    }
    
    public function getName()
    {
        return 'reset_password';
    }
}
