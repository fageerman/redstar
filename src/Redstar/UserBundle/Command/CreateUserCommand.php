<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Redstar\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;
use Symfony\Component\Validator\Constraints\NotBlank;
/**
 * Description of Command
 *
 * @author Ferdinand Geerman
 */
class CreateUserCommand extends ContainerAwareCommand 
{
    
    private $validator;
    private $helper;
    private $userRepo;
    
    protected function configure()
    {
        $this
            ->setName('user:create')
            ->setDescription('Create User')
            ->addOption(
                'pass',
                null,
                InputOption::VALUE_NONE,
                'If set, the task will yell in uppercase letters'
            )
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
       
        $em = $this->getContainer()->get('doctrine');
        $this->userRepo = $em->getRepository('RedstarUserBundle:User');
        
        $this->validator = $this->getContainer()->get('validator');
        
        $this->helper = $this->getHelper('question');

        
        $username = $this->Username($input, $output);
        $email = $this->Email($input, $output);
        
        $password = null;
        
         if(!$input->getOption('pass')){
            $password = $this->Password($input, $output);
         }
         else{
             $password = 'test'; //Generate password
         }
         
        $question4 = new ConfirmationQuestion('Are you sure you want to create this user?', false);
        if (!$this->helper->ask($input, $output, $question4)) {
            $output->writeln('User creation cancelled.');
            return;
        }
        
        $output->writeln('User with username \'' . $username .'\' is created.');
    }
    
    private function Email(InputInterface $input, OutputInterface $output)
    {
        $question2 = new Question('Email?');
        $email = $this->helper->ask($input, $output, $question2);
       
        if(count($this->validator->validateValue($email, new EmailConstraint())) > 0)
        {
           $output->writeln('Not a valid email.'); 
           $this->Email($input, $output);
        }
        if($this->userRepo->findByEmail($email)){
           $output->writeln('Email already in use.');
           $this->Email($input, $output);
        }
        
        return $email;
    }
    
    
    private function Username(InputInterface $input, OutputInterface $output)
    {
        $question1 = new Question('Username?');
        $username = $this->helper->ask($input, $output, $question1);
        if($this->userRepo->findByUsername($username)){
            $output->writeln('Username already exists.');
            $this->Username($input, $output);
        }
        return $username;
    }
    
    private function Password(InputInterface $input, OutputInterface $output)
    {
        $question3 = new Question('Password?');
        $question3->setHidden(true);
        $password = $this->helper->ask($input, $output, $question3);
        var_dump($this->validator->validateValue($password, new NotBlank()));
        if(count($this->validator->validateValue($password, new NotBlank())) > 0)
        {
            $output->writeln('Password can not be blank.');
            $this->Password($input, $output);
        }
        return $password;
    }
}
