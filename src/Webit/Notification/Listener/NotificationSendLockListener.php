<?php
namespace Webit\Notification\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Webit\Notification\Event\NotifyEvent;
use Webit\Notification\Event\Events;
use Webit\Notification\Lock\NotificationLockRepositoryInterface;

class NotificationSendLockListener implements EventSubscriberInterface
{
    /**
     * 
     * @var NotificationLockRepositoryInterface
     */
    private $notificationLockRepository;
    
    public function __construct(NotificationLockRepositoryInterface $notificationLockRepository)
    {
        $this->notificationLockRepository = $notificationLockRepository;
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
     * @codeCoverageIgnore
     */
	public static function getSubscribedEvents() {
		return array(Events::PRE_NOTIFY => 'onPreNotify');
	}

	/**
	 * 
	 * @param NotifyEvent $event
	 * @param string $eventName
	 * @param EventDispatcherInterface $ed
	 */
	public function onPreNotificationSend(NotifyEvent $event, $eventName, EventDispatcherInterface $ed)
	{
	    $lock = $this->notificationLockRepository->getNotificationLock();
	    
	    if ($lock->isEnabled()) {
	        $event->setPreventSend(true);
	    }
	}
}