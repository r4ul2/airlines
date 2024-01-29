<?php



namespace Symfony\Component\HttpKernel\HttpCache;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


interface StoreInterface
{
   
    public function lookup(Request $request): ?Response;

    public function write(Request $request, Response $response): string;

    /**
     * Invalidates all cache entries that match the request.
     *
     * @return void
     */
    public function invalidate(Request $request);

    /**
     * Locks the cache for a given Request.
     *
     * @return bool|string true if the lock is acquired, the path to the current lock otherwise
     */
    public function lock(Request $request): bool|string;

    /**
     * Releases the lock for the given Request.
     *
     * @return bool False if the lock file does not exist or cannot be unlocked, true otherwise
     */
    public function unlock(Request $request): bool;

    /**
     * Returns whether or not a lock exists.
     *
     * @return bool true if lock exists, false otherwise
     */
    public function isLocked(Request $request): bool;

    /**
     * Purges data for the given URL.
     *
     * @return bool true if the URL exists and has been purged, false otherwise
     */
    public function purge(string $url): bool;

    /**
     * Cleanups storage.
     *
     * @return void
     */
    public function cleanup();
}
