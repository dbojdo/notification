<?php
namespace Webit\Notification\Lock;

/**
 * Interface NotificationLockToggleInterface
 *
 * @namespace Webit\Notification\Lock
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
interface NotificationLockToggleInterface
{
    /**
     * 
     * @param \DateTime $lockDate
     * @return NotificationLockInterface
     */
    public function enableNotificationLock(\DateTime $lockDate = null);
    
    /**
     * 
     * @param \DateTime $lockDate
     * @return NotificationLockInterface
     */
    public function disableNotificationLock(\DateTime $lockDate = null);
    
    /**
     * 
     * @param bool $status
     * @param \DateTime $lockDate
     * @return NotificationLockInterface
     */
    public function setNotificationLock($status, \DateTime $lockDate = null);
}
