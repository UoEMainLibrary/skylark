<?php

namespace App\Services;

use App\Contracts\RepositoryInterface;
use InvalidArgumentException;

class RepositoryFactory
{
    /**
     * Create a repository service instance based on the repository type
     *
     * @param  string|null  $repositoryType  The repository type ('dspace' or 'archivesspace')
     *
     * @throws InvalidArgumentException
     */
    public function make(?string $repositoryType = null): RepositoryInterface
    {
        $repositoryType = $repositoryType ?? config('skylight.repository_type', 'dspace');

        return match ($repositoryType) {
            'dspace' => app(DSpaceService::class),
            'archivesspace' => app(ArchivesSpaceService::class),
            default => throw new InvalidArgumentException("Unsupported repository type: {$repositoryType}"),
        };
    }

    /**
     * Get the repository service for the current collection
     */
    public function current(): RepositoryInterface
    {
        return $this->make(config('skylight.repository_type'));
    }
}
