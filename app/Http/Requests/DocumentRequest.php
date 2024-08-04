<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'json_file' => 'required|file|mimetypes:application/json,text/plain',
        ];
    }

    public function messages(): array
    {
        return [
            'json_file.required' => 'O arquivo deve ser informado!',
            'json_file.mimetypes' => 'O arquivo deve ser um JSON!',
        ];
    }

    public function withValidator($validator)
    {
        // Podemos fazer uma validação avançada no json aqui mas mantive uma validação simples nas rules
    }
}
