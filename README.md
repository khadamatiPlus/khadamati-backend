<h3>First Time Setup Steps:</h3>
<ol>
<li>Rename the .env.example file to .env</li>
<li>Run `composer install` in terminal</li>
<li>Run `php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"`</li>
<li>Make sure you have npm package manager installed in your machine</li>
<li>Run `npm install` in terminal</li>
<li>Run `php artisan key:generate`</li>
<li>Please make sure you have created the DB into your server</li>
<li>Run `php artisan migrate`</li>
<li>Run `php artisan db:seed`</li>
<li>Run `npm run dev` to build the styles and scripts</li>
<li>Add firebase Admin SDK config file to project root</li>
<li>Add firebase credentials keys and DB url in .env file</li>

</ol>

<h3>Super Admin Credentials</h3>

<strong>Admin:</strong> admin@admin.com<br /><strong>Password:</strong> secret
