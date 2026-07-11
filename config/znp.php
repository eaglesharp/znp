<?php

return [
    /*
    | Stripe Price IDs for ZNP employer plans (optional).
    | When set, checkout uses the hosted Stripe price; otherwise the plan
    | amount from znp_pricing_plans (incl. GST) is sent as price_data.
    */
    'stripe_prices' => [
        'quick_job' => env('STRIPE_PRICE_QUICK_JOB'),
        'flex'      => env('STRIPE_PRICE_FLEX'),
    ],
];
