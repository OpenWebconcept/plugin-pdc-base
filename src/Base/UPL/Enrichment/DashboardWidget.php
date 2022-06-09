<?php 

namespace OWC\PDC\Base\UPL\Enrichment;

use TypeError;

class DashboardWidget 
{
    public function dashboardOutput($post, $callback_args): void
    {
        $args = [
            'post_type' => 'pdc-item',
            'post_status' => 'any',
            'posts_per_page' => '10',
            'order' => 'desc', 
            'orderby' => 'meta_value',
            'meta_key' => '_owc_enrichment_version_date',
            'meta_query' => [
                [
                    'key' => '_owc_enrichment_version_date',
                    'compare' => 'EXISTS',
                    'type' => 'DATE'
                ]
            ]
        ];

        $query = new \WP_Query($args);
        $posts = $query->posts;
        $posts = $this->convertToModel($posts, 'OWC\PDC\Base\Models\Item');
        $posts = $this->convertToModel($posts, 'OWC\PDC\Base\UPL\Enrichment\Models\ViewModel');
        
        require_once 'views/latest-enrichments.php';
    }

    protected function convertToModel(array $posts, string $class): array
    {
        if(empty($posts)){
            return [];
        }

        $posts = array_map(function($post) use ($class){
            if(!class_exists($class)){
                return [];
            }

            try {
                $post = $class::makeFrom($post);
            } catch(\TypeError | \Exception $e){
                $post = [];
            }

            return $post;
        }, $posts);

        return array_filter($posts);
    }
}