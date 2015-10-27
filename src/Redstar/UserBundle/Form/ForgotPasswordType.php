<?php

namespace Redstar\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of ForgotPasswordType
 *
 * @author Ferdinand Geerman
 */
class ForgotPasswordType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
       
        $builder
                ->add('email','email')
                ->add('submit', 'submit', array('attr'=>array('label'=>'Request Password Reset')));
    }
    
    public function getName()
    {
        return 'forgot_password';
    }
}
