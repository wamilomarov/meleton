

# First task:

The following are tables I used for this task:

###books
Storing book names and authors

id | name | author |
--- | --- | --- |
1 | Romeo and Juliet | William Shakespeare |
2 | War and Peace | Leo Tolstoy |
3 | Little Prince | Antoine de Saint-Exupery |
4 | Second book | William Shakespeare |
5 | Some another book | William Shakespeare |
6 | Lorem book | Leo Tolstoy |

###users
Storing user's name and age

id | first_name | last_name | age
--- | --- | --- | ---
1 | Ivan | Ivanov | 18
2 | Marina | Ivanova | 14
3 | Shamil | Omarov | 12
4 | Eva | Adams | 5

###user_books
Storing books taken by users

id | user_id | book_id
--- | --- | ---
1 | 1 | 1 
2 | 1 | 3
3 | 2 | 2
4 | 3 | 3
5 | 4 | 1
6 | 4 | 2
7 | 1 | 4
8 | 2 | 6
9 | 3 | 4
10 | 3 | 5

Query to fetch users aged between 7 and 17 who has taken only 2 books having same authors:

`SELECT u.id, u.first_name, u.last_name, b.author, group_concat(b.name) AS books
FROM meleton.user_books AS ub
INNER JOIN meleton.books AS b ON ub.book_id = b.id
INNER JOIN meleton.users AS u ON ub.user_id = u.id
WHERE u.age BETWEEN 7 AND 17
GROUP BY ub.user_id, b.author
HAVING count(ub.book_id) = 2;`

###Results of query:

id | first_name | last_name | author | books
--- | --- | --- | --- | ---
2 | Marina | Ivanova | Leo Tolstoy | Lorem book, War and Peace
3 | Shamil | Omarov | William Shakespeare | Some another book,Second book

# Second task:

To run the project:
  - Configure .env file based on .env.example
  - run `composer install`
  - run `php artisan migrate`
  - run `php artisan db:seed --class=RateSeeder`
  - run `php artisan serve`

Firs of all I created a table with the following fields:
 - id
 - currency
 - buy
 - sell

These are storing each currency with its buy and sell rates. I made a seeder (RateSeeder) to feed the database. Here I added BTC currency hardcoded, as it will be used to convert as an instance.

Authentication is done my Laravel default Auth middleware, I just overwrote the handle method of it, to check the specified api token as it was mentioned in the task description.

I made a custom validation exception to provide error response body in the format given in the task (CustomValidationException). It is actually used also as auth failure exception, so it may be renamed to smth general.

Rate service has its methods to get/filter/sort rates, get a single rate and convert between two rate instances. The last one is because I added BTC record manually, I designed it to convert between two instances.
The service is instantiated in the constructor of the RatesController. It may be instantiated in base Controller to use everywhere in controllers, I did it because for now I have only one controller and no need to create it everywhere.

In routing, I made 2 groups:
 - With prefix V1 which is for versioning the api.
 - With auth:api middleware, to group together the auth routes of V1 group.

Each rate has two appending attributes: calculated_buy and calculated_sell which are calculated based on according columns. These are to apply 2% commission fee. In conversion, I use the value that has been applied commission fee. This way I calculate the rate and store it in conversion_logs table. This one is created for the column `created_at` in response.


## Testing and Documentation

The application was run and tested manually in local development environment. I have documented the endpoints and responses using Postman. The collection from postman is shared in the following [link](https://documenter.getpostman.com/view/1052304/TWDRremd).




