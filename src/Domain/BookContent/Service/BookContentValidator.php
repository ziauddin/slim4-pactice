<?php

namespace App\Domain\BookContent\Service;

use App\Domain\BookContent\Repository\BookContentRepository;
use App\Factory\ValidationFactory;
use Cake\Validation\Validator;
use Selective\Validation\Exception\ValidationException;

/**
 * Service.
 */
final class BookContentValidator
{
    private BookContentRepository $repository;

    private ValidationFactory $validationFactory;

    /**
     * The constructor.
     *
     * @param BookContentRepository $repository The repository
     * @param ValidationFactory $validationFactory The validation
     */
    public function __construct(BookContentRepository $repository, ValidationFactory $validationFactory)
    {
        $this->repository = $repository;
        $this->validationFactory = $validationFactory;
    }

    /**
     * Validate update.
     *
     * @param int $bookContentId The user id
     * @param array<mixed> $data The data
     *
     * @return void
     */
    public function validateBookContentUpdate(int $bookContentId, array $data): void
    {
        if (!$this->repository->existsBookContentId($bookContentId)) {
            throw new ValidationException(sprintf('BookContent not found: %s', $bookContentId));
        }

        $this->validateBookContent($data);
    }

    /**
     * Validate new bookContent.
     *
     * @param array<mixed> $data The data
     *
     * @throws ValidationException
     *
     * @return void
     */
    public function validateBookContent(array $data): void
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
            ->integer('volume_id', 'Input is required')
            ->integer('chapter_id', 'Input is required')
            ->notEmptyString('chapter_name', 'Input is required')
            ->notEmptyString('description', 'Input is required');
    }
}
