<?PHP
namespace App\Services\Cache;

use App\Model\Database\DatabaseModel;
use Predis\Client;

class CurrencyCacheService
{
    private Client $redis;
    private DatabaseModel $database;
    public function __construct(Client $redis, DatabaseModel $database)
    {
        $this->redis = $redis;
        $this->database = $database;
    }

    //Get or Set Redis cached data
    public function getOrSetCache(string $cacheKey, callable $callback, int $ttl = 300):mixed
    {
        $cachedData = $this->redis->get($cacheKey);

        $lastUpdateDateKey = $cacheKey . ':updated_at';
        $cachedKeyLastUpdateDate = $this->redis->get($lastUpdateDateKey);

        $histTableLastUpdateDate = $this->database->getHistLastUpdateDate();


        if (!$cachedData || $cachedKeyLastUpdateDate < $histTableLastUpdateDate) {
            $data = $callback();

            if (!empty($data)) {
                $this->redis->setex($cacheKey, $ttl, json_encode($data));
                $this->redis->setex($lastUpdateDateKey, $ttl, $lastUpdateDateKey);
            }

            return $data;
        }

        return json_decode($cachedData, true);
    }
}
