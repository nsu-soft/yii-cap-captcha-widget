<?php

namespace app\forms;

use yii\base\Model;

class TestForm extends Model
{
    /**
     * @var string|null
     */
    public ?string $text = null;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['text'], 'string'],
        ];
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        return true;
    }
}