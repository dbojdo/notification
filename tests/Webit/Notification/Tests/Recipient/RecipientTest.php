<?php
namespace Webit\Notification\Tests\Recipient;

use Webit\Notification\Recipient\Recipient;

/**
 * Class RecipientTest
 *
 * @namespace Webit\Notification\Test\Notification
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class RecipientTest extends \PHPUnit_Framework_TestCase
{
    const RECIPIENT_NAME = 'Recipient name';
    const RECIPIENT_PHONE_NO = '0123456789';
    const RECIPIENT_EMAIL = 'recipient@email.com';
    
    /**
     * @test
     */
    public function shouldBeIdentifable()
    {
        $recipient = new Recipient(self::RECIPIENT_NAME, self::RECIPIENT_EMAIL, self::RECIPIENT_PHONE_NO);
        foreach (array(null, 'email', 'sms', 'phone') as $media) {
            $this->assertNotEmpty($recipient->getIdentity($media));
        }
    }
    
    /**
     * @test
     */
    public function setInitPropertiesValuesWithConstructorTest()
    {
       $recipient = new Recipient(self::RECIPIENT_NAME, self::RECIPIENT_EMAIL, self::RECIPIENT_PHONE_NO);
       
       $this->assertEquals(self::RECIPIENT_NAME, $recipient->getName());
       $this->assertEquals(self::RECIPIENT_EMAIL, $recipient->getEmail());
       $this->assertEquals(self::RECIPIENT_PHONE_NO, $recipient->getPhoneNo());
    }
    
    /**
     * @test
     */
    public function setPropertiesWithSettersTest()
    {
        $recipient = new Recipient();
        $recipient->setName(self::RECIPIENT_NAME);
        $recipient->setEmail(self::RECIPIENT_EMAIL);
        $recipient->setPhoneNo(self::RECIPIENT_PHONE_NO);
        
        $this->assertEquals(self::RECIPIENT_NAME, $recipient->getName());
        $this->assertEquals(self::RECIPIENT_EMAIL, $recipient->getEmail());
        $this->assertEquals(self::RECIPIENT_PHONE_NO, $recipient->getPhoneNo());
    }
}