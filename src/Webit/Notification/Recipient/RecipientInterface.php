<?php
namespace Webit\Notification\Recipient;

/**
 * Interface RecipientInterface
 *
 * @namespace Webit\Notification\Recipient
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
interface RecipientInterface
{
    /**
     * @return mixed
     */
    public function getIdentity($media = null);
}
