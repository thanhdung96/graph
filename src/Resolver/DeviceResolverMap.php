<?php

namespace App\Resolver;

use App\Repository\DeviceRepository;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\ArgumentInterface;
use Overblog\GraphQLBundle\Resolver\ResolverMap;

class DeviceResolverMap extends ResolverMap
{
    public function __construct(
        private DeviceRepository $deviceRepository
    )
    {}

    /**
     * @inheritDoc
     */
    protected function map() : array{
        $deviceQueries = [
            self::RESOLVE_FIELD => function (
                $value,
                ArgumentInterface $argument,
                \ArrayObject $arrayObject,
                ResolveInfo $info
            ) {
                return match ($info->fieldName) {
                    'device' => $this->deviceRepository->find((string)$argument['id']),
                    'devices' => $this->deviceRepository->findAll(),
                    default => null,
                };
            },
        ];

        return [
            'DeviceQuery' => $deviceQueries
        ];
    }
}