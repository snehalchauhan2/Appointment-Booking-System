<?php

use LaraBooking\Models\Settings;

/**
 * Return a setting by name
 * @param  string $name Setting name
 * @param  string $default Default value returned
 * @return string Setting Value
 */
function settings($name, $defaultValue = '') {
    return Settings::getValueByName($name, $defaultValue);
}

/*
|--------------------------------------------------------------------------
| Detect Active Route
|--------------------------------------------------------------------------
|
| Compare given route with current route and return output if they match.
| Very useful for navigation, marking if the link is active.
|
*/
function isActiveRoute($route, $output = "active")
{
    if (Route::currentRouteName() == $route) return $output;
}

/*
|--------------------------------------------------------------------------
| Detect Active Routes
|--------------------------------------------------------------------------
|
| Compare given routes with current route and return output if they match.
| Very useful for navigation, marking if the link is active.
|
*/
function areActiveRoutes(Array $routes, $output = "active")
{
    foreach ($routes as $route)
    {
        if (Route::currentRouteName() == $route) return $output;
    }

}