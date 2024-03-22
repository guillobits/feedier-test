## How to initialize the project ?
The project run under Docker, you can easily setup all the projects by running these commands:

#### 1. Copy the .env file
```shell
cp .env.example .env
```

#### 2. Install the composer dependencies
```shell
docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v "$(pwd):/var/www/html" \
  -w /var/www/html \
  laravelsail/php83-composer:latest \
  composer install --ignore-platform-reqs
```

#### 3. Run the migrations
```shell
./vendor/bin/sail artisan migrate
```

#### 4. Install and build the frontend
```shell
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

### You're good to start!
