<?php

namespace App\Constants;

class StatusConstants
{
    const ACTIVE = 'Active';

    const INACTIVE = 'Inactive';

    const CREATED = 'Created';

    const STARTED = 'Started';

    const AVAILABLE = 'Available';

    const APPROVED = 'Approved';

    const REJECTED = 'Rejected';

    const SUSPENDED = 'Suspended';

    const PARTIAL = 'Partial';

    const ORDERED = 'Ordered';

    const PENDING = 'Pending';

    const COMPLETED = 'Completed';

    const TRANSPORTED = 'Transported';

    const SUBMITTED_FOR_SERVICE = 'Submitted for Service';

    const ACCEPTED = 'Accepted';

    const TRA = 'Live';

    const CANCELLED = 'Cancelled';

    const DECLINED = 'Declined';

    const ENDED = 'Ended';

    const BOOKED = 'Booked';

    const DELETED = 'Deleted';

    const ARCHIVED = 'Archived';

    const DRAFTED = 'Drafted';

    const PUBLISHED = 'Published';

    const SUCCESSFUL = 'Successful';

    const FAILED = 'Failed';

    const SKIPPED = 'Skipped';

    const RESOLVED = 'Resolved';

    const UNRESOLVED = 'Unresolved';

    const RECEIVED = 'Recieved';

    const IN_TRANSIT = 'In Transit';

    const OUT_FOR_DELIVERY = 'Out for Delivery';

    const DELIVERED = 'Delivered';

    const RETURNED = 'Returned';

    const FAILED_DELIVERY = 'Failed Delivery';

    const SHIPPED = 'Shipped';

    const RENT = 'Rent';
    const SELL = 'Sell';

    const ACTIVE_OPTIONS = [
        1 => 'Active',
        0 => 'Inactive',
    ];

    const STOCK_OPTIONS = [
        self::SELL => 'Sell',
        self::RENT => 'Rent',
    ];

    const BOOL_OPTIONS = [
        1 => 'Yes',
        0 => 'No',
    ];



    const ERROR_STATUS = [
        self::RESOLVED => 'Resolved',
        self::UNRESOLVED => 'Unresolved',
    ];

    const ADMIN = 'Admin';
    const MODERATOR = 'Moderator';
    const CUSTOMER = 'Customer';
    const USER = 'User';

    const USERS_ROLE = [
        self::ADMIN => 'Admin',
        self::MODERATOR => 'Moderator',
        self::CUSTOMER => 'Customer',
        self::USER => 'User',
    ];


    const  PURCHASE_STATUS_OPTION = [
        self::RECEIVED => "Received",
        self::PARTIAL => "Partial",
        self::ORDERED => "Ordered",
        self::PENDING => "Pending",
        // Add more statuses as needed
    ];
}
