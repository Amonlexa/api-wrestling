<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

#user
$route['user/registration'] = 'user/UserRegistration';
$route['user/edit'] = 'user/UserEdit';
$route['user/delete'] = 'user/UserDelete';
$route['user/show'] = 'user/UserShow';
$route['user/auth'] = 'user/UserAuth';

#news
$route['news'] = 'main/NewsList';
$route['news/search'] = 'main/NewsSearch';
$route['news/full'] = 'main/NewsFull';
$route['news/comments/add'] = 'main/AddComment';