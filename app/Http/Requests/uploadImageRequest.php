<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class uploadImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'image' => 'image|mimes:jpeg,jpg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'image.image' => '指定されたファイルは画像ではありません。',
            'image.mimes' => '拡張子はjpeg.jpg,pngのみ指定できます。',
            'image.max' => 'ファイルサイズは2MB以内にしてください。'
        ];
    }
}
