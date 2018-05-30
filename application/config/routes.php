<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Auth/login';

// custom route
$route["login"] = "Auth/Login";

// dashboard
$route["home/dashboard"] = "Home/Dashboard";

// hr
$route["hr/employee"] = "HR/Employee";
$route["hr/employee/add"] = "HR/Employee/employee_add";
$route["api/hr/employee"] = "api/HR/Employee";
