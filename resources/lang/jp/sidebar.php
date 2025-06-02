<?php

return [
    'module' => [
        [
            'title' => 'メンバー管理',
            'icon' => 'fa fa-user',
            'segment' => ['user'],
            'subModule' => [
                [
                    'title' => 'メンバーグループ管理',
                    'route' => 'user.catalogue.index',
                ],
                [
                    'title' => 'メンバー管理',
                    'route' => 'user.index',
                ],
            ]
        ],

        [
            'title' => '記事管理',
            'icon' => 'fa fa-newspaper-o',
            'segment' => ['post'],
            'subModule' => [
                [
                    'title' => '記事グループ管理',
                    'route' => 'post.catalogue.index',
                ],
                [
                    'title' => '記事管理',
                    'route' => 'post.index',
                ],
            ]
        ],

        [
            'title' => '共通設定',
            'icon' => 'fa fa-cog',
            'segment' => ['language'],
            'subModule' => [
                [
                    'title' => '言語管理',
                    'route' => 'language.index',
                ],
            ]
        ],
    ],
];