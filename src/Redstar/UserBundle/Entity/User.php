<?php

namespace Redstar\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Redstar\UserBundle\Entity\User
 *
 * @ORM\Table(name="redstar_users")
 * @ORM\Entity(repositoryClass="Redstar\UserBundle\Entity\UserRepository")
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * Encrypted password. Must be persisted.
     * 
     * @ORM\Column(type="string", length=64)
     */
    private $password;
    
    /**
     * Plain password. Used for model validation. Must not be persisted.
     *
     * @var string
     */
    private $plainPassword;
    
    /**
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    protected $lastLogin;
    
    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * If there is a possibility for registration, enabled becomes true when the user 
     * has activated his/her account via the confirmation link in the 
     * email send to the user. Other wise this is true when creating a user.
     * @ORM\Column(type="boolean")
     */
    private $enabled;
    
    /**
     * Check whether a user is (intentionally) locked.
     * 
     * @ORM\Column(type="boolean")
     */
    private $locked;
    
    /**
     * Random string sent to the user email address in order to verify it
     *
     * @ORM\Column(name="confirmation_token", type="string", length=64, nullable=true)
     */
    private $confirmationToken; 
    
    
    /**
     * The password reset can only be requested twice (or to be defined in parameters.yml) in 24 hours.
     * @ORM\Column(name="password_requested_at", type="datetime", nullable=true)
     */
    protected $passwordRequestedAt;
    
    /**
     * The salt to use for hashing.
     * 
     * @ORM\Column(type="string", length=64)
    */
    private $salt;
    
    /*
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     *
     */
    
    /**
     *
     * @var type 
     */
    private $roles;
    
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $expired;
    
    /**
     * @ORM\Column(name="expires_at", type="datetime", nullable=true)
     */
    protected $expiresAt;
    
    
    public function __construct()
    {
        $this->enabled = true;
        $this->locked = false;
        $this->expired = false;
        $this->salt = md5(uniqid(null, true));
        $this->roles = new ArrayCollection();
    }
    
    /**
     * Serialize the user.
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->email,
            $this->enabled,
            $this->locked,
            $this->expired,
            $this->expiresAt,
            $this->salt,
        ));
    }

    /**
     * Unserialize the user.
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->email,
            $this->enabled,
            $this->locked,
            $this->expired,
            $this->expiresAt,
            $this->salt,
        ) = unserialize($serialized);
    }

    /************************GETTERS*****************************/

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }


    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        return $this->salt;
    }
    
    function getPlainPassword() {
        return $this->plainPassword;
    }
    
    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
       // return $this->roles->toArray();
        return array('ROLE_ADMIN');
    }
    
    public function eraseCredentials()
    {
        
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    function getLastLogin() {
        return $this->lastLogin;
    }

    function getConfirmationToken() {
        return $this->confirmationToken;
    }

    function getPasswordRequestedAt() {
        return $this->passwordRequestedAt;
    }

    public function isAccountNonExpired()
    {
        /*Expired is true*/
        if (true === $this->expired) {
            return false;
        }

        /*Expired is not null and expires_at is in the past*/
        if (null !== $this->expiresAt && $this->expiresAt->getTimestamp() < time()){
            return false;
        }
        
        return true;
    }

    public function isAccountNonLocked()
    {
        return !$this->locked;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    
    /************************SETTERS*****************************/
    
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }
    
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }
    
    public function setPlainPassword($plainPassword) {
        $this->plainPassword = $plainPassword;
    }

    public function setLastLogin($lastLogin) {
        $this->lastLogin = $lastLogin;
    }

    public function setLocked($locked) {
        $this->locked = $locked;
    }

    public function setConfirmationToken($confirmationToken) {
        $this->confirmationToken = $confirmationToken;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
    }

    public function setPasswordRequestedAt($passwordRequestedAt) {
        $this->passwordRequestedAt = $passwordRequestedAt;
    }

    public function setExpired($expired) {
        $this->expired = $expired;
    }

    public function setExpiresAt($expiresAt) {
        $this->expiresAt = $expiresAt;
    }
    
    public function isPasswordRequestNonExpired($ttl){
        return $this->getPasswordRequestedAt() instanceof \DateTime &&
               $this->getPasswordRequestedAt()->getTimestamp() + $ttl > time();
    }


}
