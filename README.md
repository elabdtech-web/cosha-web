<h3>How to setup this project</h3>
<ol>
<li>Clone this repository</li>
<li>Install dependencies by running `composer install`</li>
<li>Copy `.env.example` to `.env` and fill in the database credentials</li>
<li>Run `php artisan migrate` to create the database tables</li>
<li>Run `php artisan passport:client --personal` to create the OAuth 2.0 client credentials</li>
<li>Run `php artisan db:seed` to seed the database with sample data</li>
<li>Run 'php artisan storage:link' to link the storage directory</li>
<li>Run `php artisan serve` to start the development server</li>
<li>Open http://localhost:8000 in your browser</li>
</ol>

<h5>Admin login</h5>
<ol>
<li>Open http://localhost:8000/admin/login in your browser</li>
<li>Admin login with `admin@gmail.com`/`admin@123`</li>
</ol>

<h5>Passenger login</h5>
<ol>
<li>Open http://localhost:8000/passenger/login in your browser</li>
<li>Passenger login with `passenger@gmail.com`/`passenger@123`</li>
</ol>

<h5>Driver login</h5>
<ol>
<li>Open http://localhost:8000/driver/login in your browser</li>
<li>Driver login with `driver@gmail.com`/`driver@123`</li>
</ol>

<h6>Thanks for reading!</h6>
