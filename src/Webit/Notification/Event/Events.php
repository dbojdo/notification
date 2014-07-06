<?php
namespace Webit\Notification\Event;

/**
 * Class Events
 *
 * @namespace Webit\Notification\Event
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
final class Events
{
    /** 
     * This event is dispached before running media adapters loop.
     * It can prevent sending notification.
     */
    const PRE_NOTIFY = 'webit_notification.pre_notify';
    
    /**
     * This event is dispached after running media adapters loop.
     */
    const POST_NOTIFY = 'webit_notification.post_notify';
    
    /** 
     * This event is dispached before notfication is sent to given recipient by current media adapter.
     * It can prevent sending notification.
     */
    const PRE_NOTIFCATION_SEND = 'webit_notification.pre_notification_send';
    
    /**
     * This event is dispached after notfication is sent to given recipient by current media adapter.
     */
    const POST_NOTIFCATION_SEND = 'webit_notification.post_notification_send';
    
    /**
     * This event is dispached when media adapter throws exception during notification sendingq
     */
    const ON_NOTIFICATION_SEND_EXCEPTION = 'webit_notification.post_notification_send';
}
