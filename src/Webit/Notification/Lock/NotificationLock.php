<?php
namespace Webit\Notification\Lock;

/**
 * Class NotificationLock
 *
 * @namespace Webit\Notification\Lock
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class NotificationLock implements NotificationLockInterface, \Serializable
{
    /**
     * 
     * @var bool
     */
    private $status = false;
    
    /**
     * Date until lock is enabled / disabled
     * @see isEnabled method
     * @var \DateTime
     */
    private $lockDate;
    
    public function __construct($status = false, \DateTime $lockDate = null)
    {
        $this->setStatus($status);
        $this->setLockDate($lockDate);
    }
    
    /**
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     *
     * @param bool $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**
     * @return \DateTime
     */
    public function getLockDate()
    {
        return $this->lockDate;
    }
    
    /**
     *
     * @param \DateTime $lockDate
     */
    public function setLockDate(\DateTime $lockDate = null)
    {
        $this->lockDate = $lockDate;
    }
    
    /**
     * Checks if lock is enabled
     * @return bool
     */
    public function isEnabled()
    {
        $enabled = ($this->status && ($this->lockDate == null || $this->lockDate >= new \DateTime()))
            || ($this->status == false && $this->lockDate && $this->lockDate < new \DateTime());
        
        return $enabled;
    }
    
    /**
     * Checks if lock is disabled
     * @return bool
     */
    public function isDisabled()
    {
        return $this->isEnabled() == false;
    }
    
    public function serialize()
    {
        return serialize(
            array(
        	   'status' => $this->status,
               'lockDate' => $this->lockDate ? $this->lockDate->format('Y-m-d H:i:sO') : null
            )
        );
    }
    
    public function unserialize($str)
    {
        $data = unserialize($str);
        $this->status = $data['status'];
        if (isset($data['lockDate'])) {
            $this->lockDate = \DateTime::createFromFormat('Y-m-d H:i:sO', $data['lockDate']);
        }
    }
}
