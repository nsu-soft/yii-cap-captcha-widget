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
     * @var string|null Required. Cap Captcha API endpoint like http://<your-instance>/<site-key>
     */
    public ?string $endpoint = null;

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
    public string $translationsPath = 'widgets/cap';

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
        Yii::$app->i18n->translations["{$this->translationsPath}/*"] = [
            'class' => PhpMessageSource::class,
            'sourceLanguage' => 'en-US',
            'basePath' => __DIR__ . '/messages',
            'fileMap' => [
                "{$this->translationsPath}/main" => 'main.php',
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
        return Yii::t("{$this->translationsPath}/" . $category, $message, $params, $this->language);
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