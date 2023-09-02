
# Project Title

A brief description of what this project does and who it's for

```bash
php artisan migrate
```

open database/seeders/UserSeeder.php and replace with your desired email and password
```php
$user = User::create([
      'name' => '<any-name>',
      'password' => Hash::make('<any-password>'),
      'email' => '<any-email>',
    ]);
```

```bash
php artisan db:seed UserSeeder
```

open database/seeders/AssignRoleSeeder.php and replace with email to set as admin role
```php
$email = 'alex_admin@gmail.com';
$user = User::where('email', $email)->first();
$role = Role::findByParam(["name" => 'admin']);
$user->assignRole($role);
```

Run this to create appropiate roles
```bash
php artisan db:seed RoleSeeder
```

## API Reference

#### Login a user


To log in to the API endpoint using cURL, you can use the following command:

##### Request
```bash
curl -X POST 'http://127.0.0.1:8000/api/login' \
     -H 'Content-Type: application/json' \
     -H 'Accept: application/json' \
     -d '{
             "email": "<email>",
             "password": "<password>"
         }'
```

##### Response
###### content
```json
{
  "token": "387f400663e8e171ced8cf8fc096e9410f8f95ed7c1201b90848817ae0cf19bb"
}
```
