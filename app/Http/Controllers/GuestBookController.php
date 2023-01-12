<?php

namespace App\Http\Controllers;

use App\Models\GuestBook;
use App\Models\User;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Support\Collection;

class GuestBookController extends Controller
{
    public function get_city()
    {
        $data = File::get("storage/city.json");
        $data = collect(json_decode($data));
        return $data;
        // return Storage::download('/public/city.json', "content.json");
    }
    public function get_province()
    {
        $data = File::get("storage/province.json");
        $data = collect(json_decode($data));
        return $data;
    }
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function change_password(Request $request)
    {
        return view("auth.passwords.email");
    }
    public function reset_password(Request $request)
    {
        if ($request->new_password != $request->confirm_password) {
            return view("auth.passwords.email");
        }
        $user_id = Auth::id();

        $user = User::find(1);
        $user->password = Hash::make($request->new_password);
        $user->save();
        return $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('guest_book.index');
    }

    public function datatable()
    {
        $data = GuestBook::all();
        return Datatables::of($data)->make(true);
    }

    public function create()
    {
        return view('guest_book.create');
    }

    public function store(Request $request)
    {

        $guestbook = new GuestBook();
        $guestbook->first_name = $request->firstname;
        $guestbook->last_name = $request->lastname;
        $guestbook->organization = $request->organization;
        $guestbook->address = $request->address;
        $guestbook->province = $request->province;
        $guestbook->city = $request->city;
        $guestbook->phone = $request->phone;

        if (!$guestbook->save()) {
            return [
                'status' => 0,
                'message' => "Error",
            ];
        }

        return [
            'status' => 1,
            'message' => "Data berhasil disimpan !",
        ];
    }

    public function edit($guestbook)
    {
        $data = GuestBook::find($guestbook);
        return view('guest_book.edit', ['data' => $data]);
    }

    public function update(Request $request)
    {

        $guestbook = GuestBook::find($request->id);
        $guestbook->first_name = $request->firstname;
        $guestbook->last_name = $request->lastname;
        $guestbook->organization = $request->organization;
        $guestbook->address = $request->address;
        $guestbook->province = $request->province;
        $guestbook->city = $request->city;
        $guestbook->phone = $request->phone;

        if (!$guestbook->save()) {
            return [
                'status' => 0,
                'message' => "Gagal menyimpan data !",
            ];
        }

        return [
            'status' => 1,
            'message' => "Data berhasil disimpan !",
        ];
    }

    public function destroy(Request $request)
    {
        $guestbook = GuestBook::find($request->id);
        if ($guestbook->delete()) {
            $data = [
                'status' => 1,
                'message' => "Data berhasil dihapus !",
            ];
        } else {
            $data = [
                'status' => 0,
                'message' => "Gagal menghapus data !",
            ];
        }
        return $data;
    }
}
