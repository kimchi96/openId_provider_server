<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\MyUsersModel;
use App\ClientModel;
use App\CodeModel;
use App\TokenModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use JWTAuth;
use JWTFactory;
use Tymon\JWTAuth\Claims\Issuer;
use Tymon\JWTAuth\Claims\IssuedAt;
use Tymon\JWTAuth\Claims\Expiration;
use Tymon\JWTAuth\Claims\NotBefore;
use Tymon\JWTAuth\Claims\Subject;
use Carbon\Carbon;

class MyController extends Controller
{
    public function getView_RP(Request $request)
    {    
        return view ('rp');
    }

    public function getCallBack_RP(Request $request)
    {    
        $code          =   $request->input('code'); 
        $error         =   $request->input('error');
        $state         =   $request->input('state');

        return view ('callback');
    }
    
    public function postCallBack_RP(Request $request)
    {      
        $grant_type    =   "authorization_code";
        $code          =   $request->input('code');
        $state         =   $request->input('state');
        $redirect_uri  =   $request->input('url_redirect');
        $url = 'grant_type='.$grant_type.'&code='.$code.'&redirect_uri='.$redirect_uri;
        
        return response()
        ->header('Content-Type','application')
        ->header('Authorization','Basic $clientID');

    }
    public function getError()
    {    
        return view ('error');
    }
    public function postError()
    {    
        return redirect()->route('rp');
    }


    public function getView_Login(Request $request)
    {   
        $response_type  =   $request->input('response_type'); 
        $scope          =   $request->input('scope'); 
        $clientID       =   $request->input('client_id'); 
        $state          =   $request->input('state');
        $redirect_uri   =   $request->input('redirect_uri');
    	$error          =   'invalid_request';
        if($response_type == 'code' && $scope = 'openid'){
             $check = ClientModel::where(['client_id' => $clientID,
                                        'url_redirect' => $redirect_uri])->get();
            if($check->isNotEmpty()){
                return view ('login');
            }
        } else return redirect()->route('error',['error' => $error,'state'=> $state],400);
    }

    public function postView_Login(Request $request)
    {
        $state = $request->input('state');
        $redirect_uri = $request->input('url_redirect');
        $clientID       =   $request->input('client_id');
        Log::info('clientID: '.json_encode($request->all()));
        $request->validate([
    		'username' => 'required',
    		'password' => 'required'
    		],[
    		'username.required' => 'Hãy nhập UserName',
    		'password.required' => 'Hãy nhập Password'
    		]);
        $user = MyUsersModel::where(['username' => $request->username,
                                     'password' => $request->password])->first();       
        $code = Str::random(10);

        if($user !== null){
            Log::info(json_encode($user));
            $CodeModel = new CodeModel;
            $CodeModel->code        = $code;
            $CodeModel->state       = $state;
            $CodeModel->client_id   = $clientID;
            $CodeModel->user_id     = $user->user_id;
            $CodeModel->name        = $user->name;
            $CodeModel -> save();
            $url = $redirect_uri.'?code='.$code.'&state='.$state;
            return $url;
        }
        else{
             return back()->withErrors(['Đăng nhập không thành công']);
         }
    }
    
    public function getView_Register()
    {
        return view ('register');
    }
    public function postView_Register(Request $request)
    {
        $request->validate([
            'username' => 'required|min:3|max:32',
            'password' => 'required|min:6|max:32',
            'name'     => 'required',
            'email'    => 'required|email',
            'address'  => 'required',
            'number'   => 'required'
            ],[
            'username.required' => 'Hãy nhập UserName',
            'username.min'      => 'UserName không ít hơn 3 ký tự',
            'username.max'      => 'UserName không được nhiều hơn 32 ký tự',
            'name.required'    => 'Hãy nhập Tên',
            'email.required'    => 'Hãy nhập Email',
            'email.email'       => 'Email không đúng định dạng',
            'password.required' => 'Hãy nhập Password',
            'password.min'      => 'Password không được ít hơn 6 ký tự',
            'password.max'      => 'Password không được nhiều hơn 32 ký tự',
            'address.required'   => 'Hãy nhập Địa chỉ',
            'number.required'   => 'Hãy nhập Phone Number'
            ]);
       
        $table = new MyUsersModel;
        $table->username    = $request->username;
        $table->email       = $request->email;
        $table->password    = $request->password;
        $table->name        = $request->name;
        $table->address     = $request->address;
        $table->phone       = $request->number;
        $table -> save();
        return view('register')->withErrors(['Đăng ký thành công']);        
    }
    
