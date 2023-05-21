<?php

namespace App\Http\Validators;

use Illuminate\Validation\Validator;

class MyValidator extends Validator
{
    /**
     * Validasi input form.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateForm(array $data)
    {
        return $this->validate($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    }

    /**
     * Validasi data sebelum disimpan ke database.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateData(array $data)
    {
        return $this->validate($data, [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'published_at' => 'nullable|date',
        ]);
    }
}
