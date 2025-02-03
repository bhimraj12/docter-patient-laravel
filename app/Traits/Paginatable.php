<?php

namespace App\Traits;

use Illuminate\Pagination\AbstractPaginator;

trait Paginatable
{
    /**
     * Method to apply pagination dynamically with the page limit based on the query parameters
     *
     * @return mixed
     */
    protected function applyDynamicPagination($query, $request, bool $paginated = true, int $limit = 20)
    {
        $limit = $request->query('limit', $limit); // Default to 20 items per page
        $paginated = $request->query('paginated', $paginated); // No pagination default

        return $paginated ? $query->paginate($limit) : $query->get();
    }

    /**
     * Method to apply pagination with the page limit based on the query parameters
     *
     * @return mixed
     */
    protected function applyPagination($query, $request, int $limit = 20)
    {
        $limit = $request->query('limit', $limit); // Default to 20 items per page

        return $query->paginate($limit);
    }

    protected function generatePagination($paginatedData)
    {
        if (! $paginatedData instanceof AbstractPaginator) {
            return [];
        }

        return [
            'links' => [
                'first' => $paginatedData->url(1),
                'last' => $paginatedData->url($paginatedData->lastPage()),
                'prev' => $paginatedData->previousPageUrl(),
                'next' => $paginatedData->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $paginatedData->currentPage(),
                'from' => $paginatedData->firstItem(),
                'last_page' => $paginatedData->lastPage(),
                'links' => [
                    [
                        'url' => null,
                        'label' => '&laquo; Previous',
                        'active' => false,
                    ],
                    [
                        'url' => $paginatedData->url($paginatedData->currentPage()),
                        'label' => $paginatedData->currentPage(),
                        'active' => true,
                    ],
                    [
                        'url' => null,
                        'label' => 'Next &raquo;',
                        'active' => false,
                    ],
                ],
                'path' => $paginatedData->path(),
                'per_page' => $paginatedData->perPage(),
                'to' => $paginatedData->lastItem(),
                'total' => $paginatedData->total(),
            ],
        ];
    }
}
