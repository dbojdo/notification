<?php
namespace Webit\Notification\Tests\Event;

use Webit\Notification\Event\NotificationSendEvent;

/**
 * Class NotificationSendEventTest
 *
 * @namespace Webit\Notification\Test\Event
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class NotificationSendEventTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * @test
     */
    public function setInitPropertiesValuesWithConstructorTest()
    {
        $notification = $this->getMock('Webit\Notification\Notification\NotificationInterface');
        $recipient = $this->getMock('Webit\Notification\Recipient\RecipientInterface');
        
        $event = new NotificationSendEvent($notification, $recipient, true);
        
        $this->assertSame($notification, $event->getNotification());
        $this->assertSame($recipient, $event->getRecipient());
        $this->assertTrue($event->getPreventSend());
    }
    
    /**
     * @test
     */
    public function setPropertiesWithSettersTest()
    {
        $notification = $this->getMock('Webit\Notification\Notification\NotificationInterface');
        $recipient = $this->getMock('Webit\Notification\Recipient\RecipientInterface');
        
        $event = new NotificationSendEvent($notification, $recipient, true);
        $event->setPreventSend(false);
        
        $this->assertFalse($event->getPreventSend());
    }
}
