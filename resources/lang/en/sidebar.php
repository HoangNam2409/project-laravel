<?php

return [
    'module' => [
        [
            'title' => 'Member Management',
            'icon' => 'fa fa-user',
            'segment' => ['user'],
            'subModule' => [
                [
                    'title' => 'Member Group Management',
                    'route' => 'user.catalogue.index',
                ],
                [
                    'title' => 'Member Management',
                    'route' => 'user.index',
                ],
            ]
        ],

        [
            'title' => 'Post Management',
            'icon' => 'fa fa-newspaper-o',
            'segment' => ['post'],
            'subModule' => [
                [
                    'title' => 'Post Category Management',
                    'route' => 'post.catalogue.index',
                ],
                [
                    'title' => 'Post Management',
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
                    'title' => 'Language Management',
                    'route' => 'language.index',
                ],
            ]
        ],
    ],
];