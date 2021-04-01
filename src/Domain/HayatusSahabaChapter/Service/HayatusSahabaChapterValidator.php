<?php

namespace App\Domain\HayatusSahabaChapter\Service;

use App\Domain\HayatusSahabaChapter\Repository\HayatusSahabaChapterRepository;
use App\Factory\ValidationFactory;
use Cake\Validation\Validator;
use Selective\Validation\Exception\ValidationException;

/**
 * Service.
 */
final class HayatusSahabaChapterValidator
{
    private HayatusSahabaChapterRepository $repository;

    private ValidationFactory $validationFactory;

    /**
     * The constructor.
     *
     * @param HayatusSahabaChapterRepository $repository The repository
     * @param ValidationFactory $validationFactory The validation
     */
    public function __construct(HayatusSahabaChapterRepository $repository, ValidationFactory $validationFactory)
    {
        $this->repository = $repository;
        $this->validationFactory = $validationFactory;
    }

    /**
     * Validate update.
     *
     * @param int $HayatusSahabaChapterId The user id
     * @param array<mixed> $data The data
     *
     * @return void
     */
    public function validateHayatusSahabaChapterUpdate(int $HayatusSahabaChapterId, array $data): void
    {
        if (!$this->repository->existsHayatusSahabaChapterId($HayatusSahabaChapterId)) {
            throw new ValidationException(sprintf('HayatusSahabaChapter not found: %s', $HayatusSahabaChapterId));
        }

        $this->validateHayatusSahabaChapter($data);
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
    public function validateHayatusSahabaChapter(array $data): void
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
            ->integer('book_id', 'Input required')
            ->notEmptyString('book_name', 'Input required')
            ->integer('chapter_id', 'Input required')
            ->notEmptyString('chapter_name', 'Chapter Name is required')
            ->notEmptyString('page_bn', 'Page Count in bangali is required')
            ->integer('page_bn', 'Page Count in english is required');
    }
}
