<?php
namespace Webit\Notification\Notifier;

use Webit\Notification\Notifier\NotifierInterface;
use Webit\Notification\Notification\NotificationInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Webit\Notification\Event\NotifyEvent;
use Webit\Notification\Event\Events;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Webit\Notification\Event\NotificationSendEvent;
use Webit\Notification\Recipient\RecipientAwareInterface;
use Webit\Notification\Notification\NotificationTypeRegistryInterface;
use Webit\Notification\Event\NotificationSendExceptionEvent;

/**
 * Class Notifier
 *
 * @namespace Webit\Notification\Notifier
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class Notifier implements NotifierInterface
{
    /**
     * 
     * @var NotificationTypeRegistryInterface
     */
    private $notificationTypeRegistry;
    
    /**
     * 
     * @var EventDispatcherInterface 
     */
    private $eventDispatcher;
    
    /**
     * 
     * @var ArrayCollection
     */
    private $mediaAdapters;
    
    public function __construct(NotificationTypeRegistryInterface $notificationTypeRegistry, EventDispatcherInterface $eventDispatcher)
    {
        $this->notificationTypeRegistry = $notificationTypeRegistry;
        $this->eventDispatcher = $eventDispatcher;
        $this->mediaAdapters = new ArrayCollection();
    }
    
    /**
     * @param NotificationInterface $notification
     */
    public function sendNotification(NotificationInterface $notification)
    {
        $event = new NotifyEvent($notification);
        $this->eventDispatcher->dispatch(Events::PRE_NOTIFY, $event);
        
        if ($event->getPreventSend() == false) {
            $this->performSendNotification($notification);
        }
        
        $event = new NotifyEvent($notification, $event->getPreventSend());
        $this->eventDispatcher->dispatch(Events::POST_NOTIFY, $event);
    }
    
    /**
     * 
     * @param NotificationInterface $notification
     * @throws \RuntimeException
     */
    private function performSendNotification(NotificationInterface $notification)
    {
        /** @var NotifierMediaAdapterInterface $mediaAdapter */
        foreach ($this->mediaAdapters as $mediaAdapter) {
            $recipients = $this->getRecipients($notification, $mediaAdapter);
            
            /** @var RecipientInterface $recipient */
            foreach ($recipients as $recipient) {
                $event = new NotificationSendEvent($notification, $recipient, $mediaAdapter->getMedia());
                $this->eventDispatcher->dispatch(Events::PRE_NOTIFCATION_SEND, $event);
                
                if ($event->getPreventSend() == false) {
                    try {
                        $mediaAdapter->sendNotification($notification, $recipient);
                    } catch(\Exception $e) {
                        $event = new NotificationSendExceptionEvent($notification, $recipient, $e);
                        $this->eventDispatcher->dispatch(Events::ON_NOTIFICATION_SEND_EXCEPTION, $event);
                        continue;
                    }
                }
                
                $event = new NotificationSendEvent($notification, $recipient, $mediaAdapter->getMedia(), $event->getPreventSend());
                $this->eventDispatcher->dispatch(Events::POST_NOTIFCATION_SEND, $event);
            }
        }
    }
    
    /**
     * 
     * @param NotificationInterface $notification
     * @param NotifierMediaAdapterInterface $mediaAdapter
     * @throws \RuntimeException
     * @return ArrayCollection
     */
    private function getRecipients(NotificationInterface $notification, NotifierMediaAdapterInterface $mediaAdapter)
    {   
        $type = $this->notificationTypeRegistry->getNotificationType($notification->getType());
        if (is_null($type)) {
            throw new \RuntimeException(sprintf('Notification Type "%s" couln\'t be found in Registry.', $type));
        }
        
        $recipientProvider = $type->getRecipientProvider();

        if (is_null($recipientProvider) && ($notification instanceof RecipientAwareInterface) == false) {
            throw new \RuntimeException(
                sprintf(
                    'Notification "%s" of type "%s" must have defined recipient\'s provider or implement RecipientAwareInterface',
                    get_class($notification), $type->getName()
                )
            );
        }

        $recipients = new ArrayCollection();
        if ($notification instanceof RecipientAwareInterface) {
            $recipients = $notification->getRecipients($mediaAdapter->getMedia());
        }

        $providerdRecipients = $recipientProvider->getRecipients($notification, $mediaAdapter->getMedia());
        
        /** @var RecipientInterface $recipient */
        foreach ($providerdRecipients as $recipient) {
            $recipients->add($recipient);
        }
        
        return $recipients;
    }
    
    /**
     * @param NotifierMediaAdapterInterface $mediaAdapter
     */
    public function registerMediaAdapter(NotifierMediaAdapterInterface $mediaAdapter)
    {
        $this->mediaAdapters->set($mediaAdapter->getMedia(), $mediaAdapter);
    }
}
