<?php

namespace NsuSoft\Captcha;

use NsuSoft\Captcha\Assets\CapWidgetClientAsset;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Widget;
use yii\helpers\Json;
use yii\i18n\PhpMessageSource;
use yii\web\JsExpression;
use yii\web\View;

class CapWidget extends Widget
{
    /**
     * Default CSS variables.
     */
    const DEFAULT_CSS_VARS = [
        '--cap-background' => '#fdfdfd',
        '--cap-border-color' => '#dddddd8f',
        '--cap-border-radius' => '14px',
        '--cap-checkbox-background' => '#fafafa91',
        '--cap-checkbox-border' => '1px solid #aaaaaad1',
        '--cap-checkbox-border-radius' => '6px',
        '--cap-checkbox-margin' => '2px',
        '--cap-checkbox-size' => '25px',
        '--cap-checkmark' => 'url("data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cstyle%3E%40keyframes%20anim%7B0%25%7Bstroke-dashoffset%3A23.21320343017578px%7Dto%7Bstroke-dashoffset%3A0%7D%7D%3C%2Fstyle%3E%3Cpath%20fill%3D%22none%22%20stroke%3D%22%2300a67d%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%222%22%20d%3D%22m5%2012%205%205L20%207%22%20style%3D%22stroke-dashoffset%3A0%3Bstroke-dasharray%3A23.21320343017578px%3Banimation%3Aanim%20.5s%20ease%22%2F%3E%3C%2Fsvg%3E")',
        '--cap-color' => '#212121',
        '--cap-error-cross' => 'url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'96\' height=\'96\' viewBox=\'0 0 24 24\'%3E%3Cpath fill=\'%23f55b50\' d=\'M11 15h2v2h-2zm0-8h2v6h-2zm1-5C6.47 2 2 6.5 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2m0 18a8 8 0 0 1-8-8a8 8 0 0 1 8-8a8 8 0 0 1 8 8a8 8 0 0 1-8 8\'/%3E%3C%2Fsvg%3E")',
        '--cap-font' => 'system, -apple-system, "BlinkMacSystemFont", ".SFNSText-Regular", "San Francisco", "Roboto", "Segoe UI", "Helvetica Neue", "Lucida Grande", "Ubuntu", "arial", sans-serif',
        '--cap-gap' => '15px',
        '--cap-spinner-background-color' => '#eee',
        '--cap-spinner-color' => '#000',
        '--cap-spinner-thickness' => '3',
        '--cap-widget-height' => '58px',
        '--cap-widget-padding' => '14px',
        '--cap-widget-width' => 'auto',
    ];

    /**
     * @var string|null Required. Cap Captcha API endpoint like http://<your-instance>/<site-key>
     */
    public ?string $endpoint = null;

    /**
     * @var array CSS variables you want to redeclare.
     * Format: 
     * 
     * ```php
     * [
     *     '--cap-background' => '#fdfdfd',
     *     '--cap-border-color' => '#dddddd8f',
     *     // other variables...
     * ]
     * ```
     * @see CapWidget::DEFAULT_CSS_VARS
     */
    public array $cssVars = [];

    /**
     * @var bool|null Optional.
     */
    public ?bool $disableHaptics = null;

    /**
     * @var string Optional. Cap Captcha hidden field name, where cap token was saved,
     * when captcha was solved.
     */
    public string $hiddenFieldName = 'cap-token';

    /**
     * @var string|null Optional. The language in which to display the widget's messages. If not 
     * specified, the system language is used. Example: 'en-US' or 'ru-RU'.
     */
    public ?string $language = null;

    /**
     * @var string|null Optional. JS function that is calling when captcha was solved.
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
     * @var string Optional. Message category patterns for Application::$i18n->translations.
     */
    public string $translationsCategory = 'widgets/cap';

    /**
     * @var string Optional.
     */
    public string $troubleshootingUrl = 'https://capjs.js.org/guide/troubleshooting/instrumentation.html';

    /**
     * @var int|null Optional. Workers count. Using all available cores to solving captcha,
     * if it's not specified.
     */
    public ?int $workerCount = null;

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        $this->initEndpoint();
        $this->registerTranslations();
        $this->registerJsOptions();
        $this->registerCssVars();
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
     * Registers widget translations.
     * @return void
     */
    private function registerTranslations(): void
    {
        Yii::$app->i18n->translations["{$this->translationsCategory}/*"] = [
            'class' => PhpMessageSource::class,
            'sourceLanguage' => 'en-US',
            'basePath' => __DIR__ . '/messages',
            'fileMap' => [
                "{$this->translationsCategory}/main" => 'main.php',
            ],
        ];
    }

    /**
     * @see Yii::t()
     * @param string $category
     * @param string $message
     * @param array $params
     * @return string
     */
    private function t(string $category, string $message, array $params = []): string
    {
        return Yii::t("{$this->translationsCategory}/" . $category, $message, $params, $this->language);
    }

    /**
     * Registers JS options if they were specified.
     * @return void
     */
    private function registerJsOptions(): void
    {
        $options = $this->getJsOptions();

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
    private function getJsOptions(): array
    {
        $options = [];

        if (isset($this->onSolve)) {
            $options['onSolve'] = new JsExpression($this->onSolve);
        }

        return $options;
    }

    /**
     * Registers CSS varialbes.
     * @return void
     */
    private function registerCssVars(): void
    {
        $options = array_merge(self::DEFAULT_CSS_VARS, $this->cssVars);
        
        $css = ':root {' . PHP_EOL;

        foreach ($options as $variable => $value) {
            $css .= "{$variable}: $value;" . PHP_EOL;
        }

        $css .= '}' . PHP_EOL;

        $this->view->registerCss($css, [], 'cap-widget-css-vars');
    }

    /**
     * @inheritDoc
     */
    public function run(): string
    {
        return $this->render('index', [
            'options' => $this->getTagOptions(),
        ]);
    }

    /**
     * Gets <cap-widget> tag options.
     * @return array
     */
    private function getTagOptions(): array
    {
        $options = [
            'id' => $this->id,
            'data' => [
                'cap-api-endpoint' => $this->endpoint,
                'cap-hidden-field-name' => $this->hiddenFieldName,
                'cap-troubleshooting-url' => $this->troubleshootingUrl,
                'cap-i18n-error-aria-label' => $this->t('main', "An error occurred, please try again"),
                'cap-i18n-error-label' => $this->t('main', "Error"),
                'cap-i18n-initial-state' => $this->t('main', "Verify you're human"),
                'cap-i18n-solved-label' => $this->t('main', "You're a human"),
                'cap-i18n-troubleshooting-label' => $this->t('main', "Troubleshoot"),
                'cap-i18n-verified-aria-label' => $this->t('main', "We have verified you're a human, you may now continue"),
                'cap-i18n-verify-aria-label' => $this->t('main', "Click to verify you're a human"),
                'cap-i18n-verifying-aria-label' => $this->t('main', "Verifying you're a human, please wait"),
                'cap-i18n-verifying-label' => $this->t('main', "Verifying..."),
                'cap-i18n-wasm-disabled' => $this->t('main', "Enable WASM for significantly faster solving"),
            ],
        ];

        if (isset($this->disableHaptics)) {
            $options['data']['cap-disable-haptics'] = $this->disableHaptics;
        }

        if (isset($this->workerCount)) {
            $options['data']['cap-worker-count'] = $this->workerCount;
        }

        return $options;
    }
}