@servers(['web' => 'justin-card@13.39.150.46'])


@story("deploy")
    update-dependencies
    migrate
    optimise
@endstory

@task('update-dependencies', ['on' => 'web'])
    cd /home/justin-card/justin-card.dhonnabhain.me/app
    composer install
    npm install
    npm run build
@endtask



@task('migrate', ['on' => 'web'])
    cd /home/justin-card/justin-card.dhonnabhain.me/app
    php artisan migrate --force
@endtask


@task('optimise', ['on' => 'web'])
    cd /home/justin-card/justin-card.dhonnabhain.me/app
    composer install --optimize-autoloader --no-dev
    php artisan optimize:clear
    php artisan optimize
@endtask