    public function getView_OP()
        {
            return view ('op');
        }

    public function postView_OP(Request $request)
    {
        $request->validate([
            'name_client' => 'required|min:3|max:32|unique:client',
            'url_redirect' => 'required|url'
            ],[
            'name_client.required' => 'Hãy nhập Name',
            'name_client.min' => 'Name không ít hơn 3 ký tự',
            'name_client.max' => 'Name không được nhiều hơn 32 ký tự',
            'name_client.unique' => 'Name đã tồn tại', 
             'url_redirect.required' => 'Hãy nhập URL chuyển hướng được ủy quyền',
            'url_redirect.url' => 'URL không đúng định dạng'
            ]);
        $table = new ClientModel;
        $table->name_client = $request->name_client;
        $table->url_redirect = $request->url_redirect;
        $table->client_id = rand(100000,999999);
        $table->client_secrect = rand(100000,999999);
        $table->state = rand(100000,999999);
        $table -> save();
        return view('op')->withErrors(['Đăng ký thành công']);
    }

    public function checkView_OP(Request $request){
        $key = $request->key;
        $data = ClientModel::where('name_client',$key)->get();
        if($data->isNotEmpty()){
            return view('op',['info'=>$data[0]]);
        }
        else{ 
            return view('op')->withErrors(['Không tìm thấy']);
        }
    }


    public function getJson(){
        //trả về json là 1 mảng các ngôn ngữ lập trình
        $array = ["PHP", "Java", 'Golang', "NET"];
        return response() -> json([
            "status"            => true,
            "message"           => "Success",
            "data"              => $array
        ]);
    }

    public function getToken(Request $request)
    {// này là check mấy cái tham số gửi đi thôi
        $postData = $request->post();
        $code = $postData['code'];
        $redirect_uri = $postData['redirect_uri'];
        $grant_type = $postData['grant_type'];
        if($grant_type !== 'authorization_code'){
            return response()->json([
                "error" => "unsupported_grant_type"
            ], 400);//check error
        }

        $CodeModel = CodeModel::where(['code' => $request->code])->first();
        if($CodeModel === null){
            return response()->json([
                "error" => "invalid_request"
            ], 400);//check error
        }

        $client = ClientModel::where(['client_id' => $CodeModel->client_id])->first();
        if($redirect_uri != $client->url_redirect){
            return response()->json([
                "error" => "invalid_client"
            ], 400);//check error
        }

        $token = null;
        $token_type = 'Bearer';
        $ttl = 3600;
        $data = [
          "iss"       => "http://op.com",
          "iat"       => new IssuedAt(Carbon::now('UTC')),
          "exp"       => new Expiration(Carbon::now('UTC')->addDays(1)),
          "sub"       => $CodeModel->name,
          "aud"       => $CodeModel->client_id
        ];
        $customClaims = JWTFactory::customClaims($data);
        $payload = JWTFactory::make($data);
        $id_token = JWTAuth::encode($payload)->get();
        $access_token = Str::random(10);
        
            $Token = new TokenModel;
            $Token->id_token= $id_token;
            $Token->access_token = $access_token;
            $Token->token_type = $token_type;
            $Token->expires_in = $ttl;
            $Token->client_id=$client->client_id;
            $Token->user_id=$CodeModel->user_id;
            $Token -> save();
        Log::debug($Token);
        return response()->json([
             "id_token" => $id_token,
             "access_token" => $access_token,
             "token_type" => $token_type,
             "expires_in" => $ttl   
        ], 200);

    
}

    public function getUserInfo(Request $request){
        return response()->json([
             "id_token" => "321654", //note
             "access_token" => "asdasidh", //note
             "token_type" => "Bearer",
             "expires_in" => $ttl   
        ], 200);
    }
}