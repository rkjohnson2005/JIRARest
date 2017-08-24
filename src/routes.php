<?php
Route::get('/jirarest/{custom_field_id}/context', 'rkjohnson2005\JIRARest\JIRARestController@getCustomFieldContext');
Route::get('/jirarest/{custom_field_id}/context/{context_id}/options', 'rkjohnson2005\JIRARest\JIRARestController@getContextOptions');