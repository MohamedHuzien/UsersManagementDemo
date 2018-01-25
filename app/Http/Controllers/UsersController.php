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
    public function index()
    {

        $users = User::latest()->paginate(10);
        return view("admin.users_list", compact("users"));
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
            $imagePath = explode('/', $path);
            $imagePath = $imagePath[1];
            $input["image"] = $imagePath;
        }

        $user = new User($input);
        $user->save();
        return redirect("/users");
    }

    /**
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param $id
     */
    public function show(User $user)
    {
        return view('home', compact("user"));

    }

    /**
     *  view Edit page
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param $id
     */
    public function edit(User $user)
    {
        return view('admin.edit_user', compact("user"));

    }


    /**
     * @todo needs to refactor Tips 1- isolate handling image logic in it's own class or method
     *  2- Use laravel filesystem
     *  3- delegate updating the role to a dedicated method an in future dedicated class
     *  4- Use hashing inside the User Model is more safe you can use setPasswordAttribute
     *
     *
     * @param User $user
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        if ($request->hasFile("image")) {

            $path = $request->file('image')->store('uploads');
            if ($user->image) {
                if (is_file(storage_path('app/public/uploads/' . $user->image)))
                    unlink(storage_path('app/public/uploads/' . $user->image));
            }
            $imagePath = explode('/', $path);
            $imagePath = $imagePath[1];
            $user->image = $imagePath;
        }

        $user->name = $request["name"];
        if ($request->has("password")) {
            $user->password = bcrypt($request["password"]);
        }

        // it complex things and it took me a 2 sec resolve it
        // try to make refactor this kind of checks and assigns to a readable method
        if (Auth::user()->is_admin) {
            $user->is_admin = $request->has("rule") ? $request["rule"] : $user->is_admin;
        }
        $user->email = $request["email"];
        $user->update();
        Session::flash('message', "User Has been updated");
        return redirect("/users");

    }

    /**
     * delete user function by id
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @internal param $id
     */
    public function destroy(User $user)
    {
        if ($user->image) {
            if (is_file(storage_path('app/public/uploads/' . $user->image)))
                unlink(storage_path('app/public/uploads/' . $user->image));
        }
        $user->delete();
        Session::flash('message', "User Has been deleted");
        return redirect("/users");

    }
}