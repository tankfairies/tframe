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

/**
 * Class Cache
 *
 * @package Model\Cache
 */
class Cache
{
    /**
     * @var DBConn
     */
    private $dbCache;

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
        $result = $statement->execute();
    }

    /**
     * Checks and returns the cache data if available.
     *
     * @param $id
     * @return array
     */
    public function check($id)
    {
        try {
            $statement = $this->dbCache->prepare("SELECT data FROM cache WHERE id = :id AND ttl > strftime('%s', 'now')");
            $statement->bindParam('id', $id);
            $result = $statement->execute();
            return $result->fetchArray();
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
     * Retrieves the cache data is store.
     *
     * @param $id
     * @return array
     */
    public function fallback($id)
    {
        $statement = $this->dbCache->prepare("SELECT data FROM cache WHERE id = :id");
        $statement->bindParam('id', $id);
        $result = $statement->execute();
        return $result->fetchArray();
    }

    /**
     * Updates the cache.
     *
     * @param $id
     * @param $data
     */
    public function update($id, $data)
    {
        $json = json_encode($data);
        $ttl = time()+5;

        $statement = $this->dbCache->prepare("REPLACE INTO cache(id, data, ttl) VALUES (:id, :json, :ttl);");
        $statement->bindParam('id', $id);
        $statement->bindParam('json', $json);
        $statement->bindParam('ttl', $ttl);
        $statement->execute();
    }
}
