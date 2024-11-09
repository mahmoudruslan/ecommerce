<?php

return [
    /**
     * Secret Key
     */
    'secret_key' => env('SECRET_KEY'),
    /**
     * Public Key
     */
    'public_key' => env('PUBLIC_KEY'),


    'integration_id' => env('INTEGRATION_ID'),
    /**
     * Payment method(s)
     * Add the Payment methods ID(s) that exist in Paymob account separated by comma , separator. (Example: 123456,98765,45678)
     */
    // 'integration_ids' => 4872633,
    /**
     * HMAC
     */
    'hmac' => env('HMAC'),
    /**
     * Callback URL
     * Please add the below URL in Paymob Merchant account for both callback and response URLs Settings for each payment method.Replace only the {example.com} with your site domain
     */
    'callback_url' => env('CALLBACK_URL'),
];
