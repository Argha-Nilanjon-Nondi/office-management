
## API Reference

There is two response header ***Custom-Status-Message*** and ***Custom-Status-Code*** . They show information if the action is successful or unsuccessful . 
***Successful*** action start with ***2*** in ***Custom-Status-Code*** <br>
***Unsuccessful*** action start with ***3*** in ***Custom-Status-Code***


#### Login a user


To log in to the API endpoint using cURL, you can use the following command:

##### Request

```curl

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

###### header

# Project Title

A brief description of what this project does and who it's for

```bash
php artisan migrate
```










## Setup an Admin
You have to setup admin manually to use the project initially

open 
***database/seeders/UserSeeder.php*** and replace with your desired ***username,email,password***
```php
User::create([
       'name' => '<any-name>',
       'password' => Hash::make('<any-password>'),
       'email' => '<any-email>',
]);
```
Run ***UserSeeder*** to create admin

```bash
php artisan db:seed UserSeeder
```
<br>

open ***database/seeders/RoleSeeder.php*** 
```php
Role::create(['name' => 'admin']);
Role::create(['name' => 'boss']);
Role::create(['name' => 'project_manager']);
Role::create(['name' => 'employee']);
```

Run ***RoleSeeder*** to create appropiate roles

```bash
php artisan db:seed RoleSeeder
```

<br>

open ***database/seeders/AssignRoleSeeder.php*** and replace with email to set as admin role
```php
$email = '<your-admin-email>';
$user = User::where('email', $email)->first();
$role = Role::findByParam(["name" => 'admin']);
$user->assignRole($role);
```

Run ***AssignRoleSeeder*** to assign admin to user

```bash
php artisan db:seed AssignRoleSeeder
```