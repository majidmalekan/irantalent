<?php

namespace App\Repositories\Position;

use App\Models\Position;
use App\Repositories\BaseRepository;
use Elasticquent\ElasticquentResultCollection;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;

class PositionRepository extends BaseRepository implements PositionRepositoryInterface
{
    /**
     * @param Position $model
     */
    #[Pure] public function __construct(Position $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $position
     * @return void
     */
    public function addToIndex($position): void
    {
        $position->addToIndex();
    }

    public function search(Request $request): ElasticquentResultCollection
    {
        return $positions = $this->model::complexSearch(
            [
                'body' =>
                    [

                        "from" => $request->get('offset'),
                        "size" => $request->get('perPage'),
                        'query' => [
                            "bool" => [
                                "must" => [
                                    [
                                        'match' => $request->has('title') ? [
                                            'title' => $request->get('title')
                                        ] : [
                                            "title" => [
                                                "query" => "",
                                                "zero_terms_query" => "all"
                                            ]
                                        ],
                                    ]
                                ],
                                "filter" => $request->has('search_key') || $request->has('range_key') ? [
                                    $request->has('search_key') ? [
                                        "term" => [
                                            $request->get('search_key') . ".keyword" => $request->get('search_value'),
                                        ]
                                    ] : null,
                                    $request->has('range_key') ?
                                        $request->get('range_key') == "age" ?
                                            [
                                                "range" => [
                                                    "min_age" => [
                                                        "gte" => $request->get('range_gte'),
                                                    ],

                                                ],
                                                "range" => [
                                                    "max_age" => [
                                                        "gte" => $request->get('range_lte'),
                                                    ]
                                                ]

                                            ]
                                            :
                                            [
                                                "range" => [
                                                    $request->get('range_key') => [
                                                        "gte" => $request->get('range_gte'),
                                                        "lte" => $request->get('range_lte'),
                                                    ]
                                                ],

                                            ] : null
                                ] : null
                            ]
                        ],
                        "sort" => $request->has('sort_key') ? [
                            $request->input('sort_key') => $request->input('sort_direction'),
                        ] : [
                            "id"
                        ]
                    ]
            ]
        );
    }
}
