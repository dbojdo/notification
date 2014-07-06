<?php
namespace Webit\Notification\Tests\Notifier;

use Webit\Notification\Notifier\Notifier;
use Webit\Notification\Event\Events;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class NotifierTest
 *
 * @namespace Webit\Notification\Test\Notifier
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class NotifierTest extends \PHPUnit_Framework_TestCase
{
    const NOTIFICATION_TYPE_NAME = 'test_notification_type';
    const NOTIFICATION_TYPE_UNKNOW_NAME = 'test_notification_unknown_type';
    
    const MEDIA_TYPE_1 = 'media_type_1';
    const MEDIA_TYPE_2 = 'media_type_2';
    
    /**
     * @test
     */
    public function canRegisterMediaAdapterTest()
    {
        $notificationTypeRegistry = $this->createNotificationTypeRegistry(array(self::NOTIFICATION_TYPE_NAME => 1));
        $eventDispatcher = $this->createEventDispatcher();
        
        $notifier = new Notifier($notificationTypeRegistry, $eventDispatcher);
        $notifier->registerMediaAdapter($this->createMediaAdapter(self::MEDIA_TYPE_1));
    }
    
    /**
     * @test
     */
    public function shouldDispatchEventsDuringNotificationSendingTest()
    {
        $notificationTypeRegistry = $this->createNotificationTypeRegistry(array(self::NOTIFICATION_TYPE_NAME => 1));
        $eventDispatcher = $this->createEventDispatcher();
        
        $eventDispatcher->expects($this->at(0))->method('dispatch')
            ->with(
                $this->equalTo(Events::PRE_NOTIFY), 
                $this->isInstanceOf('Webit\Notification\Event\NotifyEvent')
            );
        
        $eventDispatcher->expects($this->at(1))->method('dispatch')
            ->with(
                $this->equalTo(Events::PRE_NOTIFCATION_SEND), 
                $this->isInstanceOf('Webit\Notification\Event\NotificationSendEvent')
            );
        
        $eventDispatcher->expects($this->at(2))->method('dispatch')
            ->with(
                $this->equalTo(Events::POST_NOTIFCATION_SEND), 
                $this->isInstanceOf('Webit\Notification\Event\NotificationSendEvent')
            );
        
        $eventDispatcher->expects($this->at(3))->method('dispatch')
            ->with(
                $this->equalTo(Events::PRE_NOTIFCATION_SEND), 
                $this->isInstanceOf('Webit\Notification\Event\NotificationSendEvent')
            );
        
        $eventDispatcher->expects($this->at(4))->method('dispatch')
            ->with(
                Events::POST_NOTIFCATION_SEND, 
                $this->isInstanceOf('Webit\Notification\Event\NotificationSendEvent')
            );
        
        $eventDispatcher->expects($this->at(5))->method('dispatch')
            ->with(
                Events::POST_NOTIFY, 
                $this->isInstanceOf('Webit\Notification\Event\NotifyEvent')
            );
        
        $notifier = new Notifier($notificationTypeRegistry, $eventDispatcher);
        $mediaAdapter = $this->createMediaAdapter(self::MEDIA_TYPE_1);
        $mediaAdapter->expects($this->exactly(1))->method('sendNotification');
        $notifier->registerMediaAdapter($mediaAdapter);
        
        $mediaAdapter = $this->createMediaAdapter(self::MEDIA_TYPE_2);
        $mediaAdapter->expects($this->exactly(1))->method('sendNotification');
        $notifier->registerMediaAdapter($mediaAdapter);
        
        $notification = $this->createNotification(self::NOTIFICATION_TYPE_NAME);
        
        $notifier->sendNotification($notification);
    }
    
    /**
     * @test
     */
    public function shouldDispatchExceptionEventOnAdapterException()
    {
        
        $notificationTypeRegistry = $this->createNotificationTypeRegistry(array(self::NOTIFICATION_TYPE_NAME => 2));
        
        $eventDispatcher = $this->createEventDispatcher();
        
        foreach (array(2, 4) as $index) {
            $eventDispatcher->expects($this->at(4))->method('dispatch')
                ->with(
                    $this->equalTo(Events::ON_NOTIFICATION_SEND_EXCEPTION),
                    $this->isInstanceOf('Webit\Notification\Event\NotificationSendExceptionEvent')
                );
        }
        
        $notifier = new Notifier($notificationTypeRegistry, $eventDispatcher);
        
        $mediaAdapter = $this->createMediaAdapter(self::MEDIA_TYPE_1);
        $mediaAdapter->expects($this->exactly(2))->method('sendNotification');
        $mediaAdapter->expects($this->any())->method('sendNotification')->willThrowException(new \Exception('test'));
        $notifier->registerMediaAdapter($mediaAdapter);
        
        $notifier->sendNotification($this->createNotification(self::NOTIFICATION_TYPE_NAME));
    }
    
    /**
     * @test
     */
    public function shouldHandleRecipientAwareNotification()
    {
        
        $notificationTypeRegistry = $this->createNotificationTypeRegistry(array(self::NOTIFICATION_TYPE_NAME => 0), false);
        $eventDispatcher = $this->createEventDispatcher();
        $notification = $this->createNotification(self::NOTIFICATION_TYPE_UNKNOW_NAME);
        
//         $notifier = new Notifier($notificationTypeRegistry, $eventDispatcher);
//         $notifier->registerMediaAdapter($this->createMediaAdapter(self::MEDIA_TYPE_1));
//         $notifier->sendNotification($notification);
    }
    
    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function shouldThrowExceptionWithInvalidNotificationType()
    {
        $notificationTypeRegistry = $this->createNotificationTypeRegistry(array(self::NOTIFICATION_TYPE_NAME => 1));
        $eventDispatcher = $this->createEventDispatcher();
        $notification = $this->createNotification(self::NOTIFICATION_TYPE_UNKNOW_NAME);
    
        $notifier = new Notifier($notificationTypeRegistry, $eventDispatcher);
        $notifier->registerMediaAdapter($this->createMediaAdapter(self::MEDIA_TYPE_1));
        $notifier->sendNotification($notification);
    }
    
    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function shouldThrowExceptionWithNoRecipientProvider()
    {
        $notificationTypeRegistry = $this->createNotificationTypeRegistry(array(self::NOTIFICATION_TYPE_NAME => 0), false);
        $eventDispatcher = $this->createEventDispatcher();
        $notification = $this->createNotification(self::NOTIFICATION_TYPE_NAME);
    
        $notifier = new Notifier($notificationTypeRegistry, $eventDispatcher);
        $notifier->registerMediaAdapter($this->createMediaAdapter(self::MEDIA_TYPE_1));
        $notifier->sendNotification($notification);
    }
    
    /**
     * 
     * @param array $types
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createNotificationTypeRegistry(array $types = array(), $setRecipientProvider = true)
    {
        $registry = $this->getMock('Webit\Notification\Notification\NotificationTypeRegistryInterface');
        $typeMap = array();
        foreach ($types as $type => $recipientsNo) {
            $notificationType = $this->createNotificationType($type);
            if($setRecipientProvider == true) {
                $notificationType->expects($this->any())
                    ->method('getRecipientProvider')
                    ->willReturn($this->createRecipientProvider($recipientsNo));
            }
            
            $typeMap[] = array($type, $notificationType);
        }
        
        if (count($typeMap) > 0)
        {
            $registry->expects($this->any())->method('getNotificationType')->willReturnMap($typeMap);
        }

        return $registry;
    }
    
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createNotificationType($name)
    {
        $type = $this->getMock('Webit\Notification\Notification\NotificationTypeInterface');
        $type->expects($this->any())->method('getName')->willReturn($name);
        
        return $type;
    }
    
    private function createEventDispatcher()
    {
        $eventDispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        
        return $eventDispatcher;
    }
    
    /**
     * 
     * @param string $mediaType
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createMediaAdapter($mediaType)
    {
        $mediaAdapter = $this->getMock('Webit\Notification\Notifier\NotifierMediaAdapterInterface');
        $mediaAdapter->expects($this->any())->method('getMedia')->willReturn($mediaType);
        
        return $mediaAdapter;
    }
    
    /**
     * @param string $type
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createNotification($type)
    {
        $notification = $this->getMock('Webit\Notification\Notification\NotificationInterface');
        $notification->expects($this->any())->method('getType')->willReturn($type);
        
        return $notification;
    }
    
    /**
     * @param int $recipientsNo
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createRecipientProvider($recipientsNo = 1)
    {
        $recipients = new ArrayCollection();
        for ($i = 1; $i <= $recipientsNo; $i++) {
            $recipients->add($this->createRecipient());
        }
        
        $recipientProvider = $this->getMock('Webit\Notification\Recipient\RecipientProviderInterface');
        $recipientProvider->expects($this->any())
            ->method('getRecipients')
            ->willReturn($recipients);
        
        return $recipientProvider;
    }
    
    /**
     * 
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createRecipient()
    {
        return $this->getMock('Webit\Notification\Recipient\RecipientInterface');
    }
}