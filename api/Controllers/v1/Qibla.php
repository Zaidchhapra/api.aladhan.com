<?php

namespace Api\Controllers\v1;

use Mamluk\Kipchak\Components\Controllers\Slim;
use Mamluk\Kipchak\Components\Http;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use AlQibla\Calculation;
use OpenApi\Attributes as OA;

class Qibla extends Slim
{
    #[OA\Get(
        path: '/qibla/{latitude}/{longitude}',
        description: 'Returns the Qibla direction based on the coordinates',
        summary: 'Qibla finder',
        tags: ['Qibla'],
        parameters: [
            new OA\PathParameter(name: 'latitude', description: "Latitude coordinates of users location",
                in: 'path', required: true, schema: new OA\Schema(type: 'number', format: 'float'), example: 19.07101757042149
            ),
            new OA\PathParameter(name: 'longitude', description: "Longitude coordinates of users location",
                in: 'path', required: true, schema: new OA\Schema(type: 'number', format: 'float'), example: 72.83862228676163
            )
        ],
        responses: [
            new OA\Response(response: '200', description: 'Returns the Qibla direction based on user coordinates',
                content: new OA\MediaType(mediaType: 'application/json',
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(property: 'code', type: 'integer', example: 200),
                            new OA\Property(property: 'status', type: 'string', example: 'OK'),
                            new OA\Property(property: 'data',
                                properties: [
                                    new OA\Property(property: 'latitude', type: 'number', example: 19.07101757042149),
                                    new OA\Property(property: 'longitude', type: 'number', example: 72.83862228676163),
                                    new OA\Property(property: 'direction', type: 'number', example: 280.07746236651514)
                                ], type: 'object')
                        ]
                    )
                )
            )
        ]
    )]
    public function get(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $latitude = floatval($request->getAttribute('latitude'));
        $longitude = floatval($request->getAttribute('longitude'));
        $calculation = [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'direction' => Calculation::get($latitude, $longitude)
        ];

        return Http\Response::json($response,
            $calculation,
            200,
            true,
            604800,
            ['public']
        );
    }

}