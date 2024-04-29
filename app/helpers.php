<?php

function booleanFlagIcon($flag)
{
    if ($flag == 1) {
        return "<i class='text-success font-medium-5' data-feather='check'></i>";
    } else {
        return "<i class='text-danger font-medium-5' data-feather='x'></i>";
    }
}

function getStatusClass($status)
{
    $options = [
        1 => 'text-warning',
        2 => 'text-success',
        3 => 'text-danger'
    ];
    return $options[$status];
}

function changeDelimiterInDateRange(&$request, $columnName)
{
    $locale = app()->getLocale();
    if ($request->created_at != null) {
        if ($locale == 'ar') {
            $request->merge([
                $columnName => str_replace(' to ', ' إلى ', $request->created_at)
            ]);
        } else {
            $request->merge([
                $columnName => str_replace(' إلى ', ' to ', $request->created_at)
            ]);
        }
    }
}

function getMethodNames()
{
    return [
        'POST', 'GET', 'PUT', 'PATCH', 'DELETE'
    ];
}

function sortIcon($column_name)
{
    if ($column_name == request('sort')) {
        if (request('direction') == 'asc') {
            return '<i class="fa fa-sort-up"></i>';
        } else {
            return '<i class="fa fa-sort-down"></i>';
        }
    }
    return '';
}
