This is a basic laravel app with vue.js CRUD application.
1. clone this repo "https://github.com/minhas-abdulbasit/LaravelCRUD.git" and 
cd back-end 
2. Once inside back-end directory Run composer install 
3. Copy .env.example and create .env file 
4. inside .env file add mailtrap credentials to get emails
5. inside .env file update database credentials
6. Create database vuespa named, if other change the .env file configuration accordingly.
7. Run npm install && npm run development ( NOTE: if npm run development gives some errors try executing this command again if the error persist contact me.)
8. Run php artisan migrate
9. Run php artisan migrate:refresh --seed ( this will run migration with seeders)
10. Open terminal and run php artisan serve
11. Open another terminal and run npm run watch
12. application will be accessible by now from URL : http://127.0.0.1:8000/login
13. Hope I have not forgotten any process in this. 