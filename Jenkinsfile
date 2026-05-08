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
                sh 'docker compose down || true'
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
                sh 'sleep 15'
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

        stage('Laravel Migration') {
            steps {
                sh '''
                    docker exec $APP_CONTAINER php artisan migrate:fresh --seed --force
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