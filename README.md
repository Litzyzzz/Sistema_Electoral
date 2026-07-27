**Deben tener composer y mysql instalado**

**Recordar siempre verificar el .env tenga las credenciales y conexión a mysql y la base de datos**

**Deben al menos tener creado en mysql la base de datos yo la nombré: bd_votaciones**


instrucciones:

instalar en la terminal

composer install
npm install
cp .env.example .env 
php artisan key:generate -->es una llave que genera la APP_KEY que laravel usa 
php artisan migrate --> este les crea todas las tablas ya hechas en laravel y las pasa al mysql

luego hacen en otra terminal:
npm run dev

y en otra terminal:
 php artisan serve
