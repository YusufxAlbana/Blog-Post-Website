<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Message Moderation
    |--------------------------------------------------------------------------
    |
    | When enabled, all messages will require admin approval before being
    | displayed publicly and broadcast to other users.
    |
    */
    'moderate_messages' => env('BLOG_MODERATE_MESSAGES', false),
];
