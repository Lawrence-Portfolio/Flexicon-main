<?php

Route::get('/test', function () {
    $binding = \DB::table('deferred_bindings')->insertGetId([
        'master_type' => get_class($this),
        'master_field' => $relation,
        'slave_type' => get_class($record),
        'slave_id' => $record->getKey(),
        'pivot_data' => $pivotData,
        'session_key' => $sessionKey,
        'is_bind' => true
    ]);
});

Route::group(['prefix' => 'api'], function() {

    Route::group(['prefix' => 'v1'], function() {

        Route::get('calculator', \BizMark\Flexicon\Classes\Api\Get\Calculator::class.'@handle');

    });

});
