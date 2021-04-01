<?php

namespace App\Domain\HayatusSahabaChapter\Service;

use App\Domain\HayatusSahabaChapter\Data\HayatusSahabaChapterData;
use App\Domain\HayatusSahabaChapter\Repository\HayatusSahabaChapterRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class HayatusSahabaChapterUpdater
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
            ->addFileHandler('hayatusSahabaChapter_updater.log')
            ->createLogger();
    }

    /**
     * Update hayatusSahabaChapter.
     *
     * @param int $hayatusSahabaChapterId The hayatusSahabaChapter id
     * @param array<mixed> $data The request data
     *
     * @return void
     */
    public function updateHayatusSahabaChapter(int $hayatusSahabaChapterId, array $data): void
    {
        // Input validation
        $this->hayatusSahabaChapterValidator->validateHayatusSahabaChapterUpdate($hayatusSahabaChapterId, $data);

        // Map form data to row
        $hayatusSahabaChapter = new HayatusSahabaChapterData($data);
        $hayatusSahabaChapter->id = $hayatusSahabaChapterId;

        // Insert hayatusSahabaChapter
        $this->repository->updateHayatusSahabaChapter($hayatusSahabaChapter);

        // Logging
        $this->logger->info(sprintf('HayatusSahabaChapter updated successfully: %s', $hayatusSahabaChapterId));
    }
}
