<?php

namespace App\Services\RoleService;

class HotelServiceRole
{
    public function userCanAccessSalesRole()
    {
        return ['Hotel_Owner', 'Manager', 'Sales'];
    }
}
