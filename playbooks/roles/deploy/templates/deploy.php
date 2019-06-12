<?php

namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'indeed');

// http_user
set('http_user', '{{ web_user }}');

// Project repository
set('repository', 'https://github.com/tomoyukikishimoto/laravel.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);


// Hosts

host('dev')
    ->hostname('localhost')
    ->user('{{ web_user }}')
    ->identityFile('~/.ssh/server.pem')
    ->set('branch', 'develop')
    ->set('deploy_path', '/var/www/indeed')
    ->stage('dev');

host('stage')
    ->hostname('localhost')
    ->user('{{ web_user }}')
    ->identityFile('~/.ssh/server.pem')
    ->set('branch', 'master')
    ->set('deploy_path', '/var/www/indeed')
    ->stage('stage');

host('production')
    ->hostname('localhost')
    ->user('{{ web_user }}')
    ->identityFile('~/.ssh/server.pem')
    ->set('branch', 'master')
    ->set('deploy_path', '/var/www/indeed')
    ->stage('production');

// Tasks

task('build', function () {
    run('cd ' . get('release_path') . ' && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

task('deploy:init', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'cleanup'
]);
