<?php
namespace Webit\Notification\Recipient;

/**
 * Interface RecipientPhoneInterface
 * 
 * @namespace Webit\Notification\Recipient
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
interface RecipientPhoneInterface extends RecipientInterface
{
    /**
     * @return string
     */
    public function getName();
    
    /**
     * 
     * @param string $name
     */
    public function setName($name);
    
    /**
     * @return string
     */
    public function getPhoneNo();
    
    /**
     * 
     * @param string $phoneNo
     */
    public function setPhoneNo($phoneNo);
}
