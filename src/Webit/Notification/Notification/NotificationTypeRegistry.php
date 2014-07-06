<?php
namespace Webit\Notification\Notification;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class NotificationRegistry
 *
 * @namespace Webit\Notification\Notification
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class NotificationTypeRegistry implements NotificationTypeRegistryInterface
{
    /**
     * 
     * @var ArrayCollection
     */
    private $notificationTypes;

    public function __construct()
    {
        $this->notificationTypes = new ArrayCollection();
    }
    
    /**
     * 
     * @param NotificationTypeInterface $notificationType
     */
    public function registerNotificationType(NotificationTypeInterface $notificationType)
    {
        $this->notificationTypes->set($notificationType->getName(), $notificationType);
    }
    
    /**
     * 
     * @param string $name
     * @return NotificationTypeInterface
     */
    public function getNotificationType($name)
    {
        return $this->notificationTypes->get($name);
    }
}
