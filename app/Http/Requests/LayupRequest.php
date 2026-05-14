<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LayupRequest extends FormRequest
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
            'supplier_id' => ['required', 'exists:suppliers,id'],

            'name' => ['required', 'string', 'max:255'],
            'species' => ['required', 'string', 'max:255'],
            'grade' => ['required', 'string', 'max:255'],

            'status' => ['required', 'in:active,inactive'],
            'revision' => ['nullable', 'string'],

            // layers
            'layers' => ['required', 'array', 'min:1'],

            'layers.*.layer_order' => ['required', 'integer', 'min:1'],
            'layers.*.thickness' => ['required', 'numeric', 'min:1'],
            'layers.*.width' => ['required', 'numeric', 'min:1'],
            'layers.*.angle' => ['required', 'numeric'],
            'layers.*.grade' => ['nullable', 'string', 'max:255'],
        ];
    }
}
