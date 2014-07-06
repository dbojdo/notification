<?php
namespace Webit\Notification\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Webit\Notification\Event\NotificationSendEvent;
use Webit\Notification\Log\NotificationLogRepositoryInterface;
use Webit\Notification\Event\Events;

class NotificationSendLoggerListener implements EventSubscriberInterface
{
    /**
     * 
     * @var NotificationLogRepositoryInterface
     */
    private $notificationLogRepo;

    public function __construct(NotificationLogRepositoryInterface $notificationLogRepo)
    {
        $this->notificationLogRepo = $notificationLogRepo;
    }
    
	/**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
	public function getSubscribedEvents() {
		return array(Events::POST_NOTIFCATION_SEND => 'onNotificationSend');
	}

	/**
	 * 
	 * @param NotificationSendEvent $event
	 * @param string $eventName
	 * @param EventDispatcherInterface $ed
	 */
	public function onNotificationSend(NotificationSendEvent $event, $eventName, EventDispatcherInterface $ed)
	{
	    $notification = $event->getNotification();
	    $recipient = $event->getRecipient();
	    $preventSend = $event->getPreventSend();

	    if ($preventSend) {
	        return;
	    }
	    
	    $log = $this->notificationLogRepo->createNotificationLog();
    	    $log->setMedia($event->getMedia());
    	    $log->setRecipientIdentity($recipient->getIdentity());
    	    $log->setNotificationTypeName($notification->getType());
    	    $log->setNotificationHash($notification->getHash());
    	
        $this->notificationLogRepo->persistNotifiationLog($log);
	}
}