<?php

namespace App\Auth\Presentation\Http\V1\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterVerifyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => ['required', 'string', 'exists:user_verifications,token'],
        ];
    }
}
