pipeline {

    agent any

    environment {
        APP_CONTAINER = "laravel-app"
        MYSQL_CONTAINER = "mysql-db"
        PHPMYADMIN_CONTAINER = "phpmyadmin"
    }

    stages {

        stage('Clone Repository') {
            steps {
                git branch: 'master',
                url: 'https://github.com/amzadhossainjacky/jenkins-docker-laravel-deployment'
            }
        }

        stage('Stop Previous Containers') {
            steps {
                sh '''
                    docker compose down --remove-orphans || true

                    docker rm -f laravel-app || true
                    docker rm -f mysql-db || true
                    docker rm -f phpmyadmin || true
                    docker rm -f nginx || true
                '''
            }
        }

        stage('Build Docker Containers') {
            steps {
                sh 'docker compose build --no-cache'
            }
        }

        stage('Run Docker Containers') {
            steps {
                sh 'docker compose up -d'
            }
        }

        stage('Wait For App Startup') {
            steps {
                sh 'sleep 5'
            }
        }

        stage('Composer Install') {
            steps {
                sh '''
                    docker exec $APP_CONTAINER composer install
                '''
            }
        }

        stage('Laravel Key Generate') {
            steps {
                sh '''
                    docker exec $APP_CONTAINER php artisan key:generate
                '''
            }
        }

        stage('Laravel Permissions') {
            steps {
                sh '''
                    docker exec $APP_CONTAINER chmod -R 777 storage bootstrap/cache
                '''
            }
        }

        stage('Laravel Storage Link') {
            steps {
                sh '''
                    docker exec $APP_CONTAINER php artisan storage:link || true
                '''
            }
        }

        stage('Laravel Migration') {
            steps {
                sh '''
                    docker exec $APP_CONTAINER php artisan migrate --force
                '''
            }
        }

        stage('Laravel Cache Clear') {
            steps {
                sh '''
                    docker exec $APP_CONTAINER php artisan config:clear
                    docker exec $APP_CONTAINER php artisan cache:clear
                    docker exec $APP_CONTAINER php artisan route:clear
                    docker exec $APP_CONTAINER php artisan view:clear
                '''
            }
        }

        stage('Show Running Containers') {
            steps {
                sh 'docker ps'
            }
        }

    }
}