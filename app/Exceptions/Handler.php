<?php

namespace App\Exceptions;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        if($exception instanceof ClientException)
        {
            return $this->handleClientException($exception, $request);
        }

        return parent::render($request, $exception);
    }

    protected function handleClientException(ClientException $exception, $request)
    {
        $code = $exception->getCode();
        $response = json_decode($exception->getResponse()->getBody()->getContents());
        $errorMessage = $response->error;

        switch($code)
        {
            case Response::HTTP_UNAUTHORIZED:
                $request->session()->invalidate();

                if($request->user())
                {
                    Auth::logout();
                    return redirect()->route('welcome')
                    ->withErrors(['message' => 'La autenticación falló, por favor inicie sesión de nuevo.']);
                }

                abort(500, 'La autenticación falló, por favor intente de nuevo.');
                // throw new \Exception('La autenticación falló, por favor intente de nuevo.', 0, $exception);
            default:
                return back()->withErrors(['message' => $errorMessage]);
            break;
        }
    }
}
