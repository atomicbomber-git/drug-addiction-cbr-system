<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AtLeastOneIsChecked implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $fields
     * @return bool
     */
    public function passes($attribute, $fields)
    {
        if (!is_array($fields)) {
            throw new \Exception('$fields has to be an array.');
        }

        foreach ($fields as $field) {
            if (isset($field["value"])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Anda belum menjawab pertanyaan, silahkan menjawab pertanyaan terlebih dahulu.';
    }
}
