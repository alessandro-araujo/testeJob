<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentsRequest extends FormRequest
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
        return [
            'rm_student' => 'required',
            'rm_teacher' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'rm_student.required' => 'Campo nome é obrigatorio',
            'rm_teacher.required' => 'Campo RM do Teacher é obrigatorio',
        ];
    }
}
