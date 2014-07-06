<?php
namespace Webit\Notification\Lock;

/**
 * Interface NotificationLockInterface
 *
 * @namespace Webit\Notification\Lock
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
interface NotificationLockInterface
{
    /**
     * @return bool
     */
    public function getStatus();
    
    /**
     * 
     * @param bool $status
     */
    public function setStatus($status);
    
    /**
     * @return \DateTime
     */
    public function getLockDate();
    
    /**
     * 
     * @param \DateTime $lockDate
     */
    public function setLockDate(\DateTime $lockDate);
    
    /**
     * Checks if lock is enabled
     * @return bool
     */
    public function isEnabled();
    
    /**
     * Checks if lock is disabled
     * @return bool
     */
    public function isDisabled();
}
