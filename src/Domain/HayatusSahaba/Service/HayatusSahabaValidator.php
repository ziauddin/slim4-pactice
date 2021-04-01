<?php

namespace App\Domain\HayatusSahaba\Service;

use App\Domain\HayatusSahaba\Repository\HayatusSahabaRepository;
use App\Factory\ValidationFactory;
use Cake\Validation\Validator;
use Selective\Validation\Exception\ValidationException;

/**
 * Service.
 */
final class HayatusSahabaValidator
{
    private HayatusSahabaRepository $repository;

    private ValidationFactory $validationFactory;

    /**
     * The constructor.
     *
     * @param HayatusSahabaRepository $repository The repository
     * @param ValidationFactory $validationFactory The validation
     */
    public function __construct(HayatusSahabaRepository $repository, ValidationFactory $validationFactory)
    {
        $this->repository = $repository;
        $this->validationFactory = $validationFactory;
    }

    /**
     * Validate update.
     *
     * @param array<mixed> $data The data
     * @param int $hayatusSahabaId The hayatusSahabaData id
     *
     * @return void
     */
    public function validateHayatusSahabaUpdate(int $hayatusSahabaId, array $data): void
    {
        if (!$this->repository->existsHayatusSahabaId($hayatusSahabaId)) {
            throw new ValidationException(sprintf('HayatusSahaba not found: %s', $hayatusSahabaId));
        }

        $this->validateHayatusSahaba($data);
    }

    /**
     * Validate new HayatusSahaba.
     *
     * @param array<mixed> $data The data
     *
     * @throws ValidationException
     *
     * @return void
     */
    public function validateHayatusSahaba(array $data): void
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
            ->integer('book_id', 'Book Id should be positive integer')
            ->integer('chapter_id', 'Chapter id should be positive integer')
            ->minLength('chapter_name', 5, 'Too short')
            ->minLength('description', 5, 'Too short');
    }
}
