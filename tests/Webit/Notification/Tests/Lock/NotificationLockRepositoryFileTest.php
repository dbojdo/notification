<?php
namespace Webit\Notification\Tests\Lock;

use Webit\Notification\Lock\NotificationLock;
use Webit\Notification\Lock\NotificationLockRepositoryFile;
/**
 * Class NotificationLockRepositoryFileTest
 *
 * @namespace Webit\Notification\Test\Lock
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class NotificationLockRepositoryFileTest extends \PHPUnit_Framework_TestCase
{
    const LOCK_FILE = 'notificaiotn.lock';
    
    public function setUp()
    {
        $pathname = $this->getLockPathname();
        @unlink($pathname);
    }
    
    private function getLockPathname($dir = null)
    {
        $dir = $dir ?: sys_get_temp_dir();
        
        return $dir . '/' . self::LOCK_FILE;
    }
    
    /**
     * @test
     */
    public function getDefaultLock()
    {
        $repo = new NotificationLockRepositoryFile($this->getLockPathname());
        $lock = $repo->getNotificationLock();
        
        $this->assertInstanceOf('Webit\Notification\Lock\NotificationLockInterface', $lock);
    }
    
    /**
     * @test
     */
    public function persistLockTest()
    {
        $status = true;
        $lockDate = new \DateTime();
        
        $repo = new NotificationLockRepositoryFile($this->getLockPathname());
        $lock = $repo->getNotificationLock();
        
        $this->assertNotEquals($status, $lock->getStatus());
        $this->assertNotEquals($lockDate, $lock->getLockDate());
        
        $lock->setStatus($status);
        $lock->setLockDate($lockDate);
        
        $repo->persistNotificationLock($lock);
        
        $repo = new NotificationLockRepositoryFile($this->getLockPathname());
        $persistedLock = $repo->getNotificationLock();
        $this->assertEquals($status, $persistedLock->getStatus());
        if ($lockDate) {
            $this->assertEquals($lockDate->format('c'), $persistedLock->getLockDate()->format('c'));
        } else {
            $this->assertNull($persistedLock->getLockDate());
        }
    }
    
    /**
     * @test
     */
    public function persistLockInNonExistentDir()
    {
        $dir = sys_get_temp_dir() . '/non-existent-lock-dir-'.mt_rand(0, 999999999);
        if (is_dir($dir)) {
            $this->markTestSkipped(sprintf('Dir "%s" exists.'));
        }
        $file = $this->getLockPathname($dir);
        $repo = new NotificationLockRepositoryFile($file);
        
        $lock = $repo->getNotificationLock();
        
        $repo->persistNotificationLock($lock);
        $this->assertFileExists($file);
        
        @unlink($dir);
    }
    
    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function cannotCreateLockFileDir()
    {
        $dir = '/non-existent-lock-dir-'.mt_rand(0, 999999999);
        if (is_writable('/')) {
            $this->markTestSkipped(sprintf('Dir "%s" is writable, probably can create dir.'));
        }
        
        $file = $this->getLockPathname($dir);
        $repo = new NotificationLockRepositoryFile($file);
        
        $lock = $repo->getNotificationLock();
        
        $repo->persistNotificationLock($lock);
        $this->assertFileExists($file);
    }
    
    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function destinationIsNotWritable()
    {
        $dir = '/';
        
        $file = $this->getLockPathname($dir);
        $repo = new NotificationLockRepositoryFile($file);
        
        $lock = $repo->getNotificationLock();
        
        $repo->persistNotificationLock($lock);
        $this->assertFileExists($file);
    }
    
    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function unserializationError()
    {
        $file = $this->getLockPathname();
        file_put_contents($file, 'Unserializable data');
        $repo = new NotificationLockRepositoryFile($file);
        $repo->getNotificationLock();
    }
}
