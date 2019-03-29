<?php

Route::any('/sms/sms-reply', ['as' => 'sms.sms-reply', 'uses' => '\SamJoyce777\Marketing\Http\Controllers\SMS\SMSController@reply']);

Route::group(['middleware' => ['audit', 'web']], function () {
    Route::get('/emails/unsubscribe/{unique_token}', ['as' => 'emails.unsubscribe', 'uses' => '\SamJoyce777\Marketing\Http\Controllers\Emails\ViewController@unsubscribe']);
});

Route::group(['middleware' => ['audit', 'web', 'auth', 'security']], function () {
    Route::get('/samjoyce/emails/view/{view}', ['as' => 'marketing.emails.view', 'uses' => '\SamJoyce777\Marketing\Http\Controllers\Emails\ViewController@show']);
    Route::get('/samjoyce/emails/lists', ['as' => 'marketing.emails.lists', 'uses' => '\SamJoyce777\Marketing\Http\Controllers\Emails\ListsController@index']);
    Route::get('/samjoyce/emails/lists/{category}/{list}', ['as' => 'marketing.emails.lists.show', 'uses' => '\SamJoyce777\Marketing\Http\Controllers\Emails\ListsController@show']);

    Route::get('/samjoyce/emails/emails', ['as' => 'marketing.emails', 'uses' => '\SamJoyce777\Marketing\Http\Controllers\Emails\EmailsController@index']);
    Route::get('/samjoyce/emails/emails/{category}/{email}', ['as' => 'marketing.emails.show', 'uses' => '\SamJoyce777\Marketing\Http\Controllers\Emails\EmailsController@show']);

    Route::get('/samjoyce/emails/activities/{start_date}/{end_date}', ['as' => 'marketing.emails.activities', 'uses' => '\SamJoyce777\Marketing\Http\Controllers\Emails\ActivitiesController@index']);


    Route::get('/samjoyce/emails/lists', ['as' => 'marketing.emails.lists', 'uses' => '\SamJoyce777\Marketing\Http\Controllers\Emails\ListsController@index']);
    Route::get('/samjoyce/emails/lists/{category}/{list}', ['as' => 'marketing.emails.lists.show', 'uses' => '\SamJoyce777\Marketing\Http\Controllers\Emails\ListsController@show']);


    //SMS
    Route::get('/samjoyce/sms/sms', ['as' => 'marketing.sms', 'uses' => '\SamJoyce777\Marketing\Http\Controllers\SMS\SMSController@index']);
    Route::get('/samjoyce/sms/sms/{category}/{email}', ['as' => 'marketing.sms.show', 'uses' => '\SamJoyce777\Marketing\Http\Controllers\SMS\SMSController@show']);

    Route::get('/samjoyce/sms/lists', ['as' => 'marketing.sms.lists', 'uses' => '\SamJoyce777\Marketing\Http\Controllers\SMS\ListsController@index']);
    Route::get('/samjoyce/sms/lists/{category}/{list}', ['as' => 'marketing.sms.lists.show', 'uses' => '\SamJoyce777\Marketing\Http\Controllers\SMS\ListsController@show']);

    Route::get('/samjoyce/sms/activities/{start_date}/{end_date}', ['as' => 'marketing.sms.activities', 'uses' => '\SamJoyce777\Marketing\Http\Controllers\SMS\ActivitiesController@index']);
    Route::get('/samjoyce/sms/replies/{start_date}/{end_date}', ['as' => 'marketing.sms.replies', 'uses' => '\SamJoyce777\Marketing\Http\Controllers\SMS\ActivitiesController@replies']);

});