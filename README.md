# ✈️ KZ AIRLINES

![KZ (3)](https://github.com/user-attachments/assets/3bd4b8f4-4300-414f-a9c2-7470bb830f17)

KZ Airlines is a flight booking website that lets you manage your bookings the way you want.

##  Characeristics

* __Book and cancel flight reservations__.

* __A dashboard to view all your future and past bookings__.
![image](https://github.com/user-attachments/assets/1d494b67-7ac5-4518-95d3-c5e7de169e70)

##  How to Install

### Prerequisites:

* __PHP language version 8.2 or above:__ https://www.php.net/downloads.php.

* __MySQL Database:__ https://dev.mysql.com/downloads/.

* __Composer dependency manager for PHP:__ https://getcomposer.org/.

* __Node.js latest stable version:__ https://nodejs.org/en.

### Installation Steps

1. Clone the repo:

```
git clone https://github.com/TOKIO-V2/KZAIRLINES.git
```

2. Inside the cloned repository, install the required dependencies:

```
composer install && npm install
```

3. Copy `.env.example` and create a new file called `.env`:

```
cp .env.example .env
```

4. Generate a new key for laravel:

```
php artisan key:generate
```

5. Check that the MySQL service is running and then migrate the database by running the command below:

```
php artisan migrate
```

Once you've done all the previous steps finally you can initialize the server and start using the application:

```
npm run build && composer run dev --timeout 1000000
```

## API Endpoints

The application integrates JWT to manage user authentication when consuming the API, meaning that you must employ the login endpoints before making requests to any other endpoint. Below you will see a list containing all the available endpoints alongside their respective methods and json structure (if they possess one).

### Authentication

> __POST__ /api/auth/register
```
{"name", "email", "password", "password_confirmation"}
```

> __POST__ /api/auth/login
```
{"email", "password"}
```

> __POST__ /api/auth/me

> __POST__ /api/auth/refresh

> __POST__ /api/auth/logout

---

### Airplanes

> __GET__ /api/planes

> __GET__ /api/planes/{id}

> __POST__ /api/planes (Admin Only)
```
{"name", "max_capacity"}
```

> __PUT__ /api/planes/{id} (Admin Only)
```
{"name", "max_capacity"}
```

> __DELETE__ /api/planes/{id} (Admin Only)

---

### Flights

> __GET__ /api/flights

> __GET__ /api/flights/{id}

> __POST__ /api/flights (Admin Only)
```
{"date", "origin", "destination", , "planeId", "available", "reserved"}
```

> __PUT__ /api/flights/{id} (Admin Only)
```
{"date", "origin", "destination", , "planeId", "available", "reserved"}
```

> __DELETE__ /api/flights/{id} (Admin Only)

## 🐬 Database Diagram
![image](https://github.com/user-attachments/assets/1dbcddf8-34b4-4fc1-b224-a96eb62a0b45)

## 🧪 Tests

To test the application execute the command below:

```
php artisan test --coverage-html=coverage-report
```
![Test KZAIRLINES](https://github.com/user-attachments/assets/83124f8d-bfbb-455d-8865-db36a5b0cfca)

## 🛠️ Languages and Tools Used

### Front End:

[![Front End Stack](https://skillicons.dev/icons?i=js,html,css,bootstrap)](https://skillicons.dev)

### Back End:

[![Back End Stack](https://skillicons.dev/icons?i=laravel,php,mysql,nodejs,vite)](https://skillicons.dev)


## 🧑‍💻 Author

__Alberto Hernández Galeote, Backend and Frontend Developer.__

[![Github](https://skillicons.dev/icons?i=github)](https://github.com/TOKIO-V2/)
[![Linkedin](https://skillicons.dev/icons?i=linkedin)](www.linkedin.com/in/albertohernandezgaleote)
