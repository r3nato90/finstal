<?php

namespace App\Http\Controllers\Admin\Ico;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ico\TokenRequest;
use App\Services\Ico\TokenService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TokenController extends Controller
{
    public function __construct(
        protected TokenService $tokenService,
    ){

    }

    public function index(): View
    {
        $setTitle = 'Token Management';
        $tokens = $this->tokenService->getByPaginate();
        return view('admin.ico.tokens.index', compact('tokens', 'setTitle'));
    }

    public function create(): View
    {
        $setTitle = 'Create New Token';
        return view('admin.ico.tokens.create', compact('setTitle'));
    }


    public function store(TokenRequest $request): RedirectResponse
    {
        if ($request->input('sale_start_date') && $request->input('sale_end_date')) {
            if ($request->input('sale_end_date') < $request->input('sale_start_date')) {
                return back()->with('notify', [['error', __('Sale end date cannot be earlier than start date')]])->withInput();
            }
        }

        if ($request->input('price') && $request->input('price') <= 0) {
            return back()->with('notify', [['error', __('Price must be greater than 0')]])->withInput();
        }

        if ($request->input('total_supply') && $request->input('total_supply') <= 0) {
            return back()->with('notify', [['error', __('Total supply must be greater than 0')]])->withInput();
        }

        $token = $this->tokenService->save($this->tokenService->prepParams($request));
        return redirect()->route('admin.ico.token.index')->with('notify', [['success', __('Token created successfully')]]);
    }

    public function edit(int|string $id): View
    {
        $setTitle = 'Update Token';
        $token = $this->tokenService->findById($id);
        if(!$token){
            abort(404);
        }

        return view('admin.ico.tokens.edit', compact('token', 'setTitle'));
    }

    public function update(TokenRequest $request, int|string $id): RedirectResponse
    {
        // Validate date range
        if ($request->input('sale_start_date') && $request->input('sale_end_date')) {
            if ($request->input('sale_end_date') < $request->input('sale_start_date')) {
                return back()->with('notify', [['error', __('Sale end date cannot be earlier than start date')]])->withInput();
            }
        }

        // Validate numeric fields
        if ($request->input('price') && $request->input('price') <= 0) {
            return back()->with('notify', [['error', __('Price must be greater than 0')]])->withInput();
        }

        if ($request->input('total_supply') && $request->input('total_supply') <= 0) {
            return back()->with('notify', [['error', __('Total supply must be greater than 0')]])->withInput();
        }

        $token = $this->tokenService->findById($id);
        if(!$token){
            return back()->with('notify', [['error', __('Token not found')]]);
        }

        $this->tokenService->update($token, $this->tokenService->prepParams($request));
        return redirect()->route('admin.ico.token.index')->with('notify', [['success', __('Token updated successfully')]]);
    }
}
