<?php

namespace App\Http\Controllers;
use App\Http\Requests\UsesrRequest;
use App\Http\Requests\UsersEditRequest;
use App\User;
use App\Photo;
use App\Role;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users=User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
       /* $roles=Role::lists('name', 'id')->all(); //ne radi */ //ako bi stavili odmah all() bila bi kompilacija, a posto hocemo array onda koristimo lists
       $roles=[''=>'---select option---'] + Role::Lists("name", "id")->toArray();
        return view('admin.users.create', compact("roles"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsesrRequest $request)
    {
        //
        //za proveru forme return $request->all();
        /* bez fajla
        User::create($request->all());
        return redirect('/admin/users');
        
        //za testiranje fajla
        if($request->file('photo_id'))
        {
            return "photo exist";
        }
        */
//cuvanje korisnika sa fajlom

        if(trim($request->password)=='')
        {
            $input=$request->except('password');
        }
        else
        {
            $input = $request->all();
            $input['password']=bcrypt($request->password);
        }

      
        if($file=$request->file('photo_id'))
        {
            $name=time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo=Photo::create(['file'=>$name]);
            $input['photo_id']=$photo->id;
        }
        $input['password']=bcrypt($request->password);//da sifra bude hesirana
        User::create($input);

        return redirect('/admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return view('admin.users.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user=User::findOrFail($id);
        $roles=[''=>'---select option---'] + Role::Lists("name", "id")->toArray();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {
        //
       // return $request->all();
       $user=User::findOrFail($id);
       
       if(trim($request->password)=='')
       {
           $input=$request->except('password');
       }
       else
       {
           $input = $request->all();
           $input['password']=bcrypt($request->password);
       }

       if($file=$request->file('photo_id'))
       {
           $name=time() . $file->getClientOriginalName();
           $file->move('images', $name);

           $photo=Photo::create(['file'=>$name]);
           $input['photo_id']=$photo->id;
       }
       
       $user->update($input);
       return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
