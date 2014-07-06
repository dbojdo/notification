<?php
namespace Webit\Notification\Recipient;

use Webit\Notification\Notification\NotificationInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface RecipientProviderInterface
 *
 * @namespace Webit\Notification\Recipient
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
interface RecipientProviderInterface
{
    /**
     * 
     * @param NotificationInterface $notification
     * @param string $media
     * @return ArrayCollection<RecipientInterface>
     */
    public function getRecipients(NotificationInterface $notification, $media);
}
