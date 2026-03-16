<?php

namespace NsuSoft\Captcha;

use yii\base\InvalidArgumentException;
use yii\base\Widget;

class CapWidget extends Widget
{
    /**
     * @var string|null Cap Captcha API endpoint like http://<your-instance>/<site-key>
     */
    public ?string $endpoint = null;

    // TODO: add 'onSolve' event for JS

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        $this->checkEndpoint();
    }

    /**
     * Checks endpoint is specified.
     * @return void
     */
    private function checkEndpoint(): void
    {
        if (is_null($this->endpoint)) {
            throw new InvalidArgumentException("Cap Captcha API endpoint wasn't specified.");
        }
    }

    /**
     * @inheritDoc
     */
    public function run(): string
    {
        return $this->render('index', [
            'endpoint' => $this->endpoint,
        ]);
    }
}