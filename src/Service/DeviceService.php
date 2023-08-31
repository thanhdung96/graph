<?php

namespace App\Service;

use App\Entity\Device;
use App\Repository\DeviceRepository;
use App\Type\DeviceType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Contracts\Service\Attribute\Required;

class DeviceService
{
    private FormFactoryInterface $formFactory;

    public function __construct(
        private readonly DeviceRepository $deviceRepository
    ) { }

    #[Required]
    public function setFormFactory(FormFactoryInterface $formFactory): void
    {
        $this->formFactory = $formFactory;
    }

    public function findById(string $id): ?Device {
        return $this->deviceRepository->findOneBy([
            'id' => $id
        ]);
    }

    public function findAll(): array {
        return $this->deviceRepository->findAll();
    }

    public function newDevice(array $deviceParams): ?Device {
        if(sizeof($deviceParams) == 0) {
            return null;
        }

        $device = new Device();
        $form = $this->formFactory->create(
            DeviceType::class,
            $device,
            ['csrf_protection' => false]
        );
        $form->submit($deviceParams, false);

        if($form->isSubmitted() && $form->isValid()) {
            $device = $form->getData();
            $this->deviceRepository->add($device, true);

            return $device;
        } else {
            $lstErrors = [];
            foreach ($form->getErrors() as $error) {
                $lstErrors[] = $error->getMessage();
            }
        }

        return null;
    }
}