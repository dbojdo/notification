<?php
namespace Webit\Notification\Notification;

/**
 * Interface NotificationInterface
 *
 * @namespace Webit\Notification\Notification
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
interface NotificationInterface
{
    /**
     * Returns notification's type name
     * 
     * @return string
     */
    public function getType();
    
    /**
     * Return notification's hash
     * 
     * @return string
     */
    public function getHash();
}
