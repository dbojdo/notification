<?php
namespace Webit\Notification\Tests\Notification;

use Webit\Notification\Notification\NotificationTypeRegistry;
/**
 * Class NotificationTypeRegistryTest
 *
 * @namespace Webit\Notification\Test\Notification
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class NotificationTypeRegistryTest extends \PHPUnit_Framework_TestCase
{
    const NOTIFICATION_TYPE_NAME = 'test_notification_type';
    const NOTIFICATION_TYPE_UNKNOW_NAME = 'test_notification_unknown_type';
    
    /**
     * @test
     */
    public function canRegisterTest()
    {
        $notificationType = $this->getMock('Webit\Notification\Notification\NotificationTypeInterface');
        $notificationType->expects($this->atLeastOnce())->method('getName')->willReturn(self::NOTIFICATION_TYPE_NAME);
        
        $registry = new NotificationTypeRegistry();
        $registry->registerNotificationType($notificationType);
    }
    
    /**
     * @test
     */
    public function canFetchTest()
    {
        $notificationType = $this->getMock('Webit\Notification\Notification\NotificationTypeInterface');
        $notificationType->expects($this->atLeastOnce())->method('getName')->willReturn(self::NOTIFICATION_TYPE_NAME);
        
        $registry = new NotificationTypeRegistry();
        $registry->registerNotificationType($notificationType);
        
        $this->assertSame($notificationType, $registry->getNotificationType(self::NOTIFICATION_TYPE_NAME));
        $this->assertNull($registry->getNotificationType(self::NOTIFICATION_TYPE_UNKNOW_NAME));
    }
}