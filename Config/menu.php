<?php

return [
    [
        'id' => 'ocms-menu-page',
        'priority' => 1,
        'parent_id' => null,
        'name' => 'page::messages.pages',
        'icon' => 'fas fa-file-edit',
        'url' => route('admin.pages.index'),
        'permissions' => ['pages.view']
    ]
];
