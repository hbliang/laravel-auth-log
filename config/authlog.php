<?php

return [
    'model' => \Hbliang\AuthLog\Models\AuthLog::class,
    'table_name' => 'auth_log',
    'delete_records_older_than_days' => 365,
];
