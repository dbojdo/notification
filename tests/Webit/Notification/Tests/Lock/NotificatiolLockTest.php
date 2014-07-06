<?php
namespace Webit\Notification\Tests\Lock;

use Webit\Notification\Lock\NotificationLock;
/**
 * Class NotificationLockTest
 *
 * @namespace Webit\Notification\Test\Lock
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class NotificationLockTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function checkDefaultValues()
    {
        $lock = new NotificationLock();
         
        $this->assertFalse($lock->getStatus());
        $this->assertNull($lock->getLockDate());
    }
    
    /**
     * @test
     */
    public function setInitPropertiesValuesWithConstructorTest()
    {
       $status = true;
       $lockDate = new \DateTime();
       
       $lock = new NotificationLock($status, $lockDate);
       
       $this->assertTrue($lock->getStatus());
       $this->assertSame($lockDate, $lock->getLockDate());
    }
    
    /**
     * @test
     */
    public function checkSetters()
    {
        $status = true;
        $lockDate = new \DateTime();
         
        $lock = new NotificationLock();
        
        $lock->setStatus($status);
        $lock->setLockDate($lockDate);
        
        $this->assertTrue($lock->getStatus());
        $this->assertSame($lockDate, $lockDate);
        
        // check set null lock date
        $lock->setLockDate(null);
        $this->assertNull($lock->getLockDate());
    }    
    
    /**
     * @test
     * @dataProvider getLockData
     */
    public function checkEnabledDisabled($status, \DateTime $lockDate = null, $enabled)
    {
        $lock = new NotificationLock();
        $lock->setStatus($status);
        $lock->setLockDate($lockDate);
        
        if ($enabled) {
            $this->assertTrue($lock->isEnabled());
            $this->assertFalse($lock->isDisabled());
        } else {
            $this->assertFalse($lock->isEnabled());
            $this->assertTrue($lock->isDisabled());
        }
    }

    /**
     * @test
     * @dataProvider getLockData
     */
    public function serializeDeseiralize($status, \DateTime $lockDate = null)
    {
        $lock = new NotificationLock();
        $lock->setStatus($status);
        $lock->setLockDate($lockDate);
    
        $str = serialize($lock);
        $unserializedLock = unserialize($str);
        $this->assertEquals($status, $unserializedLock->getStatus());
        if ($lockDate) {
            $this->assertEquals($unserializedLock->getLockDate()->format('c'), $lockDate->format('c'));
        } else {
            $this->assertNull($unserializedLock->getLockDate());
        }
    }
    
    /**
     * 
     * @return array
     */
    public function getLockData()
    {
        $now = new \DateTime();
        $past = clone($now);
        $past->sub(new \DateInterval('P7D'));
        
        $future = clone($now);
        $future->add(new \DateInterval('P7D'));
        
        return array(
            array(false, null, false),
            array(true, null, true),
            array(false, $past, true),
            array(true, $past, false),
            array(false, $future, false),
            array(true, $future, true),
        );
    }
}
