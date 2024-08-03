<?php

use Illuminate\Support\Facades\DB;

function getModelItems($model)
{
    $model_list = null;

    if ($model == 'countries') {
        $model_list = DB::table('countries')->select('id', 'name')->orderBy('name', 'asc')->get();
    } elseif ($model == 'states') {
        $model_list = DB::table('states')->select('id', 'name')->orderBy('name', 'asc')->get();
    }

    return $model_list;
}

function getStatusAsString(int $status): string
{
    if ($status === 1) {
        return 'Active';
    } else {
        return 'Inactive';
    }
}
