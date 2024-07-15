<?php

if (!function_exists('getPriceString')) {
    function getPriceString($price): string
    {
        return '$' . number_format($price, 2);
    }
}

if (!function_exists('getShippingCharges')) {
    function getShippingCharges(): int
    {
        return 50;
    }
}

if (!function_exists('calculateTax')) {
    function calculateTax($total): float
    {
        return $total * 0.18;
    }
}

if (!function_exists('getCartSubTotal')) {
    function getCartSubTotal($items): float
    {
        return collect($items)->sum('price');
    }
}

if (!function_exists('getCartTotal')) {
    function getCartTotal($items): float
    {
        $subtotals = getCartSubTotal($items);
        $shippingCharges = getShippingCharges();
        $tax = calculateTax($subtotals);
        return round($subtotals + $shippingCharges + $tax, 2);
    }
}

if (!function_exists('getFullAddress')) {
    function getFullAddress($shippingInfo): string
    {
        return $shippingInfo['address'] . ', ' . $shippingInfo['city'] . ', ' . $shippingInfo['state'] . ', ' . $shippingInfo['postalCode'];
    }
}
