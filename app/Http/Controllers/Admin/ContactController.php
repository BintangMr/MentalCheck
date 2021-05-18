<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContact;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index(Request $request){
        $contact = Contact::first();
        if(!$contact){
            $contact = new Contact();
            $contact->save();
        }

        return view('admin.contact',[
            'contact' => $contact
        ]);
    }

    public function update(StoreContact $request){
        try {
            DB::beginTransaction();
            $contact = Contact::first();
            $contact->address = $request->alamat;
            $contact->phone = $request->no_telepon;
            $contact->save();
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'error',
                'description' => $e->getMessage()
            ],500);
        }

        return response()->json([
            'message' => 'success',
        ]);
    }
}
