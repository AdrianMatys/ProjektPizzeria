<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTokenRequest;
use App\Models\Token;
use Illuminate\Support\Str;

class TokensController extends Controller
{
    public function index(){
        $tokens = Token::all();
        return view('management.admin.tokens.index', compact('tokens'));
    }
}
