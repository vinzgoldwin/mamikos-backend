<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use App\Owner;
use App\Kost;

class OwnerController extends Controller
{

    public function index()
    {
        return Owner::all();
    }

    public function show($id)
    {
        return Owner::where('owner_id', $id)->first();
    }

    // create a new owner with validation name,email and password

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        Owner::create($validatedData);
        return redirect('/owner')->with('success', 'owner is successfully saved');
    }

    public function update(Request $request, $id)
    {
        $owner = Owner::where('owner_id', $id)->first();
        $owner->update($request->all());

        return $owner;
    }

    public function delete(Request $request, $id)
    {
        $owner = Owner::where('owner_id', $id)->first();
        $owner->delete();

        return 204;
    }

    /* Owner can add more than a kost, owner need to input all data needed to create a kost
and input email and password to authenticate the user is owner, the id of the owner will
get return too so we know who is the owner of the kost */

    public function store_kost(Request $request)
    {
        $validatedData = $request->validate([
            'kost_name' => 'required',
            'avail_room_count' => 'required',
            'address' => 'required',
            'description' => 'required',
            'city' => 'required',
            'price' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $owner = Owner::where([
            ['email', $validatedData['email']],
            ['password', $validatedData['password']]
        ])->first();

        if ($owner->owner_id !== null) {
            $validatedData['owner_id'] = $owner->owner_id;
        } else {
            return 'not authenticate';
        }

        $kost = new Kost;
        $kost->kost_name = $validatedData['kost_name'];
        $kost->avail_room_count = $validatedData['avail_room_count'];
        $kost->address = $validatedData['address'];
        $kost->description = $validatedData['description'];
        $kost->city = $validatedData['city'];
        $kost->price = $validatedData['price'];
        $kost->owner_id = $validatedData['owner_id'];
        $kost->save();

        return $kost;
    }

    /* to update a kost we need to authenticate the user is owner and
the $id is the kost_id of kost we want to update */

    public function update_kost(Request $request, $id)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $owner = Owner::where([
            ['email', $validatedData['email']],
            ['password', $validatedData['password']]
        ])->first();

        $kost = Kost::where([['owner_id', $owner->owner_id], ['kost_id', $id]])->first();
        $kost->fill($request->except('email', 'password'));
        $kost->save();

        return $kost;
    }

    /* to delete a kost we need to authenticate the user is owner and
the $id is the kost_id of kost we want to delete */

    public function delete_kost(Request $request, $id)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $owner = Owner::where([
            ['email', $validatedData['email']],
            ['password', $validatedData['password']]
        ])->first();

        $kost = Kost::where([['owner_id', $owner->owner_id], ['kost_id', $id]])->first();
        $kost->delete();
        return 'kos berhasil dihapus';
    }
}
