<?php

namespace App\Http\Livewire;

use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $form = [
        "email" => '',
        "password" => '',
    ];
    protected $messages = [
        'form.password.regex' => "the passowrd must  contain numbers, capital letters, small letters and special characters.",
        'form.email.email' => "The email is not vaild",
        'form.email.required' => "Email is required",
        'form.email.min' => "Email must be at least 5 chatacters",
        'form.password.required' => "Password is required",
        'form.password.min' => "Password must be more than 6 chatacters",
    ];
    public function updated(){
        $this->validate([
            "form.email" => "required|email|min:5",
            "form.password" => [
                'required',
                'min:6',
                "max:191",
                'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            ],
        ]);
    }
    public function submit(){
        $this->validate([
            "form.email" => "required|email|min:5",
            "form.password" => [
                'required',
                'min:6',
                "max:191",
                'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            ],
        ],['password.regex' => "the passowrd must  contain numbers, capital letters, small letters and special characters."]);
        try{
            Auth::guard('admin')->attempt($this->form);
            if(!Auth::guard('admin')->user()){
                session()->flash("message","Wrong Email or Password");
            }else{
                return redirect()->route('dashboard');
            }
        }catch(Exception $exception){
            session()->flash("message",$exception->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.login');
    }
}
