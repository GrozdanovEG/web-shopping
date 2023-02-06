# Web Shopping Application 

## Description and Usage 
- The "Web Shopping Application" application is developed with all the initially required
  features implemented (see the section "Required features");  
- The application requires PHP 8.0+ and MySQL compatible DBMS;  
- To run the application it is necessary to create the databases and tables,
executing the queries inside the files `/src/Storage/user-and-database.sql` and `/src/Storage/structure.sql`;   
- A script to facilitate the database, user and table creation is accessible on
 `http://HOSTNAME/storageinit.php` after the application is initially run with `/public/` as a *DocumentRoot* ;  
- By default, the application is designed to run with own database user, with privileges limited to applications database and tables.
  The credentials are hardcoded inside `\Storage\StorageData` class. If you intend to create the database and tables and
  run it with different user, don't forget to modify the values where it is needed;  
- The application is ready for review and initial run;  

## Required features
CRUD - Price List/Catalogue Products  - Implemented  
CRUD - Cart/Basket Products           - Implemented  
CR   - Orders / Carts (Checkout and listing history) - Implemented  
Quantities management and persistence - Implemented  

## Possible further improvements
Further improvements are possible in the future like better user input validation and refactoring
but for now the project is abandoned for certain time in favour of other projects;

## Where to find   
URI/HTTPS: <https://gitlab.com/GrozdanovEG/php3-web-shopping>    
GIT/SSH:  `git@gitlab.com:GrozdanovEG/php3-web-shopping.git`      
**Branch**: *webshop*   


---
### Diary  
Feb 06, 2023: Final commit for this stage of the project;  
Jan 30, 2023: in progress;  
Jan 23, 2023: Functionality partially implemented, not ready to merge;   



