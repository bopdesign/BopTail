<?php

/**
 * Default block settings structure
 *
 * @return array
 *
 * @package BopTail
 */

namespace BopTail\Blocks;

function get_default_block_settings()
{
    return [
        'align'         => 'full',
        'align_content' => 'top left',
        'align_text'    => 'left',
        'full_height'   => false,
        'background'    => [
            'type'     => 'none',
            'color'    => '',
            'gradient' => [],
            'image'    => [],
            'video'    => [],
            'fixed'    => false,
            'overlay'  => [],
            'pattern'  => [],
        ],
        'typography'    => [
            'eyebrow_color' => '',
            'heading_color' => '',
            'content_color' => '',
        ],
        'container'     => [
            'size'        => 'container',
            'inner_width' => 'full',
        ],
        'animation'     => 'none',
        'spacing'       => [
            'margin'  => [
                'top'    => 'none',
                'bottom' => 'none',
            ],
            'padding' => [
                'top'    => 'medium',
                'bottom' => 'medium',
            ],
        ],
    ];
}
