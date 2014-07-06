<?php
namespace Webit\Notification\Notifier;

use Webit\Notification\Notification\NotificationInterface;

/**
 * Interface NotifierInterface
 *
 * @namespace Webit\Notification\Notifier
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
interface NotifierInterface
{
    /**
     * 
     * @param NotificationInterface $notification
     */
    public function sendNotification(NotificationInterface $notification);

    /**
     * @param NotifierMediaAdapterInterface $mediaAdapter
     */
    public function registerMediaAdapter(NotifierMediaAdapterInterface $mediaAdapter);
}
