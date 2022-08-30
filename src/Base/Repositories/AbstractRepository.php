<?php

/**
 * PDC item object with default quering and methods.
 */

namespace OWC\PDC\Base\Repositories;

use Closure;
use OWC\PDC\Base\Exceptions\PropertyNotExistsException;
use OWC\PDC\Base\Support\CreatesFields;
use WP_Post;
use WP_Query;

/**
 * PDC item object with default quering and methods.
 */
abstract class AbstractRepository
{
    /**
     * Posttype definition
     *
     * @var string $posttype
     */
    protected $posttype;

    /**
     * Instance of the WP_Query object.
     *
     * @var null|WP_Query
     */
    protected $query = null;

    /**
     * Arguments for the WP_Query.
     *
     * @var array
     */
    protected $queryArgs = [];

    /**
     * Fields that need to be hidden.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Dynamically added fields.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * Password of protected post
     *
     * @var string
     */
    protected $password = '';

    /**
     * Additional fields that needs to be added to an item.
     *
     * @var CreatesFields[]
     */
    protected static $globalFields = [];

    /**
     * Construct a new Repository class.
     *
     * @throws PropertyNotExistsException
     */
    public function __construct()
    {
        /**
         * In order to register globalFields for a specific repository the static property
         * "globalFields" must be present on the derived class to prevent adding fields to
         * the abstract repository class.
         */
        $reflect = new \ReflectionClass(static::class);
        if (__CLASS__ == $reflect->getProperty('globalFields')->class) {
            throw new PropertyNotExistsException(sprintf(
                'Property $globalFields must be present on derived class %s.',
                static::class
            ));
        }
    }

    /**
     * Get all the items from the database.
     *
     * @return array
     */
    public function all(): array
    {
        $args = array_merge($this->queryArgs, [
            'post_type' => [$this->posttype],
        ]);

        $this->query = new WP_Query($args);

        return array_map([$this, 'transform'], $this->getQuery()->posts);
    }

    /**
     * Find a particular pdc item by ID.
     *
     * @param int $id
     *
     * @return array
     */
    public function find(int $id)
    {
        $args = array_merge($this->queryArgs, [
            'p'         => $id,
            'post_type' => [$this->posttype],
        ]);

        $this->query = new WP_Query($args);

        if (empty($this->getQuery()->posts)) {
            return null;
        }

        return $this->transform(reset($this->getQuery()->posts));
    }

    /**
     * Find a particular pdc item by slug.
     *
     * @param string $slug
     *
     * @return array|null
     */
    public function findBySlug(string $slug)
    {
        $args = array_merge($this->queryArgs, [
            'name'        => $slug,
            'post_type'   => [$this->posttype],
        ]);

        $this->query = new WP_Query($args);

        if (empty($this->getQuery()->posts)) {
            return null;
        }

        return $this->transform(reset($this->getQuery()->posts));
    }

    /**
     * Get the WP_Query object.
     *
     * @return null|WP_Query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Add additional query arguments.
     *
     * @param array $args
     *
     * @return $this
     */
    public function query(array $args)
    {
        $this->queryArgs = array_merge_recursive($this->queryArgs, $args);

        return $this;
    }

    /**
     * Hide a particular key from the request.
     *
     * @param array $keys
     *
     * @return $this
     */
    public function hide(array $keys)
    {
        $this->hidden = array_merge($this->hidden, $keys);

        return $this;
    }

    /**
     * Dynamically add additional fields to the Repository.
     *
     * @param string        $key
     * @param CreatesFields $creator
     *
     * @return $this
     */
    public function addField(string $key, CreatesFields $creator)
    {
        $this->fields[$key] = $creator;

        return $this;
    }

    /**
     * Adds a new field to the
     *
     * @param string        $key
     * @param CreatesFields $creator
     * @param Closure|null  $conditional
     *
     * @return void
     */
    public static function addGlobalField(string $key, CreatesFields $creator, Closure $conditional = null)
    {
        static::$globalFields[] = [
            'key'         => $key,
            'creator'     => $creator,
            'conditional' => $conditional,
        ];
    }

    /**
     * Get all defined global fields of the repository.
     *
     * @return array
     */
    public static function getGlobalFields(): array
    {
        uasort(static::$globalFields, function ($a, $b) {
            return ($a['key'] < $b['key']) ? -1 : 1;
        });

        return static::$globalFields;
    }

    public function getGlobalField(string $key): ?array
    {
        $field = array_filter(static::$globalFields, fn($field) => $field['key'] === $key);

        return empty($field) ? null : reset($field);
    }

    /**
     * Transform a single WP_Post item.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function transform(WP_Post $post)
    {
        $reflectionClass = new \ReflectionClass(get_called_class());
        if ($reflectionClass->getMethod('transform')->class == get_called_class()) {
            return call_user_func_array([get_called_class(), "transform"], [$post]);
        }

        $data = [
            'id'          => $post->ID,
            'title'       => $post->post_title,
            'slug'        => $post->post_name,
            'content'     => $this->isAllowed($post) ? apply_filters('the_content', $post->post_content) : "",
            'excerpt'     => $this->isAllowed($post) ? $post->post_excerpt : "",
            'date'        => $post->post_date,
            'slug'        => $post->post_name,
            'post_status' => $post->post_status,
            'protected'   => !$this->isAllowed($post)
        ];

        $data = $this->assignFields($data, $post);

        return $this->getPreferredFields($data);
    }

    private function isAllowed(\WP_Post $post): bool
    {
        if (! $this->isPasswordProtected($post)) {
            return true;
        }

        if ($this->isPasswordValid($post)) {
            return true;
        }

        return false;
    }

    private function isPasswordProtected(\WP_Post $post): bool
    {
        return !empty($post->post_password);
    }

    private function isPasswordValid(\WP_post $post): bool
    {
        return $this->getPassword() === $post->post_password;
    }

    /**
     * Return only the preferred fields.
     *
     * @param array $data
     * @return array
     */
    protected function getPreferredFields($data)
    {
        $preferredFields = isset($_GET['fields']) ? esc_attr($_GET['fields']) : '';
        if (empty($preferredFields)) {
            return $data;
        }

        $preferredFields = explode(',', $preferredFields);
        return array_filter($data, function ($key) use ($preferredFields) {
            return in_array($key, $preferredFields);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Assign fields to the data array.
     *
     * @param array   $data
     * @param WP_Post $post
     *
     * @return array
     */
    protected function assignFields(array $data, WP_Post $post)
    {
        // Assign global fields.
        foreach (static::getGlobalFields() as $field) {
            if (in_array($field['key'], $this->hidden)) {
                continue;
            }

            if (is_null($field['conditional'])) {
                // If the field has no conditional set we will add it
                $data[$field['key']] = $field['creator']->create($post);
            } else {
                // Check if the conditional matches.
                if ($field['conditional']($post)) {
                    $data[$field['key']] = $field['creator']->create($post);
                }
            }
        }

        // Assign dynamic fields.
        foreach ($this->fields as $key => $creator) {
            $data[$key] = $creator->create($post);
        }

        return $data;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    private function getPassword(): string
    {
        return $this->password;
    }
}
