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
