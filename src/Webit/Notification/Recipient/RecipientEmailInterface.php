<?php
namespace Webit\Notification\Recipient;

/**
 * Interface RecipientEmailInterface
 * 
 * @namespace Webit\Notification\Recipient
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
interface RecipientEmailInterface extends RecipientInterface
{
    /**
     * 
     * @return string
     */
    public function getName();
    
    /**
     * 
     * @param string $name
     */
    public function setName($name);
    
    /**
     * 
     * @return string
     */
    public function getEmail();
    
    /**
     * 
     * @param string $email
     */
    public function setEmail($email);
}
