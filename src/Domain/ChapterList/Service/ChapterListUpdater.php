<?php

namespace App\Domain\ChapterList\Service;

use App\Domain\ChapterList\Data\ChapterListData;
use App\Domain\ChapterList\Repository\ChapterListRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class ChapterListUpdater
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
            ->addFileHandler('chapterList_updater.log')
            ->createLogger();
    }

    /**
     * Update chapterList.
     *
     * @param int $chapterListId The chapterList id
     * @param array<mixed> $data The request data
     *
     * @return void
     */
    public function updateChapterList(int $chapterListId, array $data): void
    {
        // Input validation
        $this->chapterListValidator->validateChapterListUpdate($chapterListId, $data);

        // Map form data to row
        $chapterList = new ChapterListData($data);
        $chapterList->id = $chapterListId;

        // Insert chapterList
        $this->repository->updateChapterList($chapterList);

        // Logging
        $this->logger->info(sprintf('ChapterList updated successfully: %s', $chapterListId));
    }
}
