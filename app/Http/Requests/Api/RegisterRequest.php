<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\ArrayShape;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['username' => "string", 'email' => "string", 'password' => "string"])]
    public function rules(): array
    {
        return [
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email:filter|unique:users,email',
            'password' => 'required|string|min:6'
        ];
    }

    public function validate(array $rules, ...$params): array
    {
        return parent::validate($rules, $params);
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new Response($validator->errors()->messages(), 422);
        throw new ValidationException($validator, $response);
    }
}
