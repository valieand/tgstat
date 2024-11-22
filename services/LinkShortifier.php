<?php

declare(strict_types=1);

namespace app\services;

use Yii;
use Exception;
use Throwable;
use app\models\Link;
use app\services\IdHashCoder;
use yii\base\BaseObject;
use yii\helpers\Url;

/**
 * LinkShortifier is the service that shortifies links.
 */
class LinkShortifier extends BaseObject
{
    /** Max attempts allowed to fallback */
    private const MAX_ATTEMPTS = 5;

    public function __construct(private readonly string $link, private readonly IdHashCoder $coder, $config = [])
    {
        return parent::__construct($config);
    }

    /**
     * Generated short link and saves together with original link in storage.
     *
     * @return string
     */
    public function generateShortLink(): string
    {
        $id = rand(1, IdHashCoder::MAX_IDS);
        $hash = $this->coder->encode($id);

        $attempts = 0;
        do {
            try {
                $model = new Link([
                    'id' => $id,
                    'hash' => $hash,
                    'original' => $this->link,
                ]);
                if (!$model->save()) {
                    throw new Exception("Failed to save.");
                }
                break;
            } catch (Throwable $t) {
                $id = $this->findFallbackId();
            }
            $attempts++;
        } while ($attempts < self::MAX_ATTEMPTS);

        return Url::base(true) . '/' . $hash;
    }

    /**
     * Finds free ids in db and randomly returns one of them.
     *
     * @return int
     */
    protected function findFallbackId(): int
    {
        $freeIds = Yii::$app->db->createCommand(
            "SELECT id + 1 as nextId FROM link WHERE NOT EXISTS (SELECT 1 FROM link t2 WHERE t2.id = link.id + 1) limit 100"
        )->queryColumn();

        if (!$freeIds) {
            throw new Exception("No more free ids.");
        }
        if (count($freeIds) === 1 && $freeIds[0] == IdHashCoder::MAX_IDS) {
            throw new Exception("No more free ids.");
        }

        return $freeIds[array_rand($freeIds)];
    }
}
