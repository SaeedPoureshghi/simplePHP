# simplePHP  
A PHP framework for easy developing

## Clone repository
```
git clone https://github.com/SaeedPoureshghi/simplePHP.git
```

## Config db settings and define admin user ids in tbl_accounts table
```
$ nano ./lib/db.php
```

## Define routes
```
$ nano index.php
```
# Routes 

## Add routes
```
Route::add('/path/to/route','GET')
```

## Routes ACL
```
Route::all(); // All users can run
Route::add('/','GET');

Route::auth(); // Only logined user can run
Route::add('/dashboard','GET');

Route::admin(); // Only admin users can run
Route::add('/admins','GET');
```

```Route::all()``` is general routes that everyone can run it. ```Route::auth()``` all routes defined after this role only can run by authenticated users. ```Route::admin();```
all routes defined after this role can run by admin users.

## Define route's functions
All functions defined on ```functions``` folder and desired ```.php``` files. It is better to seperate files.

Examples :
- route in ```./index.php```
```
Route::add('/api/users/list','POST');
```
- function in ```./functions/main.php```
```
function ApiUsersList(){
// code here
}
```

Defualt ```/``` route's function name is ```Index()```
