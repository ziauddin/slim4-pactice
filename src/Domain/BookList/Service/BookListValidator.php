<?php

namespace App\Domain\BookList\Service;

use App\Domain\BookList\Repository\BookListRepository;
use App\Factory\ValidationFactory;
use Cake\Validation\Validator;
use Selective\Validation\Exception\ValidationException;

/**
 * Service.
 */
final class BookListValidator
{
    private BookListRepository $repository;

    private ValidationFactory $validationFactory;

    /**
     * The constructor.
     *
     * @param BookListRepository $repository The repository
     * @param ValidationFactory $validationFactory The validation
     */
    public function __construct(BookListRepository $repository, ValidationFactory $validationFactory)
    {
        $this->repository = $repository;
        $this->validationFactory = $validationFactory;
    }

    /**
     * Validate update.
     *
     * @param int $bookListId The user id
     * @param array<mixed> $data The data
     *
     * @return void
     */
    public function validateBookListUpdate(int $bookListId, array $data): void
    {
        if (!$this->repository->existsBookListId($bookListId)) {
            throw new ValidationException(sprintf('BookList not found: %s', $bookListId));
        }

        $this->validateBookList($data);
    }

    /**
     * Validate new bookList.
     *
     * @param array<mixed> $data The data
     *
     * @throws ValidationException
     *
     * @return void
     */
    public function validateBookList(array $data): void
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
            ->notEmptyString('book_name', 'Input is required');
    }
}
