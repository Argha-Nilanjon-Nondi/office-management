
# Office Management System

The **Office Management System** is a **Laravel-based** project that has admin, boss, project manager, and employee roles. The system helps perform day-to-day activities of an office, including team management, task management, project management, assignment management,and user management

<br>
<br>

## Feature
Actually the project is not ready . I had to leave it in the midway because of my HSC-2024 examination.
So I am not sure about this .

<br>
<br>
<br>

## Installation
Run all migrations
```bash
php artisan migrate
```
<br>

Set up a **mailtrap** account and see there docs for laravel integration . <br>
Save .env file 

```env
APP_NAME=Office_Management
APP_ENV=local
APP_KEY=base64:or2JJVkslXEwrK7hs/WNfB3dhEVculsnK7hQbc/FxZg=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=office_management
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=<mailtrap-username>
MAIL_PASSWORD=<mailtrap-password>
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

<br>
<br>
<br>


## Set up Blockchain
Run this command to mint genesis block in **audits** table
```bash
php artisan db:seed GenesisAuditSeeder
```

Run this command to generate nonce and hash 
- This will generate nonce for first 5 record
```bash
php artisan blockchain:block-hash
```
You can change the number of record to be hashed by 
addding more **$this->make_hash();** in **handle()** method of **app/Console/Commands/CommandBlockHash.php**

<br>
<br>
<br>

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


<br>
<br>
<br>


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
```
/api/profile/
/api/logout/
/api/setting/
/api/admin/
/api/boss/
/api/project_manager/
/api/employee/
```
<br>
<br>

### **User** - Profile of a user

#### Request
##### URL

```http
GET /api/profile
```

#### Response
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2015 |
| Custom-Status-Message | user profile is retrieved |

##### Data
```json
{
  "id": "<user-id>",
  "name": "<user-name>",
  "email": "<user-email>",
  "email_verified_at": null,
  "created_at": "<date-time>",
  "updated_at": "<date-time>",
  "teams": [
    {
      "team_id": "<team-id>"
    }
  ],
  "projects": [
    {
      "project_id": "<project-id>"
    }
  ],
  "role": "<user-role>"
}
```
<br>
<br>

### **User** - Logout a user

#### Request
##### URL

```http
GET /api/logout
```

#### Response
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2016 |
| Custom-Status-Message | user is logout |

<br>
<br>

### **User** - Access token list

#### Request
##### URL

```http
GET /api/setting/token
```

#### Response
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2017 |
| Custom-Status-Message | token list is retrieved |

##### Data
```json
[
  {
    "id":"<token-id>",
    "name": "<device-name>",
    "created_at": "<date-time>",
    "last_used_at": "<date-time>"
  }
]
```
<br>
<br>

### **User** - Delete access token

#### Request
##### URL

```http
GET /api/setting/token/delete/{token_id}
```

#### Response
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2018 |
| Custom-Status-Message | token is deleted |

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

A email will be sent to **"user-email"** which contains password
<br>
<br>

### **Admin** - Log list of a object (Record)

#### Request
##### URL

```http
GET /api/admin/history/{object_id}/?page={page_no}
```

#### Response
##### Data
```json
"data": [
    {
      "user_type": "<action-performer-type>",
      "user_id": "<action-performer-id>",
      "event": "<crud-operation-name>",
      "auditable_type": "<model-name>",
      "auditable_id": "<object-id>",
      "old_values": [],
      "new_values": {
        "team_id": "<team-id>",
        "user_id": "<user-id>",
        "pair_id": "<object-id>",
        "updated_at": "<date-time>",
        "created_at": "<date-time>"
      },
      "ip_address": "<action-performer-ip>",
      "url": "<url-where-action-occured>",
      "user_agent": "<action-performer-device>",
      "created_at": "<date-time>",
      "updated_at": "<date-time>",
      "nonce": 21105,
      "current_hash": "0000e45fc9d105eeaeaab65d00709dc766bae4a2bbee00b848f8974c34577e53",
      "previous_hash": "000019827377f3631ae9514c2257b6f8bee90130df8aade53d63e93ec7e456af"
    }
  ],
