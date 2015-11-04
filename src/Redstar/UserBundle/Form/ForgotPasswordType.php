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
class ForgotPasswordType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
       
        $builder
                ->add('email','email', array(
                    'constraints'=> array(
                        new Email(),
                        new NotBlank()
                    )
                ))
                ->add('submit', 'submit', array('label'=>'Request New Password'));
    }
    
    public function getName()
    {
        return 'forgot_password';
    }
}
