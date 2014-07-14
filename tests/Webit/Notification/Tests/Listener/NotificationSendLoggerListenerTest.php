<?php
namespace Webit\Notification\Tests\Lock;

use Webit\Notification\Listener\NotificationSendLoggerListener;
/**
 * Class NotificationSendLoggerListenerTest
 *
 * @namespace Webit\Notification\Test\Listener
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class NotificationSendLoggerListenerTest extends \PHPUnit_Framework_TestCase
{
    const RECIPIENT_IDENTITY = 'identity';
    const NOTIFICATION_MEDIA = 'notification_media';
    const NOTIFICATION_TYPE = 'notification_type';
    const NOTIFICATION_HASH = 'im-notfication-hash';
    
    /**
     * @test
     */
    public function logNotificationSend()
    {
        $log = $this->createLog();
        $log->expects($this->once())->method('setRecipientIdentity')
            ->with($this->equalTo(self::RECIPIENT_IDENTITY));
        $log->expects($this->once())->method('setNotificationTypeName')
            ->with($this->equalTo(self::NOTIFICATION_TYPE));
        $log->expects($this->once())->method('setNotificationHash')
            ->with($this->equalTo(self::NOTIFICATION_HASH));
        $log->expects($this->once())->method('setMedia')
            ->with($this->equalTo(self::NOTIFICATION_MEDIA));
        
        $notificationLogRepo = $this->createNotificationLogRepository();
        $notificationLogRepo->expects($this->once())
            ->method('createNotificationLog')->willReturn($log);
        $notificationLogRepo->expects($this->once())
            ->method('persistNotifiationLog')->with($log);
        
        $listener = new NotificationSendLoggerListener($notificationLogRepo);
    
        $event = $this->createEvent();
        $event->expects($this->once())->method('getMedia')->willReturn(self::NOTIFICATION_MEDIA);
        $event->expects($this->once())->method('getRecipient')->willReturn($this->createRecipient());
        $event->expects($this->once())->method('getPreventSend')->willReturn(false);
        $event->expects($this->once())->method('getNotification')->willReturn($this->createNotification());
        
        $listener->onNotificationSend($event, 'event', $this->createEventDispatcher());
    }
    
    /**
     * @test
     */
    public function logNotificationSendPrevented()
    {
        $notificationLogRepo = $this->createNotificationLogRepository();
        $notificationLogRepo->expects($this->never())
            ->method('createNotificationLog');
        $notificationLogRepo->expects($this->never())
            ->method('persistNotifiationLog');
        
        $listener = new NotificationSendLoggerListener($notificationLogRepo);
    
        $event = $this->createEvent();
        $event->expects($this->once())->method('getPreventSend')->willReturn(true);
        $event->expects($this->once())->method('getRecipient')
            ->willReturn($this->createRecipient(false));
         
        $listener->onNotificationSend($event, 'event', $this->createEventDispatcher());
    }
    
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createNotificationLogRepository()
    {
        $logRepo = $this->getMock('Webit\Notification\Log\NotificationLogRepositoryInterface');
        
        return $logRepo;
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
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createEvent()
    {
        $event = $this->getMockBuilder('Webit\Notification\Event\NotificationSendEvent')
                    ->disableOriginalConstructor()->getMock();
        
        return $event; 
    }
    
    /**
     * 
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createLog()
    {
        $log = $this->getMock('Webit\Notification\Log\NotificationLogInterface');
        
        return $log;
    }
    
    /**
     * 
     * @return Ambigous <PHPUnit_Framework_MockObject_MockObject, object, unknown>
     */
    private function createRecipient($identity = true)
    {
        $recipient = $this->getMock('Webit\Notification\Recipient\RecipientInterface');
        if ($identity) {
            $recipient->expects($this->atLeastOnce())->method('getIdentity')
                ->willReturn(self::RECIPIENT_IDENTITY);
        } else {
            $recipient->expects($this->never())->method('getIdentity');
        }
        
        return $recipient;
    }
    
    /**
     * 
     * @return Ambigous <PHPUnit_Framework_MockObject_MockObject, object, unknown>
     */
    private function createNotification()
    {
        $notification = $this->getMock('Webit\Notification\Notification\NotificationInterface');
        $notification->expects($this->atLeastOnce())->method('getType')
            ->willReturn(self::NOTIFICATION_TYPE);
        $notification->expects($this->atLeastOnce())->method('getHash')
            ->willReturn(self::NOTIFICATION_HASH);
        
        return $notification;
    }
}
