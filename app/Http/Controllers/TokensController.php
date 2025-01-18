<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTokenRequest;
use App\Models\Token;
use Illuminate\Support\Str;

class TokensController extends Controller
{
    public function index()
    {
        $tokens = Token::all();
        return view('management.admin.tokens.index', compact('tokens'));
    }

    public function create()
    {
        return view('management.admin.tokens.create');
    }

    public function store(CreateTokenRequest $request)
    {
        $validated = $request->validated();
        $validated['token'] = Str::random(40);

        Token::create($validated);

        return redirect()->route('management.admin.tokens.index')
            ->with('success', __('admin.tokenCreated'));
    }

    public function destroy($email)
    {
        $token = Token::find($email);

        if (!$token) {
            return redirect()->route('management.admin.tokens.index')
                ->with('error', __('admin.failedDeleteToken'));
        }

        $token->delete();

        return redirect()->route('management.admin.tokens.index')
            ->with('success', __('admin.tokenDeleted'));
    }
}
