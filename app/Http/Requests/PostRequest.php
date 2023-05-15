<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        // 今回は使用しないのでtrueを返す
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $route = $this->route()->getName();

        // return [
        $rule = [
            //
            'title' => 'required|string|max:50',
            'body' => 'required|string|max:2000',
            // 'image' => 'required|file|image|mimes:jpg,png',
        ];

        if ($route === 'posts.store' ||
            ($route === 'posts.update' && $this->file('image'))) {
            $rule['image'] = 'required|file|image|mimes:jpg,png';
        }

        return $rule;
    }
}
