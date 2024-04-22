<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class saveDirectionRequest extends FormRequest
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
            'name' => 'required|unique:directions,name'
        ];
    }
    public function messages()
    {
        return[
            'name.required' => 'le nom de la direction est requis',
            'name.unique' => 'le nom de direction existe deja'
        ];
    }
}
