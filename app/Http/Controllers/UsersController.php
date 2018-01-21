<?php
/**
 * Created by PhpStorm.
 * User: mh
 * Date: 19/01/18
 * Time: 12:35 ص
 */

namespace App\Http\Controllers;
use App\User;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UsersController
{
    public function index(){

       $users =  User::orderBy("created_at" , "desc")->paginate(10);
        return view("admin.users_list" , compact("users"));
    }

    public function create()
    {
        return view("admin.add_user");
    }

    public function store(CreateUserRequest $request)
    {
        $input = $request->only(["name", "password", "email"]);
        $input["is_admin"] = $request["rule"];
        $input["password"] = bcrypt($request["password"]);
        if ($request->hasFile("image")) {
            $path = $request->file('image')->store('uploads');
            $imagePath = explode('/',$path);
            $imagePath = $imagePath[1];
            $input["image"] = $imagePath;
        }

        $user = new User($input);
        $user->save();
        return redirect("/users");
    }

    /**
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::find($id);
        if($user);
            return view('home' ,compact("user"));

        abort(404,'Page not found');
    }

    /**
     *  view Edit page
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::find($id);
        if($user)
            return view('admin.edit_user' , compact("user"));

        abort(404,'Page not found');
    }

    public function update($id , UpdateUserRequest $request){
        $user = User::find($id);
        if($user) {
            if ($request->hasFile("image")) {

                $path = $request->file('image')->store('uploads');
                if ($user->image) {
                    if(is_file(storage_path('app/public/uploads/'.$user->image)))
                        unlink(storage_path('app/public/uploads/'.$user->image));
                }
                $imagePath = explode('/', $path);
                $imagePath = $imagePath[1];
                $user->image = $imagePath;
            }

            $user->name = $request["name"];
            if ($request->has("password")) {
                $user->password = bcrypt($request["password"]);
            }

            if(Auth::user()->is_admin){
                $user->is_admin = $request->has("rule") ? $request["rule"] : $user->is_admin ;
            }
            $user->email = $request["email"];
            $user->update();
            Session::flash('message', "User Has been updated");
            return redirect("/users");

        }
        abort(404,'Page not found');
    }

    /**
     * delete user function by id
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user) {
            if ($user->image) {
                if(is_file(storage_path('app/public/uploads/'.$user->image)))
                    unlink(storage_path('app/public/uploads/'.$user->image));
            }
            $user->delete();
            Session::flash('message', "User Has been deleted");
            return redirect("/users");
        }

        abort(404,'Page not found');

    }
}