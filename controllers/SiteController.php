<?php

namespace app\controllers;

use Throwable;
use Yii;
use app\models\HashForm;
use app\models\LinkForm;
use app\services\LinkRestorer;
use app\services\LinkShortifier;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Сократитель ссылок.
     *
     * @return Response|string
     */
    public function actionIndex()
    {
        $form = new LinkForm();

        $link = $form->load(Yii::$app->request->post()) && $form->validate()
            ? Yii::createObject(LinkShortifier::class, [$form->link])->generateShortLink()
            : null;

        return $this->render('index', [
            'model' => $form,
            'shortLink' => $link,
        ]);
    }

    /**
     * Восстановитель ссылок.
     *
     * @return Response|string
     */
    public function actionRestorer($hash)
    {
        $form = new HashForm(['hash' => $hash]);

        if (!$form->validate()) {
            throw new BadRequestHttpException("Invalid link.");
        }

        try {
            $link = Yii::createObject(LinkRestorer::class, [$form->hash])->restoreLink();
        } catch (Throwable $t) {
            throw new NotFoundHttpException("Original link not found.");
        }

        $this->redirect($link);
    }
}
