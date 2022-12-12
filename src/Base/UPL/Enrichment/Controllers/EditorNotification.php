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
    public function getNotification(): ?\WP_REST_Response
    {
        if (empty($_GET['id'])) {
            return null;
        }

        $id = \sanitize_text_field(
            \wp_unslash($_GET['id'])
        );

        $error = \get_post_meta($id, '_owc_pdc_sdg_push_notification', true);

        if (! $error) {
            return null;
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
	<script type="text/javascript">

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
		} );

		function checkNotificationAfterPublish(){
			const postId = wp.data.select('core/editor').getCurrentPostId();
			const url = wp.url.addQueryArgs(
				'/wp-json/owc/pdc/v1/sdg-notifications',
				{ id: postId },
			);
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
		};
	</script>
	<?php
    }
}
