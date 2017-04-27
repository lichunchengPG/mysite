<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Mail;
class UsersController extends Controller
{
  public function __construct()
  {
     $this->Middleware('auth',[
       'only'=>['edit','update', 'destroy']
     ]);
     $this->Middleware('guest',[
       'only'=>['create']
     ]);

  }
  public function create()
  {
      return view('users/create');
  }
  public function show($id)
  {
    $user = User::findOrFail($id);
    $statuses = $user->statuses()->orderBy('created_at','desc')->paginate('30');
    return view('users.show',compact('user','statuses'));

  }
  public function store(Request $request)
  {
      $this->validate($request,['name'=>'required|max:50',
        'email'=>'required|email|unique:users|max:255',
        'password'=>'required'
      ]);
      $user = User::create([
        'name' => $request->name,
        'email' =>$request->email,
        'password' =>bcrypt($request->password),
      ]);
      $this->sendEmailComfirmationTo($user);
      session()->flash('success','验证邮箱已发送到您的注册邮箱上，请注意查收。');
      return redirect('/');
  }
  public function sendEmailComfirmationTo($user)
  {
    $view = 'emails.confirm';
    $data = compact('user');
    $from = 'aufree@estgroupe.com';
    $name = 'Aufee';
    $to =$user->email;
    $subject = "感谢注册SAMPLE应用！请确认你的邮箱。";
    //闭包回调
    Mail::send($view, $data, function($message)use($from, $name, $to, $subject){
      $message->from($from, $name)->to($to)->subject($subject);
    });
  }
  public function confirmEmail($token)
  {
    $user = User::where('activation_token', $token)->firstOrFail();
    $user->activated = true;
    $user->activation_token = null;
    $user->save();
    Auth::login($user);
    session()->flash('success','恭喜你，激活成功！');
    return redirect()->route('users.show', [$user]);

  }
  public function edit($id)
  {
    $user = User::findOrFail($id);
    //授权策略 authorize 快速授权一个指定的行为，无权限运行则会抛出错误，‘update’指授权类里的授权方法（UserPolicy.php）
    //$user 是update方法的第二个参数
    $this->authorize('update',$user);
    return view('users.edit', compact('user'));
  }
  public function update($id, Request $request)
  {
    $this->validate($request,[
      'name' =>'required|max:50',
      'password'=>'confirmed|min:6'
    ]);
    $user = User::findOrFail($id);
    $this->authorize('update',$user);
    $data=[];
    $data['name']=$request->name;
    if($request->password)
    {
      $data['pasword']=bcrypt($request->password);
    }
    $user->update($data);
    session()->flash('success','个人资料更新成功!');
    return redirect()->route('users.show',$id);
  }

  public function index()
  {
      $users = User::paginate(30);
      return view('users.index',compact('users'));
  }
  public function destroy($id)
  {
    $user = User::findOrFail($id);
    $this->authorize('destroy', $user);
    $user->delete();
    session()->flash('success','成功删除用户!');
    return back();

  }
}
