<?php

declare(strict_types=1);

namespace app\services;

use yii\base\BaseObject;

/**
 * IdHashCoder is the service that shortifies links.
 */
class IdHashCoder extends BaseObject
{
    /** There are 1_073_741_824 options or 2^(6*5) */
    public const MAX_IDS = 1_073_741_824;

    /** Allowed symbols. Total 64. */
    protected const DICT = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz_-';

    /** Required hash length */
    protected const HASH_LENGTH = 5;

    /**
     * Encoded id to hash.
     *
     * @param  int    $id ID
     * @return string
     */
    public function encode(int $id): string
    {
        $int = $id - 1;
        $hash = '';

        do {
            $reminder = $int % 64;
            $int = (int) ($int / 64);
            $hash .= self::DICT[$reminder];
        } while ($int != 0);

        return str_pad($hash, self::HASH_LENGTH, '0', STR_PAD_LEFT);
    }

    /**
     * Decodes id from hash.
     *
     * @param  string $hash Hash
     * @return int
     */
    public function decode(string $hash): int
    {
        $int = 0;

        for ($i = 0; $i < self::HASH_LENGTH; $i++) {
            $int += strpos(self::DICT, $hash[$i]) * pow(64, $i);
        }

        return $int + 1;
    }
}
