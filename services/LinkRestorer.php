<?php

declare(strict_types=1);

namespace app\services;

use app\models\Link;
use app\services\IdHashCoder;
use yii\base\BaseObject;
use yii\base\InvalidArgumentException;

/**
 * LinkRestorer is the service that restores links.
 */
class LinkRestorer extends BaseObject
{
    public function __construct(private readonly string $hash, private readonly IdHashCoder $coder, $config = [])
    {
        return parent::__construct($config);
    }

    /**
     * Return original link from hash.
     *
     * @return string
     */
    public function restoreLink(): string
    {
        $id = $this->coder->decode($this->hash);

        $model = Link::findOne($id);

        if (!$model) {
            throw new InvalidArgumentException("Link does not exist.");
        }

        return $model->original;
    }
}
