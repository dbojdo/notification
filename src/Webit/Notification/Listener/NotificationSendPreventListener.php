<?php
namespace Webit\Notification\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Webit\Notification\Event\NotificationSendEvent;
use Webit\Notification\Log\NotificationLogRepositoryInterface;
use Webit\Notification\Notification\NotificationTypeRegistryInterface;
use Webit\Notification\Event\Events;

class NotificationSendPreventListener implements EventSubscriberInterface
{
    /**
     * 
     * @var NotificationLogRepositoryInterface
     */
    private $notificationLogRepo;
    
    /**
     * 
     * @var NotificationTypeRegistryInterface
     */
    private $notificationTypeRegistry;
    
    public function __construct(NotificationLogRepositoryInterface $notificationLogRepo, 
        NotificationTypeRegistryInterface $notificationTypeRegistry)
    {
        $this->notificationLogRepo = $notificationLogRepo;
        $this->notificationTypeRegistry = $notificationTypeRegistry;
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
     * @codeCoverageIgnore
     * @api
     */
	public function getSubscribedEvents() {
		return array(Events::PRE_NOTIFCATION_SEND => 'onPreNotificationSend');
	}

	/**
	 * 
	 * @param NotificationSendEvent $event
	 * @param string $eventName
	 * @param EventDispatcherInterface $ed
	 */
	public function onPreNotificationSend(NotificationSendEvent $event, $eventName, EventDispatcherInterface $ed)
	{
	    $notification = $event->getNotification();
	    $recipient = $event->getRecipient();
	    $media = $event->getMedia();
	    
	    $config = $this->notificationTypeRegistry->getNotificationType($notification->getType());
	    
	    if ($config->getNotificationEnabled($media) == false) {
	        $event->setPreventSend(true);
	        return;
	    }
	    
	    $log = $this->notificationLogRepo->getLastNotification($notification, $recipient, $media);
	    if ($log && $this->isIntervalExceed($log->getDate(), $config->getNotificationInterval($media)) == false)
	    {
	        $event->setPreventSend(true);
	        return;
	    }
	}

	/**
	 * 
	 * @param \DateTime $date
	 * @param int $interval
	 */
	private function isIntervalExceed(\DateTime $date, $interval)
	{
	    $now = new \DateTime();
	    $now->sub(new \DateInterval(sprintf('PT%ds', $interval)));
	    
	    return $now >= $date;
	}
}