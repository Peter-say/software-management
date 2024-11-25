<?php

namespace App\Constants;

class CurrencyConstants
{
    const USD = 'USD'; // US Dollar
    const NGN = 'NGN'; // Nigerian Naira
    const EUR = 'EUR'; // Euro
    const GBP = 'GBP'; // British Pound
    const AUD = 'AUD'; // Australian Dollar
    const CAD = 'CAD'; // Canadian Dollar
    const INR = 'INR'; // Indian Rupee
    const JPY = 'JPY'; // Japanese Yen
    const CNY = 'CNY'; // Chinese Yuan
    const ZAR = 'ZAR'; // South African Rand
    const AED = 'AED'; // UAE Dirham
    const BRL = 'BRL'; // Brazilian Real
    const CHF = 'CHF'; // Swiss Franc
    const SGD = 'SGD'; // Singapore Dollar
    const KES = 'KES'; // Kenyan Shilling
    const GHS = 'GHS'; // Ghanaian Cedis

    const CURRENCY_CODES = [
        self::USD,
        self::NGN,
        self::EUR,
        self::GBP,
        self::AUD,
        self::CAD,
        self::INR,
        self::JPY,
        self::CNY,
        self::ZAR,
        self::AED,
        self::BRL,
        self::CHF,
        self::SGD,
        self::KES,
        self::GHS,
    ];

    const CURRENCY_NAMES = [
        self::USD => 'US Dollar',
        self::NGN => 'Nigerian Naira',
        self::EUR => 'Euro',
        self::GBP => 'British Pound',
        self::AUD => 'Australian Dollar',
        self::CAD => 'Canadian Dollar',
        self::INR => 'Indian Rupee',
        self::JPY => 'Japanese Yen',
        self::CNY => 'Chinese Yuan',
        self::ZAR => 'South African Rand',
        self::AED => 'UAE Dirham',
        self::BRL => 'Brazilian Real',
        self::CHF => 'Swiss Franc',
        self::SGD => 'Singapore Dollar',
        self::KES => 'Kenyan Shilling',
        self::GHS => 'Ghanaian Cedis',
    ];

    const CURRENCY_SYMBOLS = [
        self::USD => '$',
        self::NGN => '₦',
        self::EUR => '€',
        self::GBP => '£',
        self::AUD => 'A$',
        self::CAD => 'C$',
        self::INR => '₹',
        self::JPY => '¥',
        self::CNY => '¥',
        self::ZAR => 'R',
        self::AED => 'د.إ',
        self::BRL => 'R$',
        self::CHF => 'CHF',
        self::SGD => 'S$',
        self::KES => 'KSh',
        self::GHS => 'GH₵',
    ];

   // Currency Types
   const DOLLAR_CURRENCY = "Dollar";
   const NAIRA_CURRENCY = "Naira";
   const EURO_CURRENCY = "Euro";
   const POUND_CURRENCY = "Pound";
   const YEN_CURRENCY = "Yen";
   const RUPEE_CURRENCY = "Rupee";
   const RAND_CURRENCY = "Rand";
   const DIRHAM_CURRENCY = "Dirham";
   const REAL_CURRENCY = "Real";
   const FRANC_CURRENCY = "Franc";
   const SHILLING_CURRENCY = "Shilling";
   const CEDIS_CURRENCY = "Cedis";
   const YUAN_CURRENCY = "Yuan";
   const DOLLAR_VARIANT = "Dollar Variant"; // For currencies like AUD, CAD, SGD

   // Currency Type Mapping
   const CURRENCY_TYPE = [
       self::DOLLAR_CURRENCY,
       self::NAIRA_CURRENCY,
       self::EURO_CURRENCY,
       self::POUND_CURRENCY,
       self::YEN_CURRENCY,
       self::RUPEE_CURRENCY,
       self::RAND_CURRENCY,
       self::DIRHAM_CURRENCY,
       self::REAL_CURRENCY,
       self::FRANC_CURRENCY,
       self::SHILLING_CURRENCY,
       self::CEDIS_CURRENCY,
       self::YUAN_CURRENCY,
       self::DOLLAR_VARIANT,
   ];

    const PROVIDER = "Provider";
    const STRIPE = "Stripe";
    const FUND_WITH_CARD = "Card";
    const FUND_WITH_BANK = "Bank";
    const WITHDRAW_WITH_BANK = "Bank";

    const PAYMENT_GATEWAYS = [
        [
            "name" => "Flutterwave",
            "key" => self::STRIPE,
            "percentage_fees" => [
                self::DOLLAR_CURRENCY => "3.8",
                self::NAIRA_CURRENCY => "1.4",
            ],
            "supported_currencies" => [
                self::USD,
                self::NGN,
            ],
        ],
    ];

    const STRIPE_SUPPORTED_CURRENCIES = ["USD", "NGN"];
}
