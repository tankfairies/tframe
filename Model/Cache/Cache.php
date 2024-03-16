<?php
/**
 * Copyright (c) 2019 Tankfairies
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/tankfairies/tframe
 */

namespace Tankfairies\Model\Cache;

use Tankfairies\Model\Service\DBConn;
use Exception;

/**
 * Class Cache
 * @package Model\Cache
 */
class Cache
{
    /**
     * @var DBConn
     */
    private DBConn $dbCache;

    /**
     * Cache constructor.
     */
    public function __construct()
    {
        $this->dbCache = new DBConn();
        $statement = $this->dbCache->prepare(
            "create table if not exists cache
            (
                id text not null constraint cache_pk primary key,
                data text not null,
                ttl  int  not null
            );"
        );
        $statement->execute();
    }

    /**
     * Checks and returns the cache data if available.
     *
     * @param string $id
     * @return string
     */
    public function check(string $id): string
    {
        try {
            $this->clearOldData();

            $statement = $this->dbCache->prepare(
                "SELECT data FROM cache WHERE id = :id AND ttl > strftime('%s', 'now')"
            );
            $statement->bindParam('id', $id);
            $result = $statement->execute();

            if (!$data = $result->fetchArray()) {
                throw new Exception();
            }

            return $data[0];
        } catch (Exception $exception) {
            return '';
        }
    }

    /**
     * Updates the cache.
     *
     * @param string $id
     * @param string $data
     * @param int $seconds
     */
    public function upsert(string $id, string $data, int $seconds = 5): void
    {
        $ttl = time()+$seconds;

        $statement = $this->dbCache->prepare("REPLACE INTO cache(id, data, ttl) VALUES (:id, :data, :ttl);");
        $statement->bindParam('id', $id);
        $statement->bindParam('data', $data);
        $statement->bindParam('ttl', $ttl);
        $statement->execute();

        $this->clearOldData();
    }

    private function clearOldData()
    {
        $statement = $this->dbCache->prepare(
            "DELETE FROM cache WHERE ttl < strftime('%s', 'now')"
        );
        $statement->execute();
    }
}
