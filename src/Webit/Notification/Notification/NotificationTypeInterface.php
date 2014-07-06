<?php
namespace Webit\Notification\Notification;

use Webit\Notification\Recipient\RecipientProviderInterface;

/**
 * Interface NotificationTypeInterface
 *
 * @namespace Webit\Notification\Notification
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
interface NotificationTypeInterface
{
    /**
     * Returns notification's type name
     * 
     * @return string
     */
    public function getName();
    
    /**
     * @return RecipientProviderInterface
     */
    public function getRecipientProvider();
    
    /**
     * 
     * @param RecipientProviderInterface $recipientProvider
     */
    public function setRecipientProvider(RecipientProviderInterface $recipientProvider = null);
    
    /**
     * 
     * @param boolean $media
     */
    public function getNotificationEnabled($media);
    
    /**
     * 
     * @param string $media
     * @param boolean $enabled
     */
    public function setNotificationEnabled($media, $enabled);
    
    /**
     * 
     * @param string $media
     * @return int
     */
    public function getNotificationInterval($media);
    
    /**
     * 
     * @param string $media
     * @param integer $interval
     */
    public function setNotificationInterval($media, $interval);
}
