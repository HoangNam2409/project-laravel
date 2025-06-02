<?php

return [
    'module' => [
        [
            'title' => 'QL Thành Viên',
            'icon' => 'fa fa-user',
            'segment' => ['user'],
            'subModule' => [
                [
                    'title' => 'QL Nhóm Thành Viên',
                    'route' => 'user.catalogue.index',
                ],
                [
                    'title' => 'QL Thành Viên',
                    'route' => 'user.index',
                ],
            ]
        ],

        [
            'title' => 'QL Bài Viết',
            'icon' => 'fa fa-newspaper-o',
            'segment' => ['post'],
            'subModule' => [
                [
                    'title' => 'QL Nhóm Bài Viết',
                    'route' => 'post.catalogue.index',
                ],
                [
                    'title' => 'QL Bài Viết',
                    'route' => 'post.index',
                ],
            ]
        ],

        [
            'title' => 'Cấu hình chung',
            'icon' => 'fa fa-cog',
            'segment' => ['language'],
            'subModule' => [
                [
                    'title' => 'QL Ngôn Ngữ',
                    'route' => 'language.index',
                ],
            ]
        ],
    ],
];