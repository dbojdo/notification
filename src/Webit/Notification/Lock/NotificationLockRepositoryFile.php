<?php
namespace Webit\Notification\Lock;

/**
 * Class NotificationLockRepositoryFile
 *
 * @namespace Webit\Notification\Lock
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class NotificationLockRepositoryFile implements NotificationLockRepositoryInterface
{
    /**
     * 
     * @var \SplFileInfo
     */
    private $file;
    
    /**
     * 
     * @var NotificationLockInterface
     */
    private $lock;
    
    /**
     * 
     * @param string $file
     */
    public function __construct($file)
    {
        $this->file = new \SplFileInfo($file);
    }
    
    /**
     * @return NotificationLockInterface
     */
    public function getNotificationLock()
    {
        if ($this->lock == null) {
            $lock = $this->readLock();
            if (empty($lock)) {
                $lock = new NotificationLock();
            }
            
            $this->lock = $lock;
        }
        
        return $this->lock;
    }
    
    /**
     * 
     * @param LockInterface $lock
     */
    public function persistNotificationLock(NotificationLockInterface $lock)
    {
        if (is_dir($this->file->getPath()) == false) {
            $this->createDir($this->file->getPath());
        }

        $str = serialize($lock);
        $result = @file_put_contents($this->file->getPathname(), $str);
        
        if ($result == false) {
            throw new \RuntimeException(sprintf('Cannot write lock file "%s"', $this->file->getPathname()));
        }
        
        $this->lock = $lock;
    }
    
    /**
     * 
     * @return LockInterface
     */
    private function readLock()
    {
        if ($this->file->isReadable()) {
            $str = file_get_contents($this->file->getPathname()); 
            $lock = @unserialize($str);
            if (($lock instanceof NotificationLockInterface) == false) {
                throw new \RuntimeException('Cannot unserialize NotificationLock object.');
            }
            
            return $lock;
        }
        
        return null;
    }
    
    /**
     * 
     * @param string $path
     * @throws \RuntimeException
     */
    private function createDir($path)
    {
        @mkdir($path, 755, true);
        if (is_dir($path) == false) {
            throw new \RuntimeException(sprintf('Cannot create directory "%s"',$path));
        }
    }
}
