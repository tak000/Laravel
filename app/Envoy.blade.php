@servers(['web' => 'justin-card@13.39.150.46'])


@story("deploy")
    update-dependencies
    migrate
    optimise
@endstory

@task('update-dependencies', ['on' => 'web'])
    composer install
    npm install
    npm run build
@endtask



@task('migrate', ['on' => 'web'])
    php artisan migrate
@endtask


@task('optimise', ['on' => 'web'])
    composer install --optimize-autoloader --no-dev
    php artisan optimize:clear
    php artisan optimize
@endtask

