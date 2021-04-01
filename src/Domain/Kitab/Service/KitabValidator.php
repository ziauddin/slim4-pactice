<?php

namespace App\Domain\Kitab\Service;

use App\Domain\Kitab\Repository\KitabRepository;
use App\Factory\ValidationFactory;
use Cake\Validation\Validator;
use Selective\Validation\Exception\ValidationException;

/**
 * Service.
 */
final class KitabValidator
{
    private KitabRepository $repository;

    private ValidationFactory $validationFactory;

    /**
     * The constructor.
     *
     * @param KitabRepository $repository The repository
     * @param ValidationFactory $validationFactory The validation
     */
    public function __construct(KitabRepository $repository, ValidationFactory $validationFactory)
    {
        $this->repository = $repository;
        $this->validationFactory = $validationFactory;
    }

    /**
     * Validate update.
     *
     * @param int $userId The user id
     * @param array<mixed> $data The data
     *
     * @return void
     */
    public function validateKitabUpdate(int $userId, array $data): void
    {
        if (!$this->repository->existsKitabId($userId)) {
            throw new ValidationException(sprintf('Kitab not found: %s', $userId));
        }

        $this->validateKitab($data);
    }

    /**
     * Validate new user.
     *
     * @param array<mixed> $data The data
     *
     * @throws ValidationException
     *
     * @return void
     */
    public function validateKitab(array $data): void
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
            ->notEmptyString('content', 'Input required')
            ->notEmptyString('page_no', 'Input required')
            ->notEmptyString('kitab_name', 'Input required')
            ->notEmptyString('chapter_name', 'Input required');
    }
}
