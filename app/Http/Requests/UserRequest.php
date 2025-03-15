<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // pegar dados da URL aqui funciona se eu for atualizar um cadastro mas da erro se eu for criar um
        // $userId = $this->route('user');
        // 'email' => 'required|email|unique:users,email,' . ($userId ? $userId->id : null),
        $userId = $this->route('user') ? $this->route('user')->id : null;
        return [
            'name' => 'required',
            // 'email' => 'required|email|unique:users,email',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId), // Ignora o ID ao atualizar
            ],
            'password' => 'required|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Campo nome é obrigatorio',
            'email.required' => 'Campo e-mail é obrigatorio',
            'email.email' => 'Campo deve ser um email valido!',
            'email.unique' => 'O e-mail já está cadastrado!',
            'password.required' => 'Campo senha é obrigatorio',
            'password.min' => 'Senha com no minimo :min caracteres!',
        ];
    }
}
