<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/9/16
 * Time: 1:57 PM
 */

return [
    'objects' => [
        'Character' => [
            'name' => 'Character',
            'class' => 'App\\Character',
            'style' => 'purple lighten-2',
            'plural' => 'Characters',
            'icon' => 'mdi-action-face-unlock',
        ],
        'Event' => [
            'name' => 'Event',
            'class' => 'App\\Event',
            'style' => 'lime lighten-2',
            'plural' => 'Events',
            'icon' => 'mdi-action-event ',
        ],
        'Faction' => [
            'name' => 'Faction',
            'class' => 'App\\Faction',
            'style' => 'light-green lighten-2',
            'plural' => 'Factions',
            'icon' => 'mdi-action-group-work',
        ],
        'Item' => [
            'name' => 'Item',
            'class' => 'App\\Faction',
            'style' => 'teal accent-2',
            'plural' => 'Items',
            'icon' => 'mdi-content-create',
        ],
        'Person' => [
            'name' => 'Person',
            'class' => 'App\\Person',
            'style' => 'light-blue lighten-2',
            'plural' => 'People',
            'icon' => 'mdi-action-accessibility',
        ],
        'Place' => [
            'name' => 'Place',
            'class' => 'App\\Place',
            'style' => 'blue',
            'plural' => 'Places',
            'icon' => 'mdi-maps-place',
        ],
        'Time' => [
            'name' => 'Time',
            'class' => 'App\\Time',
            'style' => 'pink lighten-2',
            'plural' => 'Times',
            'icon' => 'mdi-action-alarm',
        ],
        'Weapon' => [
            'name' => 'Weapon',
            'class' => 'App\Weapon',
            'style' => 'red',
            'plural' => 'Weapons',
            'icon' => 'mdi-social-whatshot',
        ],
    ]
];