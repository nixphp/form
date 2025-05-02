<?php

namespace PHPico\Form\Core;

class Validator
{
    protected array $data = [];
    protected array $rules = [];
    protected array $errors = [];

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->validate();
    }

    protected function validate(): void
    {
        foreach ($this->rules as $fieldName => $rules) {

            $rulesArray = explode('|', $rules);

            foreach ($rulesArray as $rule) {
                $parameters = null;

                if (str_contains($rule, ':')) {
                    [$rule, $parameters] = explode(':', $rule, 2);
                }

                $method = 'validate' . ucfirst($rule);

                if (method_exists($this, $method)) {
                    $this->$method($fieldName, $parameters);
                }
            }
        }
    }

    protected function validateRequired($fieldName): void
    {
        if (empty($this->data[$fieldName])) {
            $this->errors[$fieldName][] = 'Feld "' . $fieldName . '" ist erforderlich.';
        }
    }

    protected function validateEmail($fieldName): void
    {
        if (!filter_var($this->data[$fieldName] ?? '', FILTER_VALIDATE_EMAIL)) {
            $this->errors[$fieldName][] = 'Feld "' . $fieldName . '" muss eine gültige E-Mail-Adresse sein.';
        }
    }

    protected function validateMin($fieldName, $min): void
    {
        if (strlen($this->data[$fieldName] ?? '') < (int) $min) {
            $this->errors[$fieldName][] = 'Feld "' . $fieldName . '" muss mindestens ' . $min . ' Zeichen lang sein.';
        }
    }

    protected function validateMax($fieldName, $max): void
    {
        if (strlen($this->data[$fieldName] ?? '') > (int) $max) {
            $this->errors[$fieldName][] = 'Feld "' . $fieldName . '" darf höchstens ' . $max . ' Zeichen lang sein.';
        }
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function getError(string $fieldName):? string
    {
        return $this->errors[$fieldName] ?? null;
    }
}