## PHP Notes Application

An application that allows you to manage your own notes. The application works with the local database on which the notes are saved. The project was created as part of PHP online course.

## Getting Started

#### To test this project on your computer, please follow the instructions below:

Install XAMPP and launch XAMPP Control Panel.

Open httpd-vhosts.conf file in your editor:
```
C:\xampp\apache\conf\extra
```
Delete all its content and add code below with the appropriate completed directory fields
```
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/"
    ServerName localhost
</VirtualHost>

<VirtualHost *:80>
    DocumentRoot "PATH TO THE PHP-NOTES-APP YOU CLONED"
    ServerName notes.localhost
    <Directory "PATH TO THE PHP-NOTES-APP YOU CLONED">
        Require all granted
    </Directory>
</VirtualHost>
```

Open hosts file in your editor:
```
C:\windows\system32\drivers\etc\hosts
```
And add two lines of code below
```
127.0.0.1       localhost
127.0.0.1       notes.localhost
```

Run Apache and MySQL modules in XAMPP Control Panel.

Go to the phpMyAdmin website:
``` 
http://localhost/phpmyadmin/ 
```

Create new database and name it 'notes'.\
In new created database add table and name it 'notes'.\
Create user with all data privileges in notes database, name him 'user_notes' and set password as 'UdhIeAr39glj9CP1'.\
If you want to name something different or set a different password for the user, remember to change it in the config.php file.

You are set up now and can go to the application website:
```
notes.localhost
```

## Used Technologies

PHP, CSS, HTML, FontAwesome.