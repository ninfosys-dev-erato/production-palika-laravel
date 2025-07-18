<?php

use App\Http\Middleware\CheckAppVersion;
use App\Http\Middleware\CustomerKycVerificationMiddleware;
use App\Http\Middleware\CustomerMiddleware;
use App\Http\Middleware\SetLocale;
use App\Services\MattermostAlert;
use Domains\CustomerGateway\Crawler\Commands\WebCrawlCommand;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);
        $middleware->alias([
            'permission' => \Src\Permissions\Middleware\AdminPermissionMiddleware::class,
            'role' => \Src\Roles\Middleware\AdminRoleMiddleware::class,
            'setLocale' => SetLocale::class,
            'checkAppVersion' => CheckAppVersion::class,
            'customer' => CustomerMiddleware::class,
            'checkKycVerification' => CustomerKycVerificationMiddleware::class,
            'check_module' => \App\Http\Middleware\CheckModuleEnabled::class,
        ]);
    })
    ->withCommands([
        WebCrawlCommand::class
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            if ($request->is('api/*')) {
                return true;
            }

            return $request->expectsJson();
        });
//        $exceptions->render(function (Throwable $e, Request $request) {
//            if (!$request->expectsJson() && !$request->is('api/*')) {
//                app(MattermostAlert::class)->alert($e, $request);
//                return back()->with('alert', [
//                    'type' => 'danger',
//                    'title' => 'Error!',
//                    'message' => App::environment('production')
//                        ? 'An error was encountered. Please contact your system administrator.'
//                        : $e->getMessage(), // Show real error in local/dev
//                ]);
//            }
//            return null;
//        });
    })->create();
