<?php

Route::get('/jirarest/{custom_field_id}/context', 'JIRARestController@getCustomFieldContext');
Route::get('/jirarest/context/{context_id}/options', 'JIRARestController@getContextOptions');