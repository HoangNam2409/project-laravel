<?php

return [
    'module' => [
        [
            'title' => 'Member Management',
            'icon' => 'fa fa-user',
            'segment' => ['user'],
            'subModule' => [
                [
                    'title' => 'Member Group',
                    'route' => 'user.catalogue.index',
                ],
                [
                    'title' => 'Member',
                    'route' => 'user.index',
                ],
                [
                    'title' => 'Permission',
                    'route' => 'permission.index',
                ],
            ]
        ],

        [
            'title' => 'Post Management',
            'icon' => 'fa fa-newspaper-o',
            'segment' => ['post'],
            'subModule' => [
                [
                    'title' => 'Post Category',
                    'route' => 'post.catalogue.index',
                ],
                [
                    'title' => 'Post',
                    'route' => 'post.index',
                ],
            ]
        ],

        [
            'title' => 'General Settings',
            'icon' => 'fa fa-cog',
            'segment' => ['language'],
            'subModule' => [
                [
                    'title' => 'Language',
                    'route' => 'language.index',
                ],
            ]
        ],
    ],
];