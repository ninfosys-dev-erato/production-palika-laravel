<?php

namespace App\Providers;

use App\Repository\HttpProvider;
use App\Services\ActivityLoggerService;
use App\Services\FileService;
use App\Services\FileTrackingService;
use App\Services\GlobalService;
use App\Services\ImageService;
use App\Services\PdfService;
use App\Services\SmsService;
use App\Services\VideoService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Crypt;

class AppServiceProvider extends ServiceProvider
{
    public $language;
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('http-service', function () {
            return new HttpProvider();
        });
        $this->app->bind('pdf-service', function () {
            return new PdfService();
        });
        $this->app->bind('image-service', function () {
            return new ImageService();
        });
        $this->app->bind('video-service', function () {
            return new VideoService();
        });
        $this->app->bind('sms-service', function () {
            return new SmsService();
        });
        $this->app->bind('global-service', function () {
            return new GlobalService();
        });
        $this->app->bind('file-service', function () {
            return new FileService();
        });
        $this->app->bind('file-tracking-service', function () {
            return new FileTrackingService();
        });
        $this->app->bind('activity-log-service', function () {
            return new ActivityLoggerService();
        });
        $this->app->register(AccessControlServiceProvider::class);
        $this->app->register(ModuleServiceProvider::class);
        $this->app->register(DomainServiceProvider::class);
        $this->app->register(FrontendServiceProvider::class);
        $this->app->register(PassportCustomConfigProvider::class);
        $this->app->register(NotificationServiceProvider::class);        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        if (Cookie::has('language')) {
            $encryptedLanguage = Cookie::get('language');

            try {
                $decrypted = Crypt::decryptString($encryptedLanguage);

                $language = explode('|', $decrypted)[1] ?? config('app.locale');

                App::setLocale($language);
            } catch (\Exception $e) {
                App::setLocale(config('app.locale'));
            }
        }
        Blade::if('perm', function ($permission) {
            return can($permission);
        });
        Validator::extend('base64_image', function ($attribute, $value, array $parameters, $validator) {
            // Extract maxSize and allowedTypes from parameters
            $maxSize = intval(str_replace('maxSize=', '', $parameters[0]));
            $allowedTypes = explode('|', str_replace('allowedTypes=', '', $parameters[1]));
            // Split the base64 image string and extract the image type and data
            $image_parts = explode(";base64,", $value);
            if (count($image_parts) != 2) {
                $validator->errors()->add('image', 'The image format is invalid.');
                return false; // Invalid base64 image string format
            }
            // Extract the image type
            $image_type_aux = explode("image/", $image_parts[0]);
            if (count($image_type_aux) != 2) {
                $validator->errors()->add('image', 'The image string format is invalid.');
                return false; // Invalid base64 image string format
            }
            $image_type = $image_type_aux[1];
            // Decode the image data
            $image_base64 = base64_decode($image_parts[1]);
            // Get image size in kilobytes
            $imageSize = strlen($image_base64) / 1024;
            // Check if image is below max size
            if ($imageSize > $maxSize) {
                $validator->errors()->add('image', "The image size exceeds $maxSize KB.");
                return false;
            }
            $supportedType = implode(".", $allowedTypes);
            // Check if the image type is allowed
            if (!in_array($image_type, $allowedTypes)) {
                $validator->errors()->add('image', "The image format is invalid supported types $supportedType.");
                return false;
            }
            return true;
        });
        if (App::environment('production')) {
            URL::forceScheme('https');
        }
        Validator::replacer('base64_image', function ($message, $attribute, $rule, $parameters) {
            return "";
        });
        Model::preventLazyLoading(!App::isProduction());
    }
}
