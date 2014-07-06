<?php
namespace Webit\Notification\Recipient;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface RecipientAwareInterface
 *
 * @namespace Webit\Notification\Recipient
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
interface RecipientAwareInterface
{

    /**
     * @param string $media
     * @return ArrayCollection
     */
    public function getRecipients($media);

    /**
     * @param string $media
     * @param ArrayCollection $recipients            
     */
    public function setRecipients(ArrayCollection $recipients, $media);

    /**
     * @param string $media
     * @param RecipientInterface $recipient            
     */
    public function addRecipient(RecipientInterface $recipient, $media);
}
