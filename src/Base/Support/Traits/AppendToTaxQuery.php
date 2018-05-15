<?php

namespace OWC\PDC\Base\Support\Traits;

trait AppendToTaxQuery
{

    /**
     * Appends a conditional to a taxonomy query.
     *
     * @param array  $query
     * @param array  $newQuery
     * @param string $relation
     *
     * @return array
     */
    public function appendToTaxQuery(array $query, array $newQuery, $relation = 'AND'): array
    {
        $result = [
            'relation' => $relation,
            $newQuery
        ];

        if ( ! empty($query)) {
            $result[] = $query;
        }

        return $result;
    }

}