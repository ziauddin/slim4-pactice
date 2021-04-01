<?php

namespace App\Domain\HayatusSahabaChapter\Service;

use App\Domain\HayatusSahabaChapter\Data\HayatusSahabaChapterData;
use App\Domain\HayatusSahabaChapter\Repository\HayatusSahabaChapterRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class HayatusSahabaChapterCreator
{
    private HayatusSahabaChapterRepository $repository;

    private HayatusSahabaChapterValidator $hayatusSahabaChapterValidator;

    private LoggerInterface $logger;

    /**
     * The constructor.
     *
     * @param HayatusSahabaChapterRepository $repository The repository
     * @param HayatusSahabaChapterValidator $hayatusSahabaChapterValidator The validator
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(
        HayatusSahabaChapterRepository $repository,
        HayatusSahabaChapterValidator $hayatusSahabaChapterValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->hayatusSahabaChapterValidator = $hayatusSahabaChapterValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('hayatusSahabaChapter_creator.log')
            ->createLogger();
    }

    /**
     * Create a new hayatusSahabaChapter.
     *
     * @param array<mixed> $data The form data
     *
     * @return int The new hayatusSahabaChapter ID
     */
    public function createHayatusSahabaChapter(array $data): int
    {
        // Input validation
        $this->hayatusSahabaChapterValidator->validateHayatusSahabaChapter($data);

        // Map form data to hayatusSahabaChapter DTO (model)
        $hayatusSahabaChapter = new HayatusSahabaChapterData($data);

        // Insert hayatusSahabaChapter and get new hayatusSahabaChapter ID
        $hayatusSahabaChapterId = $this->repository->insertHayatusSahabaChapter($hayatusSahabaChapter);

        // Logging
        $this->logger->info(sprintf('HayatusSahabaChapter created successfully: %s', $hayatusSahabaChapterId));

        return $hayatusSahabaChapterId;
    }
}
