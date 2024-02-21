#Press CTRL+ALT+i on Windows / CTRL+Option+i on MacOS
composer require laravel/pint --dev
composer require laravel/telescope --dev
composer require laravel/tinker --dev
php artisan vendor:publish --provider="Laravel\Tinker\TinkerServiceProvider"
composer require laravel/telescope
php artisan telescope:install
composer require barryvdh/laravel-debugbar --dev
php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"
composer require --dev barryvdh/laravel-ide-helper --with-all-dependencies
php artisan vendor:publish --provider="Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider" --tag=config
php artisan migrate
