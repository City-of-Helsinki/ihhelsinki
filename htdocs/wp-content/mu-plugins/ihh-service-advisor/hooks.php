<?php

namespace IHH;

add_filter( 'manage_edit-answer_columns', __NAMESPACE__ . '\\remove_columns', 10, 1 );
add_filter( 'manage_edit-question_columns', __NAMESPACE__ . '\\remove_columns', 10, 1 );

add_action( 'rest_api_init', function () {

    /**
     * GET /serviceadvisor/v1/questions
     *
     * Get the question array with options etc.
     */
    register_rest_route( 'serviceadvisor/v1', '/questions', [
        'methods'  => 'GET',
        'callback' => function ( \WP_REST_Request $request ) {

            // Which app-taxonomy to query
            $app = $request->get_param( 'app' ) ?: 'service-advisor';

            // Get settings-fields for a correct app
            $acf_field = $app === 'service-advisor' ? 'web' : 'kiosk';

            $instructions = get_field( "instructions_{$acf_field}", 'option' );
            $contact      = get_field( "contact_{$acf_field}", 'option' );
            $disclaimer   = get_field( "disclaimer_{$acf_field}", 'option' );
            $logos        = array_map( function ( $row ) {
                return $row['logo'];
            }, get_field( "logos_{$acf_field}", 'option' ) ?: [] );

            /**
             * Query all questions
             */
            $q = ( new \WP_Query( [
                'post_type'      => 'question',
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
                'posts_per_page' => - 1,
                'tax_query'      => [
                    [
                        'taxonomy' => 'application',
                        'field'    => 'slug',
                        'terms'    => $app,
                    ],
                ],
            ] ) )->posts;

            /**
             * Return all questions
             */
            return [
                'static'    => [
                    'instructions' => $instructions,
                    'contact'      => $contact,
                    'disclaimer'   => $disclaimer,
                    'logos'        => $logos,
                ],
                'questions' => array_map( function ( \WP_Post $p ) {
                    return [
                        //'id'      => $p->ID,
                        'title'     => $p->post_title,
                        'body'      => $p->post_content,
                        'options'   => array_map( function ( $opts ) {
                            return [
                                'id'    => (int) $opts['value'],
                                'value' => format_quesion_value( $opts['label'] ),
                            ];
                        }, get_field( 'options', $p->ID ) ?: [] ),
                        'hide_when' => array_map( function ( $opts ) {
                            return (int) $opts['value'];
                        }, get_field( 'hide', $p->ID ) ?: [] ),
                    ];
                }, $q ),
            ];
        },
    ] );

    /**
     * POST /serviceadvisor/v1/answers
     *
     * Post results and get answers
     */
    register_rest_route( 'serviceadvisor/v1', '/answers', [
        'methods'  => 'POST',
        'callback' => function ( \WP_REST_Request $request ) {

            $body = $request->get_json_params();

            if ( empty( $body ) || ! isset( $body['answers'] ) || empty( $body['answers'] ) ) {
                return [];
            }

            $answers  = $body['answers'];
            $filtered = get_filtered_answers( $answers );

            /**
             * Return filtered
             */
            return array_map( function ( \WP_Post $p ) {
                $terms = get_the_terms( $p, 'answer_category' );

                return [
                    'group'  => [
                        'id'   => ! ! $terms ? $terms[0]->term_id : null,
                        'name' => ! ! $terms ? $terms[0]->name : null,
                    ],
                    'answer' => $p->post_content,
                    'weight' => (int) get_field( 'weight', $p->ID ),
                ];
            }, $filtered );
        },
    ] );

    /**
     * POST /serviceadvisor/v1/answers
     *
     * Post results and get answers (note to future someone: I hate myself for this spaghetti...)
     */
    register_rest_route( 'serviceadvisor/v1', '/sendmail', [
        'methods'  => 'POST',
        'callback' => function ( \WP_REST_Request $request ) {

            $body = $request->get_json_params();

            if ( empty( $body ) || ! isset( $body['answers'] ) || empty( $body['answers'] ) || ! isset( $body['mail'] ) ) {
                return [];
            }

            $answers  = $body['answers'];
            $filtered = get_filtered_answers( $answers );

            $email_content = "";
            $data          = [];

            foreach ( $filtered as $p ) {
                $terms = get_the_terms( $p, 'answer_category' );

                $data[] = [
                    'id'      => ! ! $terms ? (int) $terms[0]->term_id : null,
                    'title'   => ! ! $terms ? $terms[0]->name : null,
                    'content' => $p->post_content,
                ];
            }

            $id = array_column( $data, 'id' );
            array_multisort( $data, SORT_DESC, $id );
            $data = group_by( 'title', array_reverse( $data, true ) );

            foreach ( $data as $title => $arr ) {
                $email_content .= "<h3>" . $title . "</h3>";
                $email_content .= "<div>";
                foreach ( $arr as $a ) {
                    $email_content .= $a['content'];
                }
                $email_content .= "</div>";
            }

            $subject = get_field( 'email_subject', 'option' );
            $headers = [ 'Content-Type: text/html; charset=UTF-8' ];

            ob_start();
            include( dirname( __FILE__ ) . '/email-tpl.php' );
            $msg = ob_get_contents();
            ob_end_clean();

            return wp_mail( $body['mail'], $subject, $msg, $headers );
        },
    ] );
} );
