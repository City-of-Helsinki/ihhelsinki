<?php

namespace IHH;

/**
 * Get labels to column
 *
 * @param        $field_arr
 * @param string $glue
 *
 * @return string|null
 */
function get_labels( $field_arr, $glue = "<br>\n" ) {
    if ( ! $field_arr ) {
        return null;
    }

    $labels = array_map( function ( $field ) {
        return $field['label'];
    }, $field_arr );

    sort( $labels );

    return implode( $glue, $labels );
}

/**
 * Remove unnecessary columns from answers & questions
 *
 * @param $columns
 *
 * @return mixed
 */
function remove_columns( $columns ) {
    unset( $columns['wpseo-score'] );
    unset( $columns['wpseo-score-readability'] );
    unset( $columns['wpseo-title'] );
    unset( $columns['wpseo-metadesc'] );
    unset( $columns['wpseo-focuskw'] );
    unset( $columns['wpseo-links'] );
    unset( $columns['wpseo-linked'] );

    return $columns;
}

/**
 * Use "Yes" / "No" if present
 *
 * @param $value
 *
 * @return string
 */
function format_quesion_value( $value ) {
    if ( substr( strtolower( $value ), 0, 4 ) === 'yes,' ) {
        return 'Yes';
    } else if ( substr( strtolower( $value ), 0, 3 ) === 'no,' ) {
        return 'No';
    }

    return $value;
}

/**
 * Check if one of the keys are present in the should_show_ids
 *
 * @param $answer_ids
 * @param $should_show_ids
 *
 * @return bool
 */
function should_show( $answer_ids, $should_show_ids ) {
    foreach ( $answer_ids as $id ) {
        if ( in_array( $id, $should_show_ids ) ) {
            return true;
        }
    }

    return false;
}

/**
 * Get values from ACF
 *
 * @param $meta_arr
 *
 * @return array
 */
function get_option_ids( $meta_arr ) {
    return array_map( function ( $meta ) {
        return (int) $meta['value'];
    }, $meta_arr );
}

/**
 * Add orderby clause to some filters
 *
 * @param $orderby_stmt
 *
 * @return string
 */
function answers_orderby( $orderby_stmt ) {
    $orderby_stmt = " term_order ASC, " . $orderby_stmt;

    return $orderby_stmt;
}

function get_filtered_answers( $answers ) {
    $answer_taxonomies = get_terms( [
        'fields'     => 'ids',
        'taxonomy'   => 'answer_category',
        'orderby'    => 'term_order',
        'hide_empty' => true,
    ] );

    // Extra orderby-clause
    add_filter( 'posts_orderby', __NAMESPACE__ . '\\answers_orderby' );
    /**
     * Query all answers
     */
    $q = ( new \WP_Query( [
        'post_type'      => 'answer',
        'posts_per_page' => - 1,
        'meta_key'       => 'weight',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
        'tax_query'      => [
            [
                'taxonomy' => 'answer_category',
                'field'    => 'term_id',
                'terms'    => $answer_taxonomies,
            ],
        ],
    ] ) )->posts;

    // Remove extra orderby-clause
    remove_filter( 'posts_orderby', __NAMESPACE__ . '\\answers_orderby' );

    /**
     * Filter answers based on meta options (show when, hide when)
     */
    return array_filter( $q, function ( \WP_Post $p ) use ( $answers ) {
        $show_on_ids = get_option_ids( get_field( 'show_options', $p->ID ) );
        $hide_on_ids = get_option_ids( get_field( 'answer_hide', $p->ID ) );

        return should_show( $answers, $show_on_ids ) && ! should_show( $answers, $hide_on_ids );
    } );
}

/**
 * @param $key
 * @param $data
 *
 * @return array
 */
function group_by( $key, $data ) {
    $result = [];

    foreach ( $data as $val ) {
        if ( array_key_exists( $key, $val ) ) {
            $result[ $val[ $key ] ][] = $val;
        } else {
            $result[""][] = $val;
        }
    }

    return $result;
}
