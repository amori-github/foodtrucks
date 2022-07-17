Guide d'instalation
    
     git clone https://github.com/amori-github/foodtrucks.git
     cd foodtrucks/
     composer install
     php bin/console doctrine:database:create
     php bin/console make:migration
     php bin/console doctrine:migrations:migrate
     symfony server:start

Lien de l'api

     http://127.0.0.1:8000/ApiFoodTrucks/post

Exemple de Jeux de données de l'api
    
    {
    "name" : "amori",
    "firstName" : "med",
    "email": "med@gmail.com",
    "date" : "20-07-2022"
    }


 
     
 