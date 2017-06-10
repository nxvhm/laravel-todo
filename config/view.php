<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => realpath(storage_path('framework/views')),

    'messages' => [
        'form_param_required' => "%s field required. Please fill the form correctly",
        'param_required' => '%s parameter is required and was not presented',
        'list_not_found' => "List not found",
        'system_error' => 'Error, try again later',
        'task_not_found' => 'Task doesnt exist',
        'task_success' => 'Task successfully %s',
        'action_success' => '%s successfully %s',        
        'not_found' => '%s %s doesnt exist',
        'list_success' => 'List successfully %s',
        'role_assigned' => 'Role %s was assigned to %s',
        'delete_available' => 'Delete action is already approved, no request needed',
        'delete_request_made' => 'Delete request was made. Wait for administrator to approve',
        'archive_no_tasks' => 'You need to have at least one task in a list, in order to perform this action',
    ],

];
