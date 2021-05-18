<?php

namespace App\Main;

use Illuminate\Support\Facades\Auth;

class SideMenu
{
    /**
     * List of side menu items.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function menu()
    {
        if (Auth::check()) {
            if (Auth::user()->admin) {
                return [
                    'dashboard' => [
                        'icon' => 'home',
                        'route_name' => 'admin',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Dashboard'
                    ],
                    'teams' => [
                        'icon' => 'star',
                        'route_name' => 'admin.teams',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Teams'
                    ],
                    'article' => [
                        'icon' => 'airplay',
                        'route_name' => 'admin.article',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Artikel',
                        'extends' => [
                            'admin.article.create',
                            'admin.article.edit',
                            'admin.article.detail',
                        ]
                    ],

                    'devider',
                    'soal' => [
                        'icon' => 'book-open',
                        'route_name' => 'admin.question.category',
                        'params' => null,
                        'title' => 'Soal',
                        'extends' => [
                            'admin.question.category.create',
                            'admin.question.category.edit',
                            'admin.question',
                            'admin.question.create',
                            'admin.question.edit',
                            'admin.question.answer',
                            'admin.question.edit',
                            'admin.question.result',
                        ]
                    ],

                    'devider',
                    'users' => [
                        'icon' => 'users',
                        'title' => 'Users',
                        'route_name' => 'admin.user',
                        'params' => null,
                        'extends' => [
                            'admin.user.show',
                            'admin.user.create',
                            'admin.user.edit',
                        ],
                    ],
                    'kontak' => [
                        'icon' => 'phone',
                        'route_name' => 'admin.contact',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Kontak'
                    ],
                ];
            } else {
                return [
                    'dashboard' => [
                        'icon' => 'home',
                        'route_name' => 'member',
                        'params' => null,
                        'title' => 'Dashboard'
                    ],
                    'test' => [
                        'icon' => 'file-text',
                        'title' => 'Test',
                        'params' => null,
                        'route_name' => 'member.test',
                        'extends' => [
                            'member.test.start',
                        ],
                    ],
                    'devider',
                    'riwayat' => [
                        'icon' => 'file',
                        'route_name' => 'member.history',
                        'params' => null,
                        'title' => 'Riwayat',
                        'extends' => [
                            'member.history.test',
                        ],

                    ],
                ];
            }
        }
        return [];
    }
}
