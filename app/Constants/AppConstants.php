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
    const ADMIN = 'Admin';
    const MODERATOR = 'Moderator';
    const USER  = 'User';

    const HOTEL_OWNER = 'Hotel_Owner';
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

    // Title Otions

    const MR = 'Mr';
    const MRS = 'Mrs';
    const DR = 'Dr';
    const PROF = 'Prof';
    const BAR = 'Bar';
    const ENG = 'Eng';

    const TITLE_OPTIONS = [
        self::MR => self::MR,
        self::MRS => self::MRS,
        self::DR => self::DR,
        self::PROF => self::PROF,
        self::BAR => self::BAR,
        self::ENG => self::ENG,
    ];

    // Outlet Names
    const NAME_MAIN_RESTAURANT = 'Main Restaurant';
    const NAME_MAIN_BAR = 'Main Bar';
    const NAME_POOL_BAR = 'Pool Bar';
    const NAME_CAFE = 'Café';
    const NAME_ROOM_SERVICE = 'Room Service';
    const NAME_SPA = 'Spa';
    const NAME_FITNESS_CENTER = 'Fitness Center';
    const NAME_BUSINESS_CENTER = 'Business Center';
    const NAME_CONFERENCE_ROOM_A = 'Conference Room A';
    const NAME_CONFERENCE_ROOM_B = 'Conference Room B';
    const NAME_GIFT_SHOP = 'Gift Shop';
    const NAME_NIGHTCLUB = 'Nightclub';
    const NAME_TENNIS_COURT = 'Tennis Court';
    const NAME_BEACH_CLUB = 'Beach Club';
    const NAME_COOKING_CLASS = 'Cooking Class';

    const OUTLET_NAMES = [
        self::NAME_MAIN_RESTAURANT,
        self::NAME_MAIN_BAR,
        self::NAME_POOL_BAR,
        self::NAME_CAFE,
        self::NAME_ROOM_SERVICE,
        self::NAME_SPA,
        self::NAME_FITNESS_CENTER,
        self::NAME_BUSINESS_CENTER,
        self::NAME_CONFERENCE_ROOM_A,
        self::NAME_CONFERENCE_ROOM_B,
        self::NAME_GIFT_SHOP,
        self::NAME_NIGHTCLUB,
        self::NAME_TENNIS_COURT,
        self::NAME_BEACH_CLUB,
        self::NAME_COOKING_CLASS,
    ];

    // Outlet Types
    const TYPE_RESTAURANT = 'restaurant';
    const TYPE_BAR = 'bar';
    const TYPE_CAFE = 'cafe';
    const TYPE_ROOM_SERVICE = 'room_service';
    const TYPE_SPA = 'spa';
    const TYPE_FITNESS_CENTER = 'fitness_center';
    const TYPE_BUSINESS_CENTER = 'business_center';
    const TYPE_CONFERENCE_ROOM = 'conference_room';
    const TYPE_GIFT_SHOP = 'gift_shop';
    const TYPE_NIGHTCLUB = 'nightclub';
    const TYPE_TENNIS_COURT = 'tennis_court';
    const TYPE_BEACH_CLUB = 'beach_club';
    const TYPE_COOKING_CLASS = 'cooking_class';

    const OUTLET_TYPES = [
        self::TYPE_RESTAURANT,
        self::TYPE_BAR,
        self::TYPE_CAFE,
        self::TYPE_ROOM_SERVICE,
        self::TYPE_SPA,
        self::TYPE_FITNESS_CENTER,
        self::TYPE_BUSINESS_CENTER,
        self::TYPE_CONFERENCE_ROOM,
        self::TYPE_GIFT_SHOP,
        self::TYPE_NIGHTCLUB,
        self::TYPE_TENNIS_COURT,
        self::TYPE_BEACH_CLUB,
        self::TYPE_COOKING_CLASS,
    ];

    // Module Constants
    const MODULE_ROOM_RESERVATION = 'Room Reservation';
    const MODULE_KITCHEN_MANAGEMENT = 'Kitchen Management';
    const MODULE_HOUSEKEEPING = 'Housekeeping';
    const MODULE_FRONT_DESK = 'Front Desk';
    const MODULE_GUEST_MANAGEMENT = 'Guest Management';
    const MODULE_FOOD_AND_BEVERAGE = 'Food and Beverage';
    const MODULE_EVENT_MANAGEMENT = 'Event Management';
    const MODULE_SPA_AND_WELLNESS = 'Spa and Wellness';
    const MODULE_FITNESS_CENTER = 'Fitness Center';
    const MODULE_BUSINESS_SERVICES = 'Business Services';
    const MODULE_INVENTORY_MANAGEMENT = 'Inventory Management';
    const MODULE_BILLING_AND_PAYMENTS = 'Billing and Payments';
    const MODULE_STAFF_MANAGEMENT = 'Staff Management';
    const MODULE_MAINTENANCE = 'Maintenance';
    const MODULE_MARKETING_AND_PROMOTIONS = 'Marketing and Promotions';

    const MODULE_NAMES = [
        self::MODULE_ROOM_RESERVATION,
        self::MODULE_KITCHEN_MANAGEMENT,
        self::MODULE_HOUSEKEEPING,
        self::MODULE_FRONT_DESK,
        self::MODULE_GUEST_MANAGEMENT,
        self::MODULE_FOOD_AND_BEVERAGE,
        self::MODULE_EVENT_MANAGEMENT,
        self::MODULE_SPA_AND_WELLNESS,
        self::MODULE_FITNESS_CENTER,
        self::MODULE_BUSINESS_SERVICES,
        self::MODULE_INVENTORY_MANAGEMENT,
        self::MODULE_BILLING_AND_PAYMENTS,
        self::MODULE_STAFF_MANAGEMENT,
        self::MODULE_MAINTENANCE,
        self::MODULE_MARKETING_AND_PROMOTIONS,
    ];

    // Department Names
    const NAME_FRONT_DESK = 'Front Desk';
    const NAME_HOUSEKEEPING = 'Housekeeping';
    const NAME_FOOD_AND_BEVERAGE = 'Food and Beverage';
    const NAME_MAINTENANCE = 'Maintenance';
    const NAME_SECURITY = 'Security';
    const NAME_HUMAN_RESOURCES = 'Human Resources';
    const NAME_FINANCE = 'Finance';
    const NAME_SALES_AND_MARKETING = 'Sales and Marketing';
    const NAME_SPA_AND_WELLNESS = 'Spa and Wellness';
    const NAME_EVENTS_MANAGEMENT = 'Events Management';

    // Department List
    const DEPARTMENTS = [
        self::NAME_FRONT_DESK,
        self::NAME_HOUSEKEEPING,
        self::NAME_FOOD_AND_BEVERAGE,
        self::NAME_MAINTENANCE,
        self::NAME_SECURITY,
        self::NAME_HUMAN_RESOURCES,
        self::NAME_FINANCE,
        self::NAME_SALES_AND_MARKETING,
        self::NAME_SPA_AND_WELLNESS,
        self::NAME_EVENTS_MANAGEMENT,
    ];

}