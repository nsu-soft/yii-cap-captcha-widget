<?php

namespace NsuSoft\Captcha;

use NsuSoft\Captcha\Assets\CapWidgetClientAsset;
use yii\base\InvalidArgumentException;
use yii\base\Widget;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

class CapWidget extends Widget
{
    /**
     * @var string|null Cap Captcha API endpoint like http://<your-instance>/<site-key>
     */
    public ?string $endpoint = null;

    /**
     * @var string|null JS function that is calling when captcha was solved.
     * 
     * ```
     * function (e) {
     *     const token = e.detail.token;
     *     // Handle the token as needed
     * }
     * ```
     */
    public ?string $onSolve = null;

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        $this->initEndpoint();
        $this->registerClientOptions();
    }

    /**
     * Checks endpoint is specified.
     * @return void
     */
    private function initEndpoint(): void
    {
        if (is_null($this->endpoint)) {
            throw new InvalidArgumentException("Cap Captcha API endpoint wasn't specified.");
        }

        $this->endpoint = rtrim($this->endpoint, '/');
    }

    /**
     * Registers JS options if they were specified.
     */
    private function registerClientOptions(): void
    {
        $options = $this->getClientOptions();

        if (empty($options)) {
            return;
        }
        
        $options['widgetId'] = $this->id;

        CapWidgetClientAsset::register($this->view);
        $this->view->registerJs('CapWidgetClient.addHandler(' . Json::htmlEncode($options) . ')', View::POS_END, $this->id);
    }

    /**
     * Gets all JS options.
     * @return array
     */
    private function getClientOptions(): array
    {
        $options = [];

        if (isset($this->onSolve)) {
            $options['onSolve'] = new JsExpression($this->onSolve);
        }

        return $options;
    }

    /**
     * @inheritDoc
     */
    public function run(): string
    {
        return $this->render('index', [
            'endpoint' => $this->endpoint,
            'id' => $this->id,
        ]);
    }
}