Configurarea și utilizarea aplicației

Rularea aplicației
Porniți aplicația cu Docker, migrarea bazei de date și popularea acesteia:

Rulați comanda următoare pentru a construi și porni toate containerele Docker, împreună cu configurarea Laravel, migrarea bazei de date și popularea acesteia: make run-app-with-setup-db
Generați fișierele necesare JS și CSS:

Dacă fișierele JavaScript și CSS nu au fost deja generate, rulați: npm run build
Utilizator Admin Implicit:

După ce aplicația pornește, se va crea automat un utilizator cu adresa de email test@example.com și parola test. Acest utilizator va avea rolul admin și permisiuni complete, inclusiv service_id 1.
Crearea unui cont sau adăugarea unei rezervări:

Puteți să vă creați propriul cont sau să adăugați o rezervare la un serviciu. Dacă alegeți să creați un cont, folosiți utilizatorul test@example.com pentru a activa contul.
Gestionarea Utilizatorilor:

În meniul din stânga, veți găsi secțiunea User Management, unde puteți vizualiza toți utilizatorii.
Gestionarea Rezervărilor:

În bara de navigare veți găsi linkuri către rezervările făcute de utilizatorul conectat.
Dacă utilizatorul este managerul unui serviciu, acesta va putea vizualiza și edita rezervările făcute de alți utilizatori.
Testarea aplicației:

Pentru a rula testele, utilizați comanda: php artisan test
Atenție: Rularea testelor va șterge baza de date. O puteți reinițializa rulând: php artisan db:seed
Testarea API-ului REST cu Postman:

Am atașat o colecție Postman pentru testarea API-ului REST. Pentru a genera un token pentru utilizatorul test@example.com, rulați: php artisan user:token 1
API-ul de Rezervări:

Nu aveți nevoie de token pentru a adăuga o rezervare.
Totuși, pentru a vizualiza rezervările pentru un anumit serviciu, veți avea nevoie de un token generat pentru un utilizator cu service_id corespunzător.