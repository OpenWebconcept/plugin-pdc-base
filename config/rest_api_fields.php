<?php

$pdcSubcategoryModel = new \OWC\PDC\Base\PostType\PostTypes\PdcSubcategoryModel($this);

return [
    'pdc-subcategory' => [
        'has_report'      =>
            [
                'get_callback'    => [ $pdcSubcategoryModel, 'hasReport' ],
                'update_callback' => null,
                'schema'          => null,
            ],
        'has_appointment' =>
            [
                'get_callback'    => [ $pdcSubcategoryModel, 'hasAppointment' ],
                'update_callback' => null,
                'schema'          => null,
            ]
    ]
];
