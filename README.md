# yii-cap-captcha-widget

[На русском](docs/ru-RU/README.md)

[![License](https://img.shields.io/badge/license-BSD--3--Clause-blue.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D%208.3-8892BF.svg?logo=php)](https://php.net)
[![Yii Version](https://img.shields.io/badge/yii-~2.0.50-E47B44.svg?logo=yii)](https://www.yiiframework.com)
[![Status](https://img.shields.io/badge/status-develop-yellow.svg)](../../tree/develop)

> ⚠️ **Notice**: This package is under active development (`develop` branch). **Do not use in production**. The API and functionality are subject to change without prior notice.

---

## 📑 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Requirements](#-requirements)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Usage](#-usage)
- [Quick Start with Docker](#-quick-start-with-docker)
- [Widget Properties Reference](#-widget-properties-reference)
- [Testing](#-testing)
- [Project Structure](#-project-structure)
- [Integration with yii-cap-captcha](#-integration-with-yii-cap-captcha)
- [Security](#-security)
- [Contributing](#-contributing)
- [License](#-license)

---

## 📋 Overview

**yii-cap-captcha-widget** is a Yii2 view widget that provides seamless integration of the **[Cap Captcha](https://capjs.js.org)** client-side widget into your Yii2 application forms. It renders the CAPTCHA challenge interface and handles token generation using the official `@cap.js/widget` NPM package.

This widget works in conjunction with the **[yii-cap-captcha](https://github.com/nsu-soft/yii-cap-captcha)** server-side component to provide complete bot protection: the widget handles client-side challenge display and token generation, while the companion package validates tokens on the server. Or you can use your own solution to validate tokens on the server. It's up to you.

---

## ✨ Features

- 🧩 **Native Yii2 Widget**: Drop-in component following Yii2 widget conventions (`CapWidget::widget()`).
- 🔐 **Cap Captcha Integration**: Renders the official Cap widget with full configuration support.
- ⚙️ **Flexible Configuration**: Customize endpoint, callback handlers, and widget options via PHP properties.
- 🎨 **Asset Management**: Automatic registration of required JS assets via Yii2 AssetBundle.
- 🔄 **Event-Driven**: Support for `onSolve` JavaScript callback to handle token submission.
- 🐳 **Docker-Ready**: Pre-configured environment for local development and testing.
- 🧪 **Tested**: Includes Codeception test suite for functional and unit testing.

---

## 🔧 Requirements

| Component | Version | Description |
|-----------|---------|-------------|
| **PHP** | `>= 8.3` | Required PHP version |
| **Yii Framework** | `~2.0.50` | Yii2 web application framework |

### Optional (Recommended)

| Component | Version | Description |
|-----------|---------|-------------|
| **nsu-soft/yii-cap-captcha** | `^3.0` | Server-side component for token validation |

---

## 📦 Installation

If you don't have Composer, you may install it by [following instruction](https://getcomposer.org/doc/00-intro.md).

Install the package via Composer:

```bash
composer require nsu-soft/yii-cap-captcha-widget
```

Install the server-side validation package, if you don't have your own solution. See the [following instruction](https://github.com/nsu-soft/yii-cap-captcha?tab=readme-ov-file#-installation).

---

## ⚙️ Configuration

If you use `nsu-soft/yii-cap-captcha` package, configure it by [following instruction](https://github.com/nsu-soft/yii-cap-captcha?tab=readme-ov-file#%EF%B8%8F-configuration)

---

## 💻 Usage

### Basic Widget Rendering

Render the widget directly in your Yii2 view file:

```php
<?php

$cap = Yii::$app->captcha;

echo NsuSoft\Captcha\CapWidget::widget([
    'endpoint' => $cap->getEndpoint(),
]);
```

If you don't use `nsu-soft/yii-cap-captcha` package, you can specify properties manually:

```php
<?php

echo NsuSoft\Captcha\CapWidget::widget([
    // Cap Captcha server URI. Replace {siteKey} with a real site key.
    'endpoint' => 'http://localhost:3000/{siteKey}',
]);
```

### With Custom Callback

```php
<?php

echo NsuSoft\Captcha\CapWidget::widget([
    // Cap Captcha server URL. Replace {siteKey} with a real site key.
    'endpoint' => 'http://localhost:3000/{siteKey}',
    
    // Optional: custom HTML id
    'id' => 'my-captcha-widget',

    // Optional: use this event, if CapWidget is places out of the <form> tag.
    // If CapWidget placed inside the <form> tag, token will be added in request
    // in a field 'cap-token' automatically.
    'onSolve' => 'function(e) {
        const token = e.detail.token;
        document.getElementById("captcha-token").value = token;
        document.getElementById("my-form").submit();
    }',
]);
```

### Full Example: Login Form with Captcha

```php
<?php

use NsuSoft\Captcha\CapWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'login-form',
]);
?>

<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<!-- Render Cap Widget -->
<?= CapWidget::widget([
    'endpoint' => Yii::$app->captcha->getEndpoint(),
]) ?>

<div class="form-group">
    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
</div>

<?php ActiveForm::end(); ?>
```

---

## 🚀 Quick Start with Docker

The project includes `docker-compose.yml` for local development with a Cap Captcha server.

### Start Services

```bash
docker-compose up -d
```

### Access Points

| Service | URL | Description |
|---------|-----|-------------|
| 🌐 Cap Server | `http://localhost:3000` | Cap Captcha API endpoint |
| 📚 Swagger UI | `http://localhost:3000/swagger` | Interactive API documentation |
| 🔑 Admin Key | `o65imtWzvXDerEAt` | Default admin key (change in production) |

---

## ⚙️ Widget Properties Reference

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `endpoint` | `string` | `null` | **Required**. URI of the Cap Captcha server (e.g., `http://localhost:3000/{siteKey}`). |
| `disableHaptics` | `bool\|null` | `null` | Disable haptics. |
| `hiddenFieldName` | `string` | `cap-token` | Cap Captcha hidden field name, where cap token was saved, when captcha was solved. |
| `id` | `string\|null` | auto-generated | HTML `id` attribute for the widget container. |
| `language` | `string\|null` | `null` | The language in which to display the widget's messages. If not specified, the system language is used. |
| `onSolve` | `string\|null` | `null` | JavaScript function (as string) called when captcha is solved. Receives `CustomEvent` with `detail.token`. |
| `translationsPath` | `string` | `widgets/cap` | Message category patterns for Application::$i18n->translations. |
| `troubleshootingUrl` | `string` | `https://capjs.js.org/guide/troubleshooting/instrumentation.html` | Troubleshooting URI. |
| `workerCount` | `int\|null` | `null` | Workers count. Using all available cores to solving captcha, if it's not specified. |

### `onSolve` Callback Example

The `onSolve` property accepts a JavaScript function as a string. The function receives a `CustomEvent` with a `detail` object containing the solved token:

```javascript
function(e) {
    // e.detail.token contains the solved captcha token
    const token = e.detail.token;
    
    // Example: store in hidden field
    document.getElementById('captcha-token').value = token;
    
    // Example: submit form
    document.getElementById('my-form').submit();
}
```

---

## 🧪 Testing

The project uses **Codeception** for testing.

### Run Tests Locally

```bash
# Install dependencies
composer install --dev

# Run all test suites
vendor/bin/codecept run

# Run with verbose output
vendor/bin/codecept run --verbose

# Run functional tests only
vendor/bin/codecept run Functional
```

### Run Tests in Docker

```bash
docker-compose run --rm php vendor/bin/codecept run
```

### Configuration Files

| File | Purpose |
|------|---------|
| `codeception.yml` | Main Codeception configuration |
| `config/test.php` | Test environment application config |
| `tests/Support/` | Helper classes and fixtures |

---

## 🗂 Project Structure

```
yii-cap-captcha-widget/
├── src/
│   └── CapWidget.php              # Main widget class
├── views/                         # Directory fo test purpose
├── web/                           # Directory fo test purpose
├── config/
│   └── test.php                   # Test configuration
├── controllers/                   # Example controllers for testing
├── forms/                         # Example form models
├── tests/
│   ├── Unit/                      # Unit tests
│   ├── Functional/                # Integration tests
│   └── Support/                   # Test helpers
├── bin/                           # Docker helper scripts
├── composer.json                  # Dependencies and autoloading
├── docker-compose.yml             # Docker orchestration
├── codeception.yml                # Codeception configuration
├── LICENSE                        # BSD-3-Clause license
└── README.md                      # This file
```

---

## 🔗 Integration with yii-cap-captcha

For complete captcha protection, combine this widget with the **[yii-cap-captcha](https://github.com/nsu-soft/yii-cap-captcha)** server-side component.

---

## ⚠️ Error Handling

### Common Issues

| Issue | Solution |
|-------|----------|
| Cap Captcha API endpoint wasn't specified | Ensure `endpoint` property is set in widget config |
| Widget not rendering | Check that `npm-asset/cap.js--widget` is installed and assets are published |
| Token validation fails | Verify server-side `secretKey` matches the one registered with Cap server |
| CORS errors | Configure Cap server to allow requests from your domain |

### Debugging Tips

1. Enable Yii2 debug mode to inspect asset loading:
   ```php
   'components' => [
       'assetManager' => [
           'appendTimestamp' => true,
       ],
   ],
   ```

2. Check browser console for Cap widget errors.

3. Log server-side validation requests:
   ```php
   Yii::info("Captcha token received: " . $model->captchaToken);
   ```

---

## 🔐 Security

> ⚠️ **Critical Guidelines**

1. **Never expose `secretKey` in client-side code**  
   The widget only handles client-side token generation. Server-side validation must use the `yii-cap-captcha` component with a secure `secretKey`.

2. **Validate tokens server-side**  
   Always verify captcha tokens on the server using `Cap::siteVerify()` before processing sensitive actions.

3. **Use HTTPS in production**  
   Configure `endpoint` with `https://` when deploying to production.

4. **Rotate keys regularly**  
   Use the Cap server's key rotation features and update your configuration securely.

5. **Rate-limit validation endpoints**  
   Protect your server-side validation route from abuse.

---

## 🤝 Contributing

We welcome contributions!

### 📋 Code Standards

- Follow **[PSR-12](https://www.php-fig.org/psr/psr-12/)** coding style.
- Document public methods using **PHPDoc**.
- Add tests for new features or bug fixes.
- Use [Conventional Commits](https://www.conventionalcommits.org/) for commit messages.

### 🔄 Pull Request Process

1. Fork the repository.
2. Create a feature branch:
   ```bash
   git checkout -b feature/your-feature-name
   ```
3. Make changes and add tests.
4. Run tests:
   ```bash
   vendor/bin/codecept run
   ```
5. Update documentation if needed.
6. Submit PR to `develop` branch.

---

## 📄 License

This project is open-source software licensed under the **BSD-3-Clause License**.  
See the [LICENSE](LICENSE) file for details.