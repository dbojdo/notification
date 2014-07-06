<?php
namespace Webit\Notification\Lock;

/**
 * Interface NotificationLockRepositoryInterface
 *
 * @namespace Webit\Notification\Lock
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
interface NotificationLockRepositoryInterface
{
    /**
     * @return NotificationLockInterface
     */
    public function getNotificationLock();
    
    /**
     * 
     * @param LockInterface $lock
     */
    public function persistNotificationLock(NotificationLockInterface $lock);
}
