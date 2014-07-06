<?php
namespace Webit\Notification\Log;

use Webit\Notification\Recipient\RecipientInterface;
use Webit\Notification\Notification\NotificationInterface;

/**
 * Interface NotificationLogRepositoryInterface
 *
 * @namespace Webit\Notification\Log
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
interface NotificationLogRepositoryInterface
{
    /**
     * 
     * @return NotificationLogInterface
     */
    public function createNotificationLog();
    
    /**
     *
     * @param NotificationLogInterface $notificationLog
     */
    public function persistNotifiationLog(NotificationLogInterface $notificationLog);
    
    /**
     * 
     * @param NotificationInterface $notification
     * @param RecipientInterface $recipient
     * @return NotificationLogInterface
     */
    public function getLastNotification(NotificationInterface $notification, RecipientInterface $recipient);
}
