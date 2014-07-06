<?php
namespace Webit\Notification\Tests\Event;

use Webit\Notification\Event\NotificationSendExceptionEvent;
/**
 *
 * @author dbojdo
 *        
 */
class NotificationSendExceptionEventTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * @test
     */
    public function setInitPropertiesValuesWithConstructorTest()
    {
        $notification = $this->getMock('Webit\Notification\Notification\NotificationInterface');
        $recipient = $this->getMock('Webit\Notification\Recipient\RecipientInterface');
        $exception = $this->getMock('\Exception');
        
        $event = new NotificationSendExceptionEvent($notification, $recipient, $exception);
        
        $this->assertSame($notification, $event->getNotification());
        $this->assertSame($recipient, $event->getRecipient());
        $this->assertSame($exception, $event->getException());
    }
}
