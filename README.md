
# Office Management System

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




## API Reference

There is two response header ***Custom-Status-Message*** and ***Custom-Status-Code*** . They show information if the action is successful or unsuccessful . 
***Successful*** action start with ***2*** in ***Custom-Status-Code*** <br>
***Unsuccessful*** action start with ***3*** in ***Custom-Status-Code*** . 
<br>
Set this request header for all api call :
| Name | Value |
| --------- | --------- |
| Content-Type | application/json |
| Accept | application/json |

<br>
<br>



### Login a user

To log in to the API endpoint using cURL, you can use the following command:

#### Request
##### URL

```http
POST /api/login
```
##### Data
```json
{
 "email": "<email>",
 "password": "<password>"
}
```

#### Response

###### Data
```json
{
 "token": "<token-string>"
}
```
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2000 |
| Custom-Status-Message | login is successful |

Now set the token in request header for further api calls 
##### Header
| Name | Value |
| ----- | ---- |
| Authorization | Bearer token-string |

The following urls require **Authorization** header:
```http
POST /api/admin/
POST /api/boss/
POST /api/project_manager/
POST /api/employee/
```
<br>
<br>



### **Admin** - Add User

#### Request
##### URL

```http
POST /api/admin/user/add
```
##### Data
```json
{
"email":"<user-email>",
"username":"<user-name>",
"role":"<user-role>"
}
```
role can be **boss** , **project_manager** and **employee**

#### Response
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2001 |
| Custom-Status-Message | user is created |

A email will be sent to **user-email** which contains password
<br>
<br>



### **Boss** - Create a new team

#### Request
##### URL

```http
POST /api/boss/team/add
```
##### Data
```json
{
"team_name":"<team-name>",
"team_info":"<team-information>"
}
```
**team-name must be unique**

#### Response
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2002 |
| Custom-Status-Message | team is created |

<br>
<br>



### **Boss** - Create a new project

#### Request
##### URL

```http
POST /api/boss/project/add
```
##### Data
```json
{
"project_name": "<project-name>",
"project_info": "<project-information>",
"project_status":"<project-status>"
}
```
**project-name must be unique** . **project-status** is optional . **project-status** = **initiate** , **pending** , **completed** , **dropped**

#### Response
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2003 |
| Custom-Status-Message | project is created |

<br>
<br>




### **Boss** - Assign a project to a team
#### Request
##### URL

```http
POST /api/boss/project/{project_id}/assign
```
##### Data
```json
{
"team_id": "<team-id>"
}
```

#### Response
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2004 |
| Custom-Status-Message | project is assigned to the team |

<br>
<br>




### **Boss** - Add member to a team
#### Request
##### URL

```http
POST /api/boss/team/{team_id}/assign
```
##### Data
```json
{
"user_id": "<user-id>"
}
```
**user-id** must be the userid of employee and project_manager

#### Response
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2005 |
| Custom-Status-Message | user is assigned to the team |

<br>
<br>



### **Project Manager** - Add log a project

#### Request
##### URL

```http
POST /api/project_manager/project/log/{team_id}/{project_id}/add
```
##### Data
```json
{
"progress_info": "<log-text>",
"extra":<json-data>
}
```
**extra** is a optional field

#### Response
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2006 |
| Custom-Status-Message | project log is stored |

<br>
<br>



### **Project Manager** - Add assignment to a user (employee)
#### Request
##### URL

```http
POST /api/project_manager/assignment/{team_id}/{project_id}/add
```
##### Data
```json
{
"worker_id": "9a071436-d6ab-4530-aee2-b5ca9d2ce28f",
"assignment_name": "Rebuild it",
"assignment_info": "As soon as possible",
"assignment_status": "initiate",
"extra":{ <json-data> }
}
```
**assignment_status** and **extra**   are optional fields

#### Response
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2007 |
| Custom-Status-Message | assignment is added |

