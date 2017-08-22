<?php
Route::get('jirarest/pcrs/{pcr}', 'rkjohnson2005\JIRARest\JIRARestController@pcr');

// Project Routes
Route::get('jirarest/projects', 'rkjohnson2005\JIRARest\JIRARestController@getProjects');
Route::get('jirarest/{project}/issues', 'rkjohnson2005\JIRARest\JIRARestController@getIssues');
Route::get('jirarest/{project}/issuetypes', 'rkjohnson2005\JIRARest\JIRARestController@getProjectIssuetypes');

// Issue Routes
Route::get('jirarest/issue/{issue}', 'rkjohnson2005\JIRARest\JIRARestController@getIssue');
Route::get('jirarest/issue/{issue}/comments', 'rkjohnson2005\JIRARest\JIRARestController@getIssueComments');
