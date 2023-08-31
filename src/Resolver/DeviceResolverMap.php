<?php

namespace App\Resolver;

use App\Service\DeviceService;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\ArgumentInterface;
use Overblog\GraphQLBundle\Resolver\ResolverMap;

class DeviceResolverMap extends ResolverMap
{
    public function __construct(
        private readonly DeviceService $deviceService
    ) {}

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
                    'device' => $this->deviceService->findById((string)$argument['id']),
                    'devices' => $this->deviceService->findAll(),
                    default => null,
                };
            },
        ];

        $deviceMutation = [
            self::RESOLVE_FIELD => function (
                $value,
                ArgumentInterface $argument,
                \ArrayObject $arrayObject,
                ResolveInfo $info
            ) {
                return match ($info->fieldName) {
                    'newDevice' => $this->deviceService->newDevice($argument->getArrayCopy()['device']),
                    'updateDevice' => $this->deviceRepository->findAll(),
                    'assignDevice' => $this->deviceRepository->findAll(),
                    default => null,
                };
            },
        ];

        return [
            'DeviceQuery' => $deviceQueries,
            'DeviceMutation' => $deviceMutation
        ];
    }
}