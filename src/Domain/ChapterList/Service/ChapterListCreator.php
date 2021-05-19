<?php

namespace App\Domain\ChapterList\Service;

use App\Domain\ChapterList\Data\ChapterListData;
use App\Domain\ChapterList\Repository\ChapterListRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class ChapterListCreator
{
    private ChapterListRepository $repository;

    private ChapterListValidator $chapterListValidator;

    private LoggerInterface $logger;

    /**
     * The constructor.
     *
     * @param ChapterListRepository $repository The repository
     * @param ChapterListValidator $chapterListValidator The validator
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(
        ChapterListRepository $repository,
        ChapterListValidator $chapterListValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->chapterListValidator = $chapterListValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('chapterList_creator.log')
            ->createLogger();
    }

    /**
     * Create a new chapterList.
     *
     * @param array<mixed> $data The form data
     *
     * @return int The new chapterList ID
     */
    public function createChapterList(array $data): int
    {
        // Input validation
        $this->chapterListValidator->validateChapterList($data);

        // Map form data to chapterList DTO (model)
        $chapterList = new ChapterListData($data);

        // Insert chapterList and get new chapterList ID
        $chapterListId = $this->repository->insertChapterList($chapterList);

        // Logging
        $this->logger->info(sprintf('ChapterList created successfully: %s', $chapterListId));

        return $chapterListId;
    }
}
