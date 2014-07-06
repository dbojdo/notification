<?php
namespace Webit\Notification\Lock;

/**
 * Class NotificationLockToggle
 *
 * @namespace Webit\Notification\Lock
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class NotificationLockToggle implements NotificationLockToggleInterface
{
    /**
     * 
     * @var NotificationLockRepositoryInterface
     */
    private $notificationLockRepository;
    
    public function __construct(NotificationLockRepositoryInterface $notificationLockRepository)
    {
        $this->notificationLockRepository = $notificationLockRepository;
    }
    
    /**
     * 
     * @param \DateTime $lockDate
     * @return NotificationLockInterface
     */
    public function enableNotificationLock(\DateTime $lockDate = null)
    {
        $lock = $this->setNotificationLock(true, $lockDate);
        
        return $lock;
    }
    
    /**
     * 
     * @param \DateTime $lockDate
     * @return NotificationLockInterface
     */
    public function disableNotificationLock(\DateTime $lockDate = null)
    {
        $lock = $this->setNotificationLock(false, $lockDate);
        
        return $lock;
    }
    
    /**
     * 
     * @param bool $status
     * @param \DateTime $lockDate
     * @return NotificationLockInterface
     */
    public function setNotificationLock($status, \DateTime $lockDate = null)
    {
        $lock = $this->notificationLockRepository->getNotificationLock();
        $lock->setStatus($status);
        $lock->setLockDate($lockDate);
        
        $this->notificationLockRepository->persistNotificationLock($lock);
        
        return $lock;
    }
}
