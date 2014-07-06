<?php
namespace Webit\Notification\Event;

use Webit\Notification\Notification\NotificationInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class NotifyEvent
 *
 * @namespace Webit\Notification\Event
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class NotifyEvent extends Event
{
    /**
     * 
     * @var NotificationInterface
     */
    private $notification;
    
    /**
     * 
     * @var bool
     */
    private $preventSend;
    
    /**
     * 
     * @param NotificationInterface $notification
     * @param string $preventSend
     */
    public function __construct(NotificationInterface $notification, $preventSend = false)
    {
        $this->notification = $notification;
        $this->setPreventSend($preventSend);
    }
    
    /**
     * 
     * @return NotificationInterface
     */
    public function getNotification()
    {
        return $this->notification;
    }
    
    /**
     * 
     * @return boolean
     */
    public function getPreventSend()
    {
        return $this->preventSend;
    }
    
    /**
     * 
     * @param bool $preventSend
     */
    public function setPreventSend($preventSend)
    {
        $this->preventSend = $preventSend;
    }
}