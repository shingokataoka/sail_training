<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use App\Providers\ImageService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ImagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:owner');

        $this->middleware(function($request, $next){
            $imageId = $request->route()->parameter('image');
            if(isset($imageId)) {
                $ownerId = Image::findOrFail($imageId)->owner->id;
                if($ownerId !== Auth::id()) abort(404);
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::where('owner_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return  view('owner.images.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('owner.images.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image_files' => 'required',
            'image_files.*' => 'image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'image_files.required' => 'ファイルが選択されていません。',
            'image_files.*.image' => '画像以外のファイルは選択できません。',
            'image_files.*.mimes' => 'ファイルの拡張子はjpeg,jpg,pngのいずれかのみ使用できます。',
            'image_files.*.max' => 'ファイルのサイズは一つあたり:maxKB以内にしてください。',
        ]);

        $imageFiles = $request->file('image_files');
        if (isset($imageFiles)) {
            foreach ($imageFiles as $imageFile) {
                $filename = ImageService::upload($imageFile, 'products');
                Image::create([
                    'owner_id' => Auth::id(),
                    'filename' => $filename,
                ]);
            }
            session()->flash('status', 'info');
            session()->flash('message', '画像を登録しました。');
        }

        return to_route('owner.images.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     dd(__FUNCTION__);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $image = Image::findOrFail($id);
        return view('owner.images.edit', compact('image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $image = Image::findOrFail($id);
        $image->title = $request->title;
        $image->save();

        session()->flash('status', 'info');
        session()->flash('message', '画像情報を更新しました。');
        return to_route('owner.images.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        $path = 'public/products/' . $image->filename;
        if (Storage::exists($path)) Storage::delete($path);

        DB::table('products')->where('image1_id', $image->id)->update(['image1_id' => null]);
        DB::table('products')->where('image2_id', $image->id)->update(['image2_id' => null]);
        DB::table('products')->where('image3_id', $image->id)->update(['image3_id' => null]);
        DB::table('products')->where('image4_id', $image->id)->update(['image4_id' => null]);

        $image->delete();

        session()->flash('status', 'alert');
        session()->flash('message', '画像を削除しました。');
        return to_route('owner.images.index');
    }
}
