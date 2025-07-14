<?php

return [
    'mode' => 'utf-8',
    'format' => 'A4',
    'defaultimgdpi' => 300,
    'default_font_size' => '12',
    'default_font' => 'Kokila',
    'margin_left' => 10,
    'margin_right' => 10,
    'margin_top' => 10,
    'margin_bottom' => 10,
    'margin_header' => 0,
    'margin_footer' => 0,
    'orientation' => 'P',
    'title' => 'Print Preview',
    'author' => '',
    'watermark' => '',
    'show_watermark' => false,
    'show_watermark_image' => false,
    'watermark_font' => 'sans-serif',
    'display_mode' => 'fullpage',
    'auto_language_detection' => true,
    'custom_font_dir' => public_path('fonts/'),
    'custom_font_data' => [
        'Kokila' => [
            'R' => 'Kokila.ttf',
        ],
    ],
];
