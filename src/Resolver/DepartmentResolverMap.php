<?php

namespace App\Resolver;

use App\Repository\DepartmentRepository;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\ArgumentInterface;
use Overblog\GraphQLBundle\Resolver\ResolverMap;

class DepartmentResolverMap extends ResolverMap
{
    public function __construct(
        private DepartmentRepository $departmentRepository
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
                    default => null,
                };
            },
        ];

        return [
            'DeviceQuery' => $deviceQueries
        ];
    }
}