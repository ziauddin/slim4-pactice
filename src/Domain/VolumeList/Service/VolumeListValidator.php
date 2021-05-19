<?php

namespace App\Domain\VolumeList\Service;

use App\Domain\VolumeList\Repository\VolumeListRepository;
use App\Factory\ValidationFactory;
use Cake\Validation\Validator;
use Selective\Validation\Exception\ValidationException;

/**
 * Service.
 */
final class VolumeListValidator
{
    private VolumeListRepository $repository;

    private ValidationFactory $validationFactory;

    /**
     * The constructor.
     *
     * @param VolumeListRepository $repository The repository
     * @param ValidationFactory $validationFactory The validation
     */
    public function __construct(VolumeListRepository $repository, ValidationFactory $validationFactory)
    {
        $this->repository = $repository;
        $this->validationFactory = $validationFactory;
    }

    /**
     * Validate update.
     *
     * @param int $volumeListId The user id
     * @param array<mixed> $data The data
     *
     * @return void
     */
    public function validateVolumeListUpdate(int $volumeListId, array $data): void
    {
        if (!$this->repository->existsVolumeListId($volumeListId)) {
            throw new ValidationException(sprintf('VolumeList not found: %s', $volumeListId));
        }

        $this->validateVolumeList($data);
    }

    /**
     * Validate new volumeList.
     *
     * @param array<mixed> $data The data
     *
     * @throws ValidationException
     *
     * @return void
     */
    public function validateVolumeList(array $data): void
    {
        $validator = $this->createValidator();

        $validationResult = $this->validationFactory->createValidationResult(
            $validator->validate($data)
        );

        if ($validationResult->fails()) {
            throw new ValidationException('Please check your input', $validationResult);
        }
    }

    /**
     * Create validator.
     *
     * @return Validator The validator
     */
    private function createValidator(): Validator
    {
        $validator = $this->validationFactory->createValidator();

        return $validator
            ->notEmptyString('name', 'Input is required');
    }
}
