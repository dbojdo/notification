<?php
namespace Webit\Notification\Tests\Lock;

use Webit\Notification\Lock\NotificationLock;
use Webit\Notification\Listener\NotificationSendLockListener;
use Webit\Notification\Lock\NotificationLockInterface;

/**
 * Class NotificationLockTest
 *
 * @namespace Webit\Notification\Test\Listener
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class NotificationSendLockListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function preventNotificationSend()
    {
        $lock = $this->createLock();
        $lock->expects($this->atLeastOnce())->method('isEnabled')->willReturn(true);
        
        $notificationLockRepository = $this->createNotificationLockRepository($lock);
        $listener = new NotificationSendLockListener($notificationLockRepository);
        
        $event = $this->createEvent();
        $event->expects($this->once())->method('setPreventSend')->with($this->isTrue());
        
        $listener->onPreNotificationSend($event, 'event', $this->createEventDispatcher());
    }
    
    /**
     * 
     * @param bool $status
     * @param \DateTime $lockDate
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createLock($enabled = null)
    {
        $lock = $this->getMock('Webit\Notification\Lock\NotificationLockInterface');
        
        if (is_null($enabled) == false) {
            $lock->expects($this->any())->method('isEnabled')->willReturn($enabled);
            $lock->expects($this->any())->method('isDisabled')->willReturn($enabled == false);
        }
        
        return $lock;
    }
    
    /**
     * 
     * @param NotificationLockInterface $lock
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createNotificationLockRepository(NotificationLockInterface $lock = null)
    {
        $repo = $this->getMock('Webit\Notification\Lock\NotificationLockRepositoryInterface');
        
        if ($lock) {
            $repo->expects($this->any())->method('getNotificationLock')->willReturn($lock);
        }
        
        return $repo;
    }
    
    /**
     * 
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createEventDispatcher()
    {
        $dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        
        return $dispatcher;
    }
    
    /**
     * 
     * @return Ambigous <PHPUnit_Framework_MockObject_MockObject, object, unknown>
     */
    private function createEvent()
    {
        $event = $this->getMockBuilder('Webit\Notification\Event\NotifyEvent')->disableOriginalConstructor()->getMock();
        
        return $event; 
    }
}