```
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2019 |
| Custom-Status-Message | history object list is retrieved |

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
**"team-name" must be unique**

#### Response
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2002 |
| Custom-Status-Message | team is created |

<br>
<br>

### **Boss** - Get team list

#### Request
##### URL

```http
GET /api/boss/team/
```

#### Response

##### Data
```json
{
"data":[
    {
    "team_id": "<team-id>",
    "team_name": "<team-name>"
    }
  ]
}
```

##### Header

| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2008 |
| Custom-Status-Message | team list is retrieved |

<br>
<br>

### **Boss** - Get single Team detail

#### Request
##### URL

```http
GET /api/boss/team/{team_id}
```

#### Response

##### Data
```json
{
"team_id": "<team-id>",
"project_id": "<project-id>",
"team_name": "<team-name>",
"team_info": "<team-info>",
"created_at": "<date-time>",
"updated_at": "<date-time>",
"team_members": [
  {"user_id": "<user-id>"}
  ]
}
```

##### Header

| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2009 |
| Custom-Status-Message | single team data is retrieved |

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
**"project-name" must be unique** . **project-status** is optional . **project-status** = **initiate** , **pending** , **completed** , **dropped**

#### Response
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2003 |
| Custom-Status-Message | project is created |

<br>
<br>

### **Boss** - Get project list

#### Request
##### URL

```http
GET /api/boss/project/
```

#### Response

##### Data
```json
{
"data": [
    {
    "project_id": "<project-id>",
    "project_name": "<project-name>"
    }
  ],
}
```

##### Header

| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2010 |
| Custom-Status-Message | project list is retrieved |

<br>
<br>

### **Boss** - Get single project detail

#### Request
##### URL

```http
GET /api/boss/project/{project_id}
```

#### Response

##### Data
```json
{
"project_id": "<project-id>",
"project_name": "<project-name>",
"project_info": "<project-info>",
"project_status": "<project-status>",
"created_at": "<date-time>",
"updated_at": "<date-time>",
"team_id": "<team-id>"
}
```

##### Header

| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2011 |
| Custom-Status-Message | single project data is retrieved |

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
**"user-id"** must be the userid of employee and project_manager

#### Response
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2005 |
| Custom-Status-Message | user is assigned to the team |

<br>
<br>

### **Project Manager** - Get team list

#### Request
##### URL

```http
GET /api/project_manager/team/
```

#### Response

##### Data
```json
{
"data":[
    {
    "team_id": "<team-id>",
    "team_name": "<team-name>"
    }
  ]
}
```

##### Header

| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2008 |
| Custom-Status-Message | team list is retrieved |

<br>
<br>

### **Project Manager** - Get single Team detail

#### Request
##### URL

```http
GET /api/project_manager/team/{team_id}
```

#### Response

##### Data
```json
{
"team_id": "<team-id>",
"project_id": "<project-id>",
"team_name": "<team-name>",
"team_info": "<team-info>",
"created_at": "<date-time>",
"updated_at": "<date-time>",
"team_members": [
  {"user_id": "<user-id>"}
  ]
}
```

##### Header

| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2009 |
| Custom-Status-Message | single team data is retrieved |

<br>
<br>

### **Project Manager** - Get project list

#### Request
##### URL

```http
GET /api/project_manager/project/
```

#### Response

##### Data
```json
{
"data": [
    {
    "project_id": "<project-id>",
    "project_name": "<project-name>"
    }
  ],
}
```

##### Header

| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2010 |
| Custom-Status-Message | project list is retrieved |

<br>
<br>

### **Project Manager** - Get single project detail

#### Request
##### URL

```http
GET /api/project_manager/project/{project_id}
```

#### Response

##### Data
```json
{
"project_id": "<project-id>",
"project_name": "<project-name>",
"project_info": "<project-info>",
"project_status": "<project-status>",
"created_at": "<date-time>",
"updated_at": "<date-time>",
"team_id": "<team-id>"
}
```

##### Header

| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2011 |
| Custom-Status-Message | single project data is retrieved |

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
"extra":{"<json-data>"}
}
```
**"extra"** is a optional field

#### Response
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2006 |
| Custom-Status-Message | project log is stored |

<br>
<br>

### **Project Manager** - Get project log list 

#### Request
##### URL

```http
GET /api/project_manager/project/log/{project_id
```

#### Response

##### Data
```json
{
"data": [
    {
    "project_id": "<project-id>",
    "history_id": "<history-id>",
    "progress_info": "<progress-info>",
    "created_at": "<date-time>",
    "updated_at": "<date-time>"
    }
  ],
}
```

##### Header

| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2012 |
| Custom-Status-Message | project log list is retrieved |

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
"worker_id": "<worker-id>",
"assignment_name": "<assignment-name>",
"assignment_info": "<assignment-info>",
"assignment_status": "<assignment-status>",
"extra":{ "<json-data>" }
}
```
**"assignment_status"** and **"extra"**   are optional fields

#### Response
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2007 |
| Custom-Status-Message | assignment is added |

<br>
<br>
<br>

### **Project Manager** - Get Assignment list
#### Request
##### URL

```http
GET /api/project_manager/assignment/{team_id}/{project_id}/
```

#### Response
##### Data
```json
{
"data": [
    {
      "assignment_id": "<assignment-id>",
      "assignment_name": "<assignment-name>"
    }
  ]
}
```
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2014 |
| Custom-Status-Message | assignment list is retrieved |

<br>
<br>
<br>

### **Project Manager** - Get single Assignment details
#### Request
##### URL

```http
GET /api/project_manager/assignment/{assignment_id}
```


#### Response
##### Data
```json
{
  "assignment_id": "<assignment-id>",
  "team_id": "<team-id>",
  "project_id": "<project-id>",
  "assigner_id": "<assigner-id>",
  "worker_id": "<worker-id>",
  "assignment_name": "<assignment-name>",
  "assignment_info": "<assignment-info>",
  "assignment_status": "<assignment-status>",
  "extra": {"<json-data>"},
  "created_at": "<date-time>",
  "updated_at": "<date-time>"
}
```
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2013 |
| Custom-Status-Message | single assignment data is retrieved |

<br>
<br>
<br>

<br>
<br>
<br>

### **Employee** - Get team list

#### Request
##### URL

```http
GET /api/employee/team/
```

#### Response

##### Data
```json
{
"data":[
    {
    "team_id": "<team-id>",
    "team_name": "<team-name>"
    }
  ]
}
```

##### Header

| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2008 |
| Custom-Status-Message | team list is retrieved |

<br>
<br>

### **Employee** - Get single Team detail

#### Request
##### URL

```http
GET /api/employee/team/{team_id}
```

#### Response

##### Data
```json
{
"team_id": "<team-id>",
"project_id": "<project-id>",
"team_name": "<team-name>",
"team_info": "<team-info>",
"created_at": "<date-time>",
"updated_at": "<date-time>",
"team_members": [
  {"user_id": "<user-id>"}
  ]
}
```

##### Header

| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2009 |
| Custom-Status-Message | single team data is retrieved |

<br>
<br>

### **Employee** - Get project list

#### Request
##### URL

```http
GET /api/employee/project/
```

#### Response

##### Data
```json
{
"data": [
    {
    "project_id": "<project-id>",
    "project_name": "<project-name>"
    }
  ],
}
```

##### Header

| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2010 |
| Custom-Status-Message | project list is retrieved |

<br>
<br>

### **Employee** - Get single project detail

#### Request
##### URL

```http
GET /api/employee/project/{project_id}
```

#### Response

##### Data
```json
{
"project_id": "<project-id>",
"project_name": "<project-name>",
"project_info": "<project-info>",
"project_status": "<project-status>",
"created_at": "<date-time>",
"updated_at": "<date-time>",
"team_id": "<team-id>"
}
```

##### Header

| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2011 |
| Custom-Status-Message | single project data is retrieved |

<br>
<br>

### **Employee** - Get Assignment list
#### Request
##### URL

```http
GET /api/employee/assignment
```


#### Response
##### Data
```json
{
"data": [
    {
      "assignment_id": "<assignment-id>",
      "assignment_name": "<assignment-name>"
    }
  ]
}
```
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2014 |
| Custom-Status-Message | assignment list is retrieved |

<br>
<br>
<br>

<br>
<br>
<br>

### **Employee** - Get single Assignment details
#### Request
##### URL

```http
GET /api/employee/assignment/{assignment_id
```


#### Response
##### Data
```json
{
  "assignment_id": "<assignment-id>",
  "team_id": "<team-id>",
  "project_id": "<project-id>",
  "assigner_id": "<assigner-id>",
  "worker_id": "<worker-id>",
  "assignment_name": "<assignment-name>",
  "assignment_info": "<assignment-info>",
  "assignment_status": "<assignment-status>",
  "extra": {"<json-data>"},
  "created_at": "<date-time>",
  "updated_at": "<date-time>"
}
```
##### Header
| Name | Value |
| ----- | ---- |
| Custom-Status-Code | 2013 |
| Custom-Status-Message | single assignment data is retrieved |

<br>
<br>
<br>

<br>
<br>
<br>



## Acknowledgements

### Documentation:
- [Laravel Documentation](https://laravel.com/)
- [Laravel Auditing Documentation](https://laravel-auditing.com/)
- [Spatie Laravel Permission Documentation](https://spatie.be/docs/laravel-permission/v5/basic-usage/teams-permissions)


### Stackoverflow
- [Stack Overflow - MySQLi Real Connect Error](https://stackoverflow.com/questions/29928109/getting-error-mysqlireal-connect-hy000-2002-no-such-file-or-directory-wh)
- [Stack Overflow - No Such File or Directory Error](https://stackoverflow.com/questions/46407490/no-such-file-or-directory-or-no-such-host-is-known-when-running-migrations)
- [Stack Overflow - Laravel File Put Contents Exclusive Locks](https://stackoverflow.com/questions/47921408/laravel-file-put-contents-exclusive-locks-are-not-supported-for-this-stream)
- [Stack Overflow - MySQL InnoDB Not Starting](https://stackoverflow.com/questions/8829793/mysql-not-starting-innodb-not-available)
- [Stack Overflow - Access Denied for User](https://stackoverflow.com/questions/17975120/access-denied-for-user-rootlocalhost-using-password-yes-no-privileges)
- [Stack Overflow - How to Drop Database](https://stackoverflow.com/questions/2046681/how-to-drop-database)
- [Stack Overflow - Laravel "No Role Named Admin"](https://stackoverflow.com/questions/60710341/there-is-no-role-named-admin-laravel)
- [Stack Overflow - Role or Permission Should Use Guard](https://stackoverflow.com/questions/50984164/the-given-role-or-permission-should-use-guard-instead-of-web-laravel)
- [Stack Overflow - phpMyAdmin Failed to Set Session Cookie](https://stackoverflow.com/questions/49811804/phpmyadmin-failed-to-set-session-cookie-maybe-you-are-using-http-instead-of-htt)
- [Stack Overflow - Using UUID as Default Value in Laravel Migration](https://stackoverflow.com/questions/54866478/using-uuid-as-default-value-in-a-laravel-migration)
- [Stack Overflow - Properly Handle Errors in Laravel API](https://stackoverflow.com/questions/51065170/laravel-api-how-to-properly-handle-errors)


### Others
- [Implement UUID Primary Key in Laravel](https://dev.to/adnanbabakan/implement-uuid-primary-key-in-laravel-and-its-benefits-55o3)
- [Linode Community - MySQL Aria Control File](https://www.linode.com/community/questions/17989/why-cant-mysql-access-the-aria-control-file)
- [Install phpMyAdmin in Termux (Android)](https://www.easymux.in/how-to-install-phpmyadmin-in-termux-android/amp/)
- [GitHub - Spatie Laravel Permission Discussions](https://github.com/spatie/laravel-permission/discussions/1947)
- [Freek.dev - When to Use Gate::after in Laravel](https://freek.dev/1325-when-to-use-gateafter-in-laravel)
- [Install phpMyAdmin in Termux (Android)](https://www.easymux.in/how-to-install-phpmyadmin-in-termux-android/amp/)
- [Mailtrap.io - Send Email in Laravel](https://mailtrap.io/blog/send-email-in-laravel/)
- [Mailtrap.io - Send Email in Laravel (Google AMP)](https://www.google.com/amp/s/mailtrap.io/blog/send-email-in-laravel/amp/)

<br>
I would like to acknowledge that during the development of this project, I received valuable coding assistance from AI and chatbot services. The services that contributed to my coding process include:

- [chat.openai.com](https://chat.openai.com/): This AI-powered chatbot service provided me with suggestions, explanations, and code snippets that helped me overcome coding challenges in various parts of the project.

- [perplexity.ai](https://perplexity.ai/): I utilized the capabilities of perplexity.ai to refine my code by evaluating its readability and complexity, ensuring that the codebase follows best practices.

These AI and chatbot services significantly enhanced my productivity and problem-solving capabilities. While the assistance from these services played a role in my development process, I reviewed, customized, and integrated all code in this repository to ensure its correctness and alignment with the project's goals.

I extend my gratitude to the developers and teams behind chat.openai.com and perplexity.ai for creating tools that provide innovative solutions for coding challenges.
