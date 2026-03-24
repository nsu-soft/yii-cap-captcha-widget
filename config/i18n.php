<?php

return [
    'sourcePath' => dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'src',
    'languages' => [
        'en-US',
        'ru-RU',
    ],
    'translator' => '$this->t',
    'sort' => true,
    'removeUnused' => false,
    'markUnused' => true,
    'only' => ['*.php'],
    'except' => [
        '.gitignore',
        '.gitkeep',
        '/messages',
    ],
    'format' => 'php',
    'messagePath' => dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'messages',
    'overwrite' => true,
    'ignoreCategories' => [
        'yii',
        'manual',
    ],
];
