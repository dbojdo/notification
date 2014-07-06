<?php
namespace Webit\Notification\Notification;

/**
 * Interface NotificationRegistryInterface
 *
 * @namespace Webit\Notification\Notification
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
interface NotificationTypeRegistryInterface
{
    /**
     * 
     * @param NotificationTypeInterface $notificationType
     */
    public function registerNotificationType(NotificationTypeInterface $notificationType);
    
    /**
     * 
     * @param string $name
     * @return NotificationTypeInterface
     */
    public function getNotificationType($name);
}
