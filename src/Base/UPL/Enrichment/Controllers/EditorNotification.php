<?php

namespace OWC\PDC\Base\UPL\Enrichment\Controllers;

class EditorNotification
{
    public function notificationRoute(): void
    {
        \register_rest_route(
            'owc/pdc/v1',
            'sdg-notifications',
            [
                'methods'             => \WP_REST_Server::READABLE,
                'callback'            => [$this, 'getNotification'],
                'permission_callback' => function () {
                    return \current_user_can('edit_posts');
                },
            ]
        );
    }
    
    /**
     * Send error response to REST endpoint.
     */
    public function getNotification(): \WP_REST_Response
    {
        if (empty($_GET['id'])) {
            return new \WP_REST_Response(
                [
                    'code'    => 404,
                    'message' => false
                ]
            );
        }

        $postID = \sanitize_text_field(
            \wp_unslash($_GET['id'])
        );

        $send = \get_post_meta($postID, '_owc_enrichment_send_data_to_sdg', true);

        if ($send != '1') {
            return new \WP_REST_Response(
                [
                    'code'    => 404,
                    'message' => false
                ]
            );
        }

        $error = \get_post_meta($postID, '_owc_pdc_sdg_push_notification', true);

        if (! $error) {
            return new \WP_REST_Response(
                [
                    'code'    => 404,
                    'message' => false
                ]
            );
        }

        $data = json_decode($error);

        return new \WP_REST_Response(
            [
                'code'    => $data->code,
                'message' => wp_unslash($data->message),
            ]
        );
    }
    
    /**
     * Adds script to make ajax call - checking notifications via REST.
     */
    public function checkNotifications()
    {
        ?>
	<script>

		const { subscribe, select } = wp.data;
		const { isSavingPost } = select( 'core/editor' );
		var checked = true;
		subscribe( () => {
			if ( isSavingPost() ) {
				checked = false;
			} else {
				if ( ! checked ) {
					checkNotificationAfterPublish();
					checked = true;
				}
			}
		});

		function checkNotificationAfterPublish(){
			const postId = wp.data.select('core/editor').getCurrentPostId();
			const url = wp.url.addQueryArgs(
				'/wp-json/owc/pdc/v1/sdg-notifications',
				{ id: postId },
			);
            setTimeout(() => {
                wp.apiFetch({
                    url,
                }).then(
                    function(response){
                        if(response.message){

                            wp.data.dispatch('core/notices').createNotice(
                                response.code,
                                response.message,
                                {
                                    id: '_owc_pdc_sdg_push_notification',
                                    isDismissible: true
                                }
                            );
                        }
                    }
                );
            }, 1000);
		};
	</script>
	<?php
    }
}
