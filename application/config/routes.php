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
$route['user/sms/send'] = 'user/UserSendCode';
$route['user/sms/confirm'] = 'user/UserConfirmationCode';

#main
$route['news'] = 'main/Main';
#news
$route['news/search'] = 'news/NewsSearch';
$route['news/full'] = 'news/NewsFull';
$route['news/comments/add'] = 'news/AddComment';
$route['news/comments'] = 'news/NewsCommentsList';