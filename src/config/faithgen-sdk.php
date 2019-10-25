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

    /**
     * @string
     * This is the remote url linked to the public folder of a remote server peradventure you are not looking for stored files from the current website
     * Eg. "http://localhost:8001/"
     */
    'remoteServer' => '',
];
