<?php

use App\BackgroundJobRunner;

if (!function_exists('runBackgroundJob')) {
    /**
     * Run a background job in the specified class and method.
     *
     * @param string $class
     * @param string $method
     * @param array  $params
     * @return void
     */
    function runBackgroundJob($class, $method, $params = [])
    {
        $jobRunner = new BackgroundJobRunner();
        $jobRunner->run($class, $method, $params);
    }
}
