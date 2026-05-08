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

if (!function_exists('app_booking_is_active_on_date')) {
    function app_booking_is_active_on_date($pickup_date = '', $return_date = '', $reference_date = '')
    {
        $reference_stamp = !empty($reference_date) ? strtotime($reference_date) : strtotime(date('Y-m-d'));
        $pickup_stamp = !empty($pickup_date) ? strtotime($pickup_date) : false;
        $return_stamp = !empty($return_date) ? strtotime($return_date) : false;

        if ($reference_stamp === false || $pickup_stamp === false) {
            return false;
        }

        if ($return_stamp === false) {
            $return_stamp = $pickup_stamp;
        }

        return $pickup_stamp <= $reference_stamp && $return_stamp >= $reference_stamp;
    }
}

if (!function_exists('app_booking_confirmation_whatsapp_message')) {
    function app_booking_confirmation_whatsapp_message($booking = array())
    {
        $ci = function_exists('get_instance') ? get_instance() : null;
        $public_contact = array(
            'full_name' => '',
            'phone' => '',
        );
        if ($ci && isset($ci->General_model)) {
            $public_contact = (array) $ci->General_model->get_public_contact_details();
        }

        $customer_name = trim(isset($booking['customer_name']) ? (string) $booking['customer_name'] : '');
        $pickup_location = trim(isset($booking['pickup_location']) ? (string) $booking['pickup_location'] : '');
        $drop_location = trim(isset($booking['drop_location']) ? (string) $booking['drop_location'] : '');
        $vehicle_name = trim(isset($booking['vehicle_name']) ? (string) $booking['vehicle_name'] : '');
        $booking_code = trim(isset($booking['booking_code']) ? (string) $booking['booking_code'] : '');
        $pickup_date = !empty($booking['pickup_date']) ? date('d/m/Y', strtotime($booking['pickup_date'])) : '';
        $return_date = !empty($booking['return_date']) ? date('d/m/Y', strtotime($booking['return_date'])) : '';
        $amount = isset($booking['booking_amount']) ? (float) $booking['booking_amount'] : (isset($booking['amount']) ? (float) $booking['amount'] : 0);
        $advance_amount = isset($booking['advance_amount']) ? (float) $booking['advance_amount'] : 0;
        $support_name = trim(isset($public_contact['full_name']) ? (string) $public_contact['full_name'] : '');
        $support_phone = trim(isset($public_contact['phone']) ? (string) $public_contact['phone'] : '');
        $customer_label = $customer_name !== '' ? $customer_name . ' bhai' : 'Customer';

        $lines = array();
        $lines[] = 'Hi ' . $customer_label . ', your trip has been confirmed! Here are the details:';
        $lines[] = '';

        if ($pickup_location !== '') {
            $lines[] = '📍 Pickup: ' . $pickup_location;
        }

        if ($drop_location !== '') {
            $lines[] = '📍 Drop: ' . $drop_location;
        }

        if ($pickup_date !== '') {
            $lines[] = '📅 Date: ' . $pickup_date;
        }

        if ($return_date !== '' && $return_date !== $pickup_date) {
            $lines[] = '📅 Return: ' . $return_date;
        }

        if ($vehicle_name !== '') {
            $lines[] = '🚗 Car: ' . $vehicle_name;
        }

        if ($booking_code !== '') {
            $lines[] = '🆔 Booking ID: ' . $booking_code;
        }

        if ($amount > 0) {
            $lines[] = '₹ Trip Price: Rs ' . number_format($amount, 2, '.', '');
        }

        if ($advance_amount > 0) {
            $lines[] = '✅ Advance Received: Rs ' . number_format($advance_amount, 2, '.', '');
        }

        if ($support_phone !== '') {
            $lines[] = '';
            $lines[] = 'For support please contact us below:';
            $lines[] = '☎ ' . ($support_name !== '' ? $support_name : 'Support') . ': ' . $support_phone;
        }

        $lines[] = '';
        $lines[] = 'Thank you for choosing us. Have a safe journey!';

        return implode("\n", $lines);
    }
}
