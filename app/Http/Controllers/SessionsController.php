<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
class SessionsController extends Controller
{
    //
    public function create()
    {
       return view('sessions.create');
    }
    public function store(Request $request)
    {
        //验证输入内容是否符合要求
        //不符合要求则会返回当前页面并显示错误
        $this->validate($request,[
          'email'=>'required|email|max:255',
          'password'=>'required'
        ]);

        $credantials =[
          'email'=>$request->email,
          'password'=>$request->password,
        ];

        if(Auth::attempt($credantials, $request->has('remember'))){
          //登陆成功后的操作
          session()->flash('success','欢迎回来');
          return  redirect()->route('users.show',[Auth::user()]);

        }else{
         //登陆失败后的操作
         session()->flash('danger','很抱歉，你的邮箱和密码不匹配');
         return redirect()->back();
        }

    }
    public function destory()
    {

       Auth::logout();
       return redirect(route('login'));


    }

}
