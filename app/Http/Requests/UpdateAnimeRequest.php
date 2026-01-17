<?php

namespace App\Http\Requests;

use App\Enums\AnimeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAnimeRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'episodes' => 'nullable|integer',
            'status' => ['required', Rule::enum(AnimeStatus::class)],
            'api_id' => [
                'required',
                'integer',
                Rule::unique('animes', 'api_id')->ignore($this->route('anime')),
            ],
            'user_id' => 'required|integer|exists:users,id',
        ];
    }
}
