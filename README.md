## Setup Local Test
1. `docker-compose up -d`
2. `docker exec tan_w2a-php83 composer install && docker exec tan_w2a-php83 php yii migrate`
3. `cd frontend_vuejs && npm install && npm run serve`

Test on http://localhost:1112

On 1st time to click Facebook login, it will display `init not called with valid version` 
cause localhost without HTTPS, F5 page and click button again, it will work.


### Frontend: VueJS3, Responsive Design, TailwindCSS
- `/` Home
- `/login` Login
- `/register` Register
- `/dashboard` Dashboard (require login, if not logged in, redirect to /login, load data from api.nasa.gov, pagination)


### Backend: Yii2, RESTful API, JWT
- `/index.php?r=auth/login` API Login (validation inputs, return token, redirect to /dashboard)
- `/index.php?r=auth/register` API Register (validation inputs, add user to db, return token, redirect to /dashboard)
- `/index.php?r=auth/check` API Simple check logged token.