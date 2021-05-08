<?php

namespace App\Domain\AppInfo\Service;

use App\Domain\AppInfo\Repository\AppInfoRepository;
use App\Factory\ValidationFactory;
use Cake\Validation\Validator;
use Selective\Validation\Exception\ValidationException;

/**
 * Service.
 */
final class AppInfoValidator
{
    private AppInfoRepository $repository;

    private ValidationFactory $validationFactory;

    /**
     * The constructor.
     *
     * @param AppInfoRepository $repository The repository
     * @param ValidationFactory $validationFactory The validation
     */
    public function __construct(AppInfoRepository $repository, ValidationFactory $validationFactory)
    {
        $this->repository = $repository;
        $this->validationFactory = $validationFactory;
    }

    /**
     * Validate update.
     *
     * @param int $appInfoId The user id
     * @param array<mixed> $data The data
     *
     * @return void
     */
    public function validateAppInfoUpdate(int $appInfoId, array $data): void
    {
        if (!$this->repository->existsAppInfoId($appInfoId)) {
            throw new ValidationException(sprintf('AppInfo not found: %s', $appInfoId));
        }

        $this->validateAppInfo($data);
    }

    /**
     * Validate new appInfo.
     *
     * @param array<mixed> $data The data
     *
     * @throws ValidationException
     *
     * @return void
     */
    public function validateAppInfo(array $data): void
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
            ->notEmptyString('package', 'Input required')
            ->notEmptyString('app_name', 'Input required')
            ->notEmptyString('app_id', 'Input required');
    }
}