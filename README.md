step 1 - project clone using repository - https://github.com/devangdataaro/AI-vector-based-search.git

step 2 - setpa .env file and change database name,user name & password

step 3 - required software list -
        1 php 8.2
        2 letest composer 
        3 mysql
        4 node js 18.20.8

step 4 - run command
    1 composer install
    2 npm install
    3 npm run build
    4 php artisan migrate
    5 php artisan import:categories storage/app/categories.xlsx  (categories.xlsx file added same location) 
    6 php artisan serve
    7 http://127.0.0.1:8000/  run any browser

note - please add open API key required

I have using open AI model name: 'text-embedding-3-small'

