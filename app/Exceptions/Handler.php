<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (TokenMismatchException $e, $request) {
            if ($request->is('logout') || $request->is('admin/logout') || $request->is('donatur/logout')) {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('landing')->with('success', 'Berhasil keluar dari sistem.');
            }

            if ($request->is('login') || $request->is('login/*')) {
                return redirect()->route('landing')
                    ->with('showLoginModal', true)
                    ->withErrors(['email' => 'Halaman login kedaluwarsa karena tidak ada aktivitas. Silakan coba lagi.']);
            }

            return redirect()->back()
                ->withInput($request->except('_token'))
                ->with('warning', 'Sesi Anda telah kedaluwarsa. Silakan kirim ulang formulir Anda.');
        });
    }
}
