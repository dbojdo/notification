<?php
namespace Webit\Notification\Recipient;

/**
 * Class Recipient
 *
 * @namespace Webit\Notification\Recipient
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class Recipient implements RecipientEmailInterface, RecipientPhoneInterface
{
    /**
     * 
     * @var string
     */
    private $name;
    
    /**
     *
     * @var string
     */
    private $phoneNo;
    
    /**
     * 
     * @var string
     */
    private $email;

    /**
     * 
     * @param string $name
     * @param string $email
     * @param string $phoneNo
     */
    public function __construct($name = null, $email = null, $phoneNo = null) {
        $this->setName($name);
        $this->setEmail($email);
        $this->setPhoneNo($phoneNo);
    }
    
    /**
     * 
     * @return string
     */
    public function getIdentity($media = null)
    {
       switch ($media) {
           case 'email':
               return $this->getEmail();
               break;
           case 'sms':
           case 'phone':
               return $this->getPhoneNo();
               break;
       }
       
       $data = sprintf('%s:%s:%s', $this->name, $this->email, $this->phoneNo);
       return hash('md5', $data);
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * 
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * 
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    /**
     * @return string
     */
    public function getPhoneNo()
    {
        return $this->phoneNo;
    }
    
    /**
     * 
     * @param string $phoneNo
     */
    public function setPhoneNo($phoneNo)
    {
        $this->phoneNo = $phoneNo;
    }
}