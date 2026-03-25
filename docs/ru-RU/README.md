# yii-cap-captcha-widget

[![License](https://img.shields.io/badge/license-BSD--3--Clause-blue.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D%208.3-8892BF.svg?logo=php)](https://php.net)
[![Yii Version](https://img.shields.io/badge/yii-~2.0.50-E47B44.svg?logo=yii)](https://www.yiiframework.com)
[![Status](https://img.shields.io/badge/status-develop-yellow.svg)](../../tree/develop)

> ⚠️ **Внимание**: Пакет находится в стадии активной разработки (`develop`). **Не используйте в продакшене**. API и функциональность могут изменяться без предупреждения.

---

## 📑 Оглавление

- [Обзор](#-обзор)
- [Возможности](#-возможности)
- [Требования](#-требования)
- [Установка](#-установка)
- [Настройка](#-настройка)
- [Использование](#-использование)
- [Быстрый старт с Docker](#-быстрый-старт-с-docker)
- [Справочник свойств виджета](#-справочник-свойств-виджета)
- [Тестирование](#-тестирование)
- [Структура проекта](#-структура-проекта)
- [Интеграция с yii-cap-captcha](#-интеграция-с-yii-cap-captcha)
- [Безопасность](#-безопасность)
- [Вклад в проект](#-вклад-в-проект)
- [Лицензия](#-лицензия)

---

## 📋 Обзор

**yii-cap-captcha-widget** — это виджет представления для фреймворка **Yii2**, обеспечивающий бесшовную интеграцию клиентского виджета **[Cap Captcha](https://capjs.js.org)** в формы вашего Yii2-приложения. Виджет отображает интерфейс капчи и обрабатывает генерацию токенов с использованием официального NPM-пакета `@cap.js/widget`.

Этот виджет работает в связке с серверным компонентом **[yii-cap-captcha](https://github.com/nsu-soft/yii-cap-captcha)** для обеспечения полной защиты от ботов: виджет отвечает за отображение челленджа и генерацию токена на клиенте, а серверный компонент валидирует токены на бэкенде. Или Вы можете использовать свое решение для валидации токенов на стороне сервера. Выбор за Вами.

---

## ✨ Возможности

- 🧩 **Нативный виджет Yii2**: Компонент «из коробки», следующий конвенциям Yii2 (`CapWidget::widget()`).
- 🔐 **Интеграция с Cap Captcha**: Отображает официальный виджет Cap с полной поддержкой конфигурации.
- ⚙️ **Гибкая настройка**: Настройка эндпоинта, обработчиков колбэков и опций виджета через свойства PHP.
- 🎨 **Управление ассетами**: Автоматическая регистрация необходимых JS через AssetBundle Yii2.
- 🔄 **Событийная модель**: Поддержка JavaScript-колбэка `onSolve` для обработки отправки токена.
- 🐳 **Готовность к Docker**: Преднастроенное окружение для локальной разработки и тестирования.
- 🧪 **Тестирование**: Включает набор тестов Codeception для функционального и юнит-тестирования.

---

## 🔧 Требования

| Компонент | Версия | Описание |
|-----------|--------|----------|
| **PHP** | `>= 8.3` | Требуемая версия PHP |
| **Yii Framework** | `~2.0.50` | Веб-фреймворк Yii2 |

### Опционально (рекомендуется)

| Компонент | Версия | Описание |
|-----------|--------|----------|
| **nsu-soft/yii-cap-captcha** | `^3.0` | Серверный компонент для валидации токенов |

---

## 📦 Установка

Если у Вас нет Composer, установите его по [этой инструкции](https://getcomposer.org/doc/00-intro.md).

Установите пакет через Composer:

```bash
composer require nsu-soft/yii-cap-captcha-widget
```

Установите пакет для проверки капчи на стороне сервера, если Вы не используете своё собственное решение. [Инструкция по установке](https://github.com/nsu-soft/yii-cap-captcha/tree/main/docs/ru-RU#-%D1%83%D1%81%D1%82%D0%B0%D0%BD%D0%BE%D0%B2%D0%BA%D0%B0).

---

## ⚙️ Настройка

Если Вы используете пакет `nsu-soft/yii-cap-captcha`, сконфигурируйте его по [этой инструкции](https://github.com/nsu-soft/yii-cap-captcha/tree/main/docs/ru-RU#%EF%B8%8F-%D0%BA%D0%BE%D0%BD%D1%84%D0%B8%D0%B3%D1%83%D1%80%D0%B0%D1%86%D0%B8%D1%8F)

---

## 💻 Использование

### Базовый рендер виджета

Отображение виджета в файлах из папки `views`:

```php
<?php

$cap = Yii::$app->captcha;

echo NsuSoft\Captcha\CapWidget::widget([
    'endpoint' => $cap->getEndpoint(),
]);
```

Если Вы не используете пакет `nsu-soft/yii-cap-captcha`, то можете задать свойства виджета вручную:

```php
<?php

echo NsuSoft\Captcha\CapWidget::widget([
    // URI сервера Cap Captcha. Замените {siteKey} на реальный ключ сайта.
    'endpoint' => 'http://localhost:3000/{siteKey}',
]);
```

### С пользовательским колбэком

```php
<?php

echo NsuSoft\Captcha\CapWidget::widget([
    // URI сервера Cap Captcha. Замените {siteKey} на реальный ключ сайта.
    'endpoint' => 'http://localhost:3000/{siteKey}',
    
    // Опционально: пользовательский HTML id
    'id' => 'my-captcha-widget',

    // Опционально: используйте это событие, если CapWidget находится вне тега <form>.
    // Если CapWidget находится внутри тега <form>, токен будет автоматически добавлен в запрос
    // в поле 'cap-token'.
    'onSolve' => 'function(e) {
        const token = e.detail.token;
        document.getElementById("captcha-token").value = token;
        document.getElementById("my-form").submit();
    }',
]);
```

### Полный пример: форма входа с капчей

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

## 🚀 Быстрый старт с Docker

Проект включает `docker-compose.yml` для локальной разработки с сервером Cap Captcha.

### Запуск сервисов

```bash
docker-compose up -d
```

### Точки доступа

| Сервис | URL | Описание |
|--------|-----|----------|
| 🌐 Сервер Cap | `http://localhost:3000` | Эндпоинт API Cap Captcha |
| 📚 Swagger UI | `http://localhost:3000/swagger` | Интерактивная документация API |
| 🔑 Admin Key | `o65imtWzvXDerEAt` | Ключ администратора по умолчанию (замените в продакшене) |

---

## ⚙️ Справочник свойств виджета

| Свойство | Тип | По умолчанию | Описание |
|----------|-----|--------------|----------|
| `endpoint` | `string` | `null` | **Обязательно**. URI сервера Cap Captcha (например, `http://localhost:3000/{siteKey}`). |
| `disableHaptics` | `bool\|null` | `null` | Отключить тактильные ощущения. |
| `hiddenFieldName` | `string` | `cap-token` | Имя скрытого поля Cap Captcha, в котором сохраняется токен капчи после ее разгадывания. |
| `id` | `string\|null` | автогенерация | HTML-атрибут `id` для контейнера виджета. |
| `language` | `string\|null` | `null` | На каком языке отображать сообщения виджета. Если не задано, то берется язык системы. Пример: 'en-US' или 'ru-RU'. |
| `onSolve` | `string\|null` | `null` | JavaScript-функция (в виде строки), вызываемая при успешном решении капчи. Получает `CustomEvent` с `detail.token`. |
| `translationsPath` | `string` | `widgets/cap` | Шаблоны категорий сообщений для Application::$i18n->translations. |
| `troubleshootingUrl` | `string` | `https://capjs.js.org/guide/troubleshooting/instrumentation.html` | URI для устранения неполадок. |
| `workerCount` | `int\|null` | `null` | Количество рабочих процессов. Используются все доступные ядра для решения капчи, если не указано иное. |

### Пример колбэка `onSolve`

Свойство `onSolve` принимает JavaScript-функцию в виде строки. Функция получает объект `CustomEvent`, содержащий в `detail` решённый токен:

```javascript
function(e) {
    // e.detail.token содержит токен решённой капчи
    const token = e.detail.token;
    
    // Пример: сохранить в скрытое поле
    document.getElementById('captcha-token').value = token;
    
    // Пример: отправить форму
    document.getElementById('my-form').submit();
}
```

---

## 🧪 Тестирование

Проект использует **Codeception** для тестирования.

### Запуск тестов локально

```bash
# Установка зависимостей
composer install --dev

# Запуск всех наборов тестов
vendor/bin/codecept run

# Запуск с подробным выводом
vendor/bin/codecept run --verbose

# Запуск только функциональных тестов
vendor/bin/codecept run Functional
```

### Запуск тестов в Docker

```bash
docker-compose run --rm php vendor/bin/codecept run
```

### Файлы конфигурации

| Файл | Назначение |
|------|------------|
| `codeception.yml` | Основная конфигурация Codeception |
| `config/test.php` | Конфигурация приложения для тестового окружения |
| `tests/Support/` | Вспомогательные классы и фикстуры |

---

## 🗂 Структура проекта

```
yii-cap-captcha-widget/
├── src/
│   └── CapWidget.php              # Основной класс виджета
├── views/                         # Директория для тестирования
├── web/                           # Директория для тестирования
├── config/
│   └── test.php                   # Конфигурация для тестов
├── controllers/                   # Примеры контроллеров для тестирования
├── forms/                         # Примеры моделей форм
├── tests/
│   ├── Unit/                      # Юнит-тесты
│   ├── Functional/                # Интеграционные тесты
│   └── Support/                   # Вспомогательные классы тестов
├── bin/                           # Docker-скрипты
├── composer.json                  # Зависимости и автозагрузка
├── docker-compose.yml             # Оркестрация Docker
├── codeception.yml                # Конфигурация Codeception
├── LICENSE                        # Лицензия BSD-3-Clause
└── README.md                      # Этот файл
```

---

## 🔗 Интеграция с yii-cap-captcha

Для полной защиты от ботов объедините этот виджет с серверным компонентом **[yii-cap-captcha](https://github.com/nsu-soft/yii-cap-captcha)**.

---

## ⚠️ Обработка ошибок

### Распространённые проблемы

| Проблема | Решение |
|----------|---------|
| Cap Captcha API endpoint wasn't specified | Убедитесь, что свойство `endpoint` задано в конфигурации виджета |
| Виджет не отображается | Проверьте, что установлен `npm-asset/cap.js--widget` и ассеты опубликованы |
| Валидация токена не проходит | Убедитесь, что серверный `secretKey` совпадает с зарегистрированным на сервере Cap |
| Ошибки CORS | Настройте сервер Cap для разрешения запросов с вашего домена |

### Советы по отладке

1. Включите режим отладки Yii2 для инспекции загрузки ассетов:
   ```php
   'components' => [
       'assetManager' => [
           'appendTimestamp' => true,
       ],
   ],
   ```

2. Проверьте консоль браузера на наличие ошибок виджета Cap.

3. Логируйте запросы валидации на сервере:
   ```php
   Yii::info("Получен токен капчи: " . $model->captchaToken);
   ```

---

## 🔐 Безопасность

> ⚠️ **Критически важные рекомендации**

1. **Никогда не передавайте `secretKey` в клиентский код**  
   Виджет отвечает только за генерацию токена на клиенте. Валидация токенов должна выполняться на сервере через компонент `yii-cap-captcha` с использованием защищённого `secretKey`.

2. **Всегда валидируйте токены на сервере**  
   Перед обработкой чувствительных действий обязательно проверяйте токены капчи через `Cap::siteVerify()`.

3. **Используйте HTTPS в продакшене**  
   Указывайте `endpoint` с префиксом `https://` при развёртывании в рабочую среду.

4. **Регулярно ротируйте ключи**  
   Используйте функции ротации ключей сервера Cap и безопасно обновляйте конфигурацию.

5. **Ограничьте частоту запросов к эндпоинту валидации**  
   Защитите серверный маршрут валидации от злоупотреблений.

---

## 🤝 Вклад в проект

Мы приветствуем вклад в развитие проекта!

### 📋 Стандарты кода

- Следуйте стилю кодирования **[PSR-12](https://www.php-fig.org/psr/psr-12/)**.
- Документируйте публичные методы в формате **PHPDoc**.
- Добавляйте тесты для новой функциональности или исправлений ошибок.
- Используйте [Conventional Commits](https://www.conventionalcommits.org/) для сообщений коммитов.

### 🔄 Процесс пул-реквеста

1. Создайте форк репозитория.
2. Создайте ветку для новой функции:
   ```bash
   git checkout -b feature/your-feature-name
   ```
3. Внесите изменения и добавьте тесты.
4. Запустите тесты:
   ```bash
   vendor/bin/codecept run
   ```
5. Обновите документацию при необходимости.
6. Отправьте пул-реквест в ветку `develop`.

---

## 📄 Лицензия

Этот проект распространяется как открытое программное обеспечение под лицензией **BSD-3-Clause**.  
Подробности см. в файле [../../LICENSE](LICENSE).