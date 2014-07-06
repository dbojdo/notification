<?php
namespace Webit\Notification\Event;

use Webit\Notification\Notification\NotificationInterface;
use Symfony\Component\EventDispatcher\Event;
use Webit\Notification\Recipient\RecipientInterface;

/**
 * Class NotificationSendEvent
 *
 * @namespace Webit\Notification\Event
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class NotificationSendEvent extends Event
{
    /**
     * 
     * @var NotificationInterface
     */
    private $notification;
    
    /**
     * 
     * @var RecipientInterface
     */
    private $recipient;
    
    /**
     * 
     * @var string
     */
    private $media;
    
    /**
     * 
     * @var bool
     */
    private $preventSend;
    
    /**
     * 
     * @param NotificationInterface $notification
     * @param RecipientInterface $recipient
     * @param bool $preventSend
     */
    public function __construct(NotificationInterface $notification, RecipientInterface $recipient, $media, $preventSend = false)
    {
        $this->notification = $notification;
        $this->recipient = $recipient;
        $this->media = $media;
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
     * @return RecipientInterface
     */
    public function getRecipient()
    {
        return $this->recipient;
    }
    
    /**
     * @return string
     */
    public function getMedia()
    {
        return $this->media;
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