<?php

namespace App\Domain\Jiboni\Service;

use App\Domain\Jiboni\Repository\JiboniRepository;
use App\Factory\ValidationFactory;
use Cake\Validation\Validator;
use Selective\Validation\Exception\ValidationException;

/**
 * Service.
 */
final class JiboniValidator
{
    private JiboniRepository $repository;

    private ValidationFactory $validationFactory;

    /**
     * The constructor.
     *
     * @param JiboniRepository $repository The repository
     * @param ValidationFactory $validationFactory The validation
     */
    public function __construct(JiboniRepository $repository, ValidationFactory $validationFactory)
    {
        $this->repository = $repository;
        $this->validationFactory = $validationFactory;
    }

    /**
     * Validate update.
     *
     * @param int $jiboniId The user id
     * @param array<mixed> $data The data
     *
     * @return void
     */
    public function validateJiboniUpdate(int $jiboniId, array $data): void
    {
        if (!$this->repository->existsJiboniId($jiboniId)) {
            throw new ValidationException(sprintf('Jiboni not found: %s', $jiboniId));
        }

        $this->validateJiboni($data);
    }

    /**
     * Validate new jiboni.
     *
     * @param array<mixed> $data The data
     *
     * @throws ValidationException
     *
     * @return void
     */
    public function validateJiboni(array $data): void
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
            ->notEmptyString('title', 'Input required')
            ->notEmptyString('desc', 'Input required');
    }
}
