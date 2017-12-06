# nitflux
Nitflux is a website inspired by IMDb allowing users to create reviews for movies and tv shows produced by Netflix.

Made by Alexander Behnan, Sarah Greenidge, Evan Roach
Our repo: https://github.com/abehnan/nitflux

The 'graveyard' folder contains the tools and information gathered and processed to make the database:
    ImageLinks is the html of a large div in https://www.netflix.com/ca/originals.
    This is the first thing to update in order to update the database.
    order: ImageLinks --> parser.py --> jsonEntries.txt --> moreInfo.py --> allInfo.json
    allInfo.json is what is used to populate the SQL database with php functions,
    populateActorTable and populateGenreTable seen in index.php.

To run:
  Requires the SLIM framework's vendor folder in htdocs/nitflux/
  Start XAMPP's MySQL and Apache modules.
  Open phpMyAdmin, create new database named nitflux. Import nitflux.sql
  Go to localhost/nitflux
