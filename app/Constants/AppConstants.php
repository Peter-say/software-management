<?php

namespace App\Constants;

use App\Constants\Finance\TransactionConstants;

class AppConstants
{
    
    const MALE = 'Male';
    const FEMALE = 'Female';
    const OTHERS = 'Others';

    // Titles

    const Mr = 'Mr';
    const Mrs = 'Mrs';
    const Miss = 'Others';

  
    const DEFAULT_PASSWORD = "123456";

    const WEB_GUARD = "web";
    const ADMIN_GUARD = "admin";

    const PERMISSION_GUARDS = [
        // self::ADMIN_GUARD => "Admin Guard",
        self::WEB_GUARD => "Web Guard"
    ];

    const GENDER_OPTIONS = [
        self::MALE,
        self::FEMALE,
        self::OTHERS
    ];

  
    const ADMIN_PAGINATION_SIZE = 50;

    const BOOL_OPTIONS = [
        "1" => "Yes",
        "0" => "No"
    ];

    // Users role

       
        const SUPER_USER = 'Hotel_Owner';
        const ACCOUNT = 'Account';
        const SALES = 'Sales';
        const STORE = 'Store';
        const RECEPTIONIST = 'Receptionist';
        const CASHIER = 'Cashier';
        const MANAGER = 'Manager';
        
        
        const ROLE_OPTIONS = [
            self::ACCOUNT => self::ACCOUNT,
            self::SALES => self::SALES,
            self::STORE => self::STORE,
            self::RECEPTIONIST => self::RECEPTIONIST,
            self::CASHIER => self::CASHIER,
            self::MANAGER => self::MANAGER,
        ];
      
}