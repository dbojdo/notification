<?php
namespace Webit\Notification\Tests\Lock;

use Webit\Notification\Lock\NotificationLock;
use Webit\Notification\Lock\NotificationLockToggle;
/**
 * Class NotificationLockToggleTest
 *
 * @namespace Webit\Notification\Test\Lock
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class NotificationLockToggleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function enableLock()
    {
        $lock = new NotificationLock();
        $repo = $this->getMock('Webit\Notification\Lock\NotificationLockRepositoryInterface');
        $repo->expects($this->any())->method('getNotificationLock')->willReturn($lock);
        
        $toggle = new NotificationLockToggle($repo);
        
        $date = new \DateTime();
        $lock = $toggle->enableNotificationLock($date);
        $this->assertTrue($lock->getStatus());
        $this->assertEquals($date, $lock->getLockDate());
        
        $lock = $toggle->enableNotificationLock();
        $this->assertTrue($lock->getStatus());
        $this->assertNull($lock->getLockDate());
    }

    /**
     * @test
     */
    public function disableLock()
    {
        $lock = new NotificationLock();
        $repo = $this->getMock('Webit\Notification\Lock\NotificationLockRepositoryInterface');
        $repo->expects($this->any())->method('getNotificationLock')->willReturn($lock);
    
        $toggle = new NotificationLockToggle($repo);
    
        $date = new \DateTime();
        $lock = $toggle->disableNotificationLock($date);
        $this->assertFalse($lock->getStatus());
        $this->assertEquals($date, $lock->getLockDate());
        
        $lock = $toggle->disableNotificationLock();
        $this->assertFalse($lock->getStatus());
        $this->assertNull($lock->getLockDate());
    }
    
    /**
     * @test
     * @dataProvider getEnableData
     */
    public function setLock($status, \DateTime $lockDate = null)
    {
        $lock = new NotificationLock();
        $repo = $this->getMock('Webit\Notification\Lock\NotificationLockRepositoryInterface');
        $repo->expects($this->any())->method('getNotificationLock')->willReturn($lock);
    
        $toggle = new NotificationLockToggle($repo);
    
        $lock = $toggle->setNotificationLock($status, $lockDate);
        $this->assertEquals($status, $lock->getStatus());
        $this->assertEquals($lockDate, $lock->getLockDate());
    }
    
    /**
     * 
     * @return array
     */
    public function getEnableData()
    {
        $now = new \DateTime();
        
        return array(
            array(false, null),
            array(true, null),
            array(false, $now),
            array(true, $now),
        );
    }
}
