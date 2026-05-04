<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('app_default_vehicle_image')) {
    function app_default_vehicle_image()
    {
        return 'uploads/defaults/vehicle-default.svg';
    }
}

if (!function_exists('app_default_profile_image')) {
    function app_default_profile_image()
    {
        return 'uploads/defaults/profile-default.svg';
    }
}

if (!function_exists('app_vehicle_image_url')) {
    function app_vehicle_image_url($image_path = '')
    {
        return base_url(!empty($image_path) ? $image_path : app_default_vehicle_image());
    }
}

if (!function_exists('app_profile_image_url')) {
    function app_profile_image_url($image_path = '')
    {
        return base_url(!empty($image_path) ? $image_path : app_default_profile_image());
    }
}

if (!function_exists('app_user_initials')) {
    function app_user_initials($name = '')
    {
        $name = trim((string) $name);
        if ($name === '') {
            return 'U';
        }

        $parts = preg_split('/\s+/', $name);
        $initials = '';

        foreach ($parts as $part) {
            if ($part === '') {
                continue;
            }

            $initials .= strtoupper(substr($part, 0, 1));
            if (strlen($initials) >= 2) {
                break;
            }
        }

        return $initials !== '' ? $initials : 'U';
    }
}
