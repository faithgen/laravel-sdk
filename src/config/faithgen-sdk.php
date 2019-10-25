<?php
return [
    /**
     * The prefix you would want to use on the the routes
     */
    'prefix' => 'api',

    /**
     * The guard you used for authentication
     */
    'guard' => 'api',


    /**
     * @Bool
     * If parent it exposes the update and delete routes, if not it will show only the select query routes
     */
    'source' => false,
];
