<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Owner;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class OwnersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $owners = Owner::orderBy('created_at', 'desc')->paginate(3);
        return view('admin.owners.index', compact('owners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.owners.create');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:owners'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        Owner::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        session()->flash('status', 'info');
        session()->flash('message', 'オーナーを登録しました。');
        return to_route('admin.owners.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $owner = Owner::findOrFail($id);
        return view('admin.owners.edit', compact('owner'));
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:owners,email,'. $id .',id'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $owner = Owner::FindOrFail($id);
        $owner->name = $request->name;
        $owner->email = $request->email;
        $owner->password = Hash::make($request->password);
        $owner->save();

        session()->flash('status', 'info');
        session()->flash('message', 'オーナー情報を更新しました。');
        return to_route('admin.owners.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Owner::FindOrFail($id)->delete();

        session()->flash('status', 'alert');
        session()->flash('message', 'オーナーを削除しました。');
        return to_route('admin.owners.index');
    }

    public function expiredOwnerIndex()
    {
        $owners = Owner::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(3);
        return view('admin.expired-owners', compact('owners'));
    }

    public function expiredOwnerDestroy($id)
    {
        Owner::onlyTrashed()->FindOrFail($id)->forceDelete();

        session()->flash('status', 'alert');
        session()->flash('message', 'オーナーを完全に削除しました。');
        return to_route('admin.expired-owners.index');
    }
}
