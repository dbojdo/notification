<?php
namespace Webit\Notification\Event;

use Webit\Notification\Notification\NotificationInterface;
use Symfony\Component\EventDispatcher\Event;
use Webit\Notification\Recipient\RecipientInterface;

/**
 * Class NotificationSendExceptionEvent
 *
 * @namespace Webit\Notification\Event
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class NotificationSendExceptionEvent extends Event
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
     * @var \Exception
     */
    private $exception;
    
    /**
     * 
     * @param NotificationInterface $notification
     * @param RecipientInterface $recipient
     * @param \Exception $exception
     */
    public function __construct(NotificationInterface $notification, RecipientInterface $recipient, \Exception $exception)
    {
        $this->notification = $notification;
        $this->recipient = $recipient;
        $this->exception = $exception;
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
     * 
     * @return Exception
     */
    public function getException()
    {
        return $this->exception;
    }
}
