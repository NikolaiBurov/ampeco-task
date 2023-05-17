# Ampeco Task Project

This is a guide on how to download and set up the the project using Docker. Follow the steps below to get started.



## Installation

1.Clone the repository to your local machine:

```bash
git clone https://github.com/NikolaiBurov/ampeco-task/
```

2.Get into the folder and start building the containers
```bash
cd repository
docker-compose build
docker-compose up -d
```
3.Log in into the backend laravel container

```bash
docker ps
docker exec -it <bitcoin-tracker-container-id> bash
```

4.Configure the project for testing
```bash
cp .env.example .env
chmod -R 777 /storage
composer install
php artisan migrate
```

5.Afterwards you can start the two workers which are: 
```bash
    One for the cron job -> php artisan schedule:work
    One for the queue that will process emails -> php artisan queue:work
```

## Testing
Open http://bitcoin-tracker.localhost/ to get to the project main page

To test the project mail functionality, you can open MailCatcher on http://localhost:8100/ in your web browser. This allows you to view the sent emails and verify their content.

