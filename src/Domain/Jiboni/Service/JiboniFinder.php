<?php

namespace App\Domain\Jiboni\Service;

use App\Domain\Jiboni\Data\JiboniData;
use App\Domain\Jiboni\Repository\JiboniFinderRepository;

/**
 * Service.
 */
final class JiboniFinder
{
    private JiboniFinderRepository $repository;

    /**
     * The constructor.
     *
     * @param JiboniFinderRepository $repository The repository
     */
    public function __construct(JiboniFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find jibonis.
     *
     * @param array<mixed> $params The parameters
     *
     * @return JiboniData[] A list of jibonis
     */
    public function findJibonis(array $params): array
    {
        return $this->repository->findJibonis($params);
    }
}