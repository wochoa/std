<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        TokenMismatchException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof TokenMismatchException){
            //Redirect to login form if session expires
            //dd($request->fullUrl());
            $ret= new ViewErrorBag();
            $message = new MessageBag();
            $message->add('adm_email','La token de validacion expiró, intentelo nuevamente!');
            $ret->put('default',$message);
            return back()->with('errors',$ret);
        }
        return parent::render($request, $e);
    }
}
