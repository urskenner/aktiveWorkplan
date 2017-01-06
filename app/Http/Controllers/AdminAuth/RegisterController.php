<?php

namespace App\Http\Controllers\AdminAuth;

use App\Admin;
use App\Country;
use App\City;
use App\Address;
use App\Company;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'forename' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return Admin
     */
    protected function create(array $data)
    {


        $admin = Admin::create([
            'name' => $data['name'],
            'forename' => $data['forename'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        // Datensatz nur erstellen, wenn noch nicht vorhanden
        $country = Country::firstOrCreate(array(
            'name' => $data['country']
        ));

        $city = City::firstOrCreate(array(
            'name' => $data['city'],
            'country_id' => $country->id
        ));

        // Adresse wird immer erstellt, falls Company umzieht -> einfacher zu warten
        $address = Address::create(array(
            'street' => $data['street'],
            'street_nr' => $data['street_nr'],
            'postcode' => $data['postcode'],
            'city_id' => $city->id
        ));

        Company::create(array(
            'name' => $data['company-name'],
            'admin_id' => $admin->id,
            'address_id' => $address->id
        ));

        return $admin;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('admin.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
