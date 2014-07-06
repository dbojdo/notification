<?php
namespace Webit\Notification\Notifier;

use Webit\Notification\Notification\NotificationInterface;
use Webit\Notification\Recipient\RecipientInterface;

/**
 * Interface NotifierAdapterInterface
 *
 * @namespace Webit\Notification\Notifier
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
interface NotifierMediaAdapterInterface
{
    /**
     * @return string
     */
    public function getMedia();
    
    /**
     * 
     * @param NotificationInterface $notification
     * @param RecipientInterface $recipient
     */
    public function sendNotification(NotificationInterface $notification, RecipientInterface $recipient);
}
