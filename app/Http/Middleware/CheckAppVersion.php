<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Src\Settings\Models\AppSetting;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiStandardResponse;
use Src\Settings\Traits\AdminSettings;

class CheckAppVersion
{
    use ApiStandardResponse, AdminSettings;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentVersion = $this->getConstant('version');
        // $currentVersion = AppSetting::latest()->value('version');
        $headerVersion = $request->header('App-Version');

        if (!$headerVersion || !$currentVersion) {
            return $this->generalFailure([
                'message' => 'Version information missing.'
            ], Response::HTTP_BAD_REQUEST);
        }

        [$currentMajor, $currentMinor, $currentPatch] = explode('.', $currentVersion);
        [$headerMajor, $headerMinor, $headerPatch] = explode('.', $headerVersion);

        if ($headerMajor < $currentMajor) {
            return $this->generalFailure([
                'message' => __('Critical Update Required: Please update to the latest version to continue using the app with full functionality and compatibility.'),
                'status' => 'critical'
            ], Response::HTTP_UPGRADE_REQUIRED);
        } elseif ($headerMinor < $currentMinor) {
            return $this->generalFailure([
                'message' => __('New Feature Update Available: Upgrade now to unlock new features and enhancements for a better experience.'),
                'status' => 'minor'
            ], Response::HTTP_UPGRADE_REQUIRED);
        } elseif ($headerPatch < $currentPatch) {
            return $this->generalFailure([
                'message' => __('Performance Update Available: Update to enjoy improved stability and faster performance.'),
                'status' => 'patch'
            ], Response::HTTP_UPGRADE_REQUIRED);
        }

        return $next($request);
    }
}
