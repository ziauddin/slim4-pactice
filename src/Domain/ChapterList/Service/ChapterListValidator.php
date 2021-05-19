<?php

namespace App\Domain\ChapterList\Service;

use App\Domain\ChapterList\Repository\ChapterListRepository;
use App\Factory\ValidationFactory;
use Cake\Validation\Validator;
use Selective\Validation\Exception\ValidationException;

/**
 * Service.
 */
final class ChapterListValidator
{
    private ChapterListRepository $repository;

    private ValidationFactory $validationFactory;

    /**
     * The constructor.
     *
     * @param ChapterListRepository $repository The repository
     * @param ValidationFactory $validationFactory The validation
     */
    public function __construct(ChapterListRepository $repository, ValidationFactory $validationFactory)
    {
        $this->repository = $repository;
        $this->validationFactory = $validationFactory;
    }

    /**
     * Validate update.
     *
     * @param int $chapterListId The user id
     * @param array<mixed> $data The data
     *
     * @return void
     */
    public function validateChapterListUpdate(int $chapterListId, array $data): void
    {
        if (!$this->repository->existsChapterListId($chapterListId)) {
            throw new ValidationException(sprintf('ChapterList not found: %s', $chapterListId));
        }

        $this->validateChapterList($data);
    }

    /**
     * Validate new chapterList.
     *
     * @param array<mixed> $data The data
     *
     * @throws ValidationException
     *
     * @return void
     */
    public function validateChapterList(array $data): void
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
            ->integer('volume_id', 'Input required to be an integer')
            ->notEmptyString('book_name', 'Input required')
            ->integer('chapter_id', 'Input required')
            ->notEmptyString('chapter_name', 'Input required');
    }
}
