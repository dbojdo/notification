<?php
namespace Webit\Notification\Tests\Event;

use Webit\Notification\Event\NotifyEvent;
/**
 * Class NotifiyEventTest
 *
 * @namespace Webit\Notification\Test\Event
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class NotifiyEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function setInitPropertiesValuesWithConstructorTest()
    {
        $notification = $this->getMock('Webit\Notification\Notification\NotificationInterface');
    
        $event = new NotifyEvent($notification, true);
    
        $this->assertSame($notification, $event->getNotification());
        $this->assertTrue($event->getPreventSend());
    }
    
    /**
     * @test
     */
    public function setPropertiesWithSettersTest()
    {
        $notification = $this->getMock('Webit\Notification\Notification\NotificationInterface');
    
        $event = new NotifyEvent($notification, true);
        $event->setPreventSend(false);
    
        $this->assertFalse($event->getPreventSend());
    }
}