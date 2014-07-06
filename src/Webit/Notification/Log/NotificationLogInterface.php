<?php
namespace Webit\Notification\Log;

use Webit\Notification\Recipient\RecipientInterface;
use Webit\Notification\Notification\NotificationInterface;

/**
 * Interface NotificationLogInterface
 *
 * @namespace Webit\Notification\Log
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
interface NotificationLogInterface
{

    /**
     * @return \DateTime
     */
    public function getDate();
    
    /**
     * @return string
     */
    public function getNotificationTypeName();
    
    /**
     * 
     * @param string $notificationTypeName
     */
    public function setNotificationTypeName($notificationTypeName);
    
    /**
     * @return string
     */
    public function getMedia();
    
    /**
     * 
     * @param string $media
     */
    public function setMedia($media);
    
    /**
     * @return string
     */
    public function getNotificationHash();
    
    /**
     * 
     * @param string $notificationHash
     */
    public function setNotificationHash($notificationHash);
    
    /**
     * @return mixed
     */
    public function getRecipientIdentity();
    
    /**
     * 
     * @param string $recipientIdentity
     */
    public function setRecipientIdentity($recipientIdentity);
}
