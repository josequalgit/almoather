<?php

namespace App\Http\Traits;

trait ApiPaginator {


    public function formate($itemsTransformed , $itemsPaginated)
    {

      return  $itemsTransformedAndPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $itemsTransformed,
            $itemsPaginated->total(),
            $itemsPaginated->perPage(),
            $itemsPaginated->currentPage(), [
                'path' => \Request::url(),
                'query' => [
                    'page' => $itemsPaginated->currentPage()
                ]
            ]
        );
    }
}