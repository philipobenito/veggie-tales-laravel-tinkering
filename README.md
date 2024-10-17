Hello there,

I tried to limit myself to 2 hours to complete this, a chunk of which was reminging myself of Laravel features, so had to make some decisions based purely on getting the point across.

## Things I did
- After initial migration creation, normalised the `classification` relationship as an example of how I would approach that.
- Created a custom error handler to properly manage exception repsonses.
- Full end to end class hierarchy for two endpoints, the vegetables, and the classifications.
- Added reudimentary filtering and sorting.
- Added optional and mandatory relationship inclusion using the `with=blah,blah` format. Obviously only one relationship here but it acts differently based on the type of request.
    - For example we probably wouldn't want to include every vegetable for every classification in the GET ALL method of that endpoint.
- Example Feature and Unit tests, didn't attempt for full code coverage, just a good set of examples.

## Things I didn't do
- Would have liked an example auth system, even if it was a basic auth middleware with rate limiting but became out of scope with my rough time limit.
- Would have liked to dig a little further in to the internals of Eloquent, as I think some of my abstraction probably would make more sense as custom query builders or within models.
- Would have liked to have built a more robust response handler, but a lot of response logic is built in to Laravel so might have been a waste of time anyway.

Time limitations are obviously a factor but hopefully this displays my understanding around REST in particular.

1. Initial setup...

```
git clone git@github.com:philipobenito/veggie-tales-laravel-tinkering.git
cd veggie-tales-laravel-tinkering
composer install
cp .env.example .env
```

2. Optionally update the `.env` file, specifically for database requirements or host if your system is not setup to serve on localhost.

3. Generate an app key

```
artisan key:generate
```

4. Build the database container

```
docker compose up --build -d
```

5. Migrate and seed

```
artisan migrate --seed
```

6. Serve the app

```
artisan serve
```

There are full REST resource endpoints for all HTTP request methods on:
```
GET|HEAD        /api/vegetable-classifications vegetable-classifications.index › VegetableClassificationControl…
POST            /api/vegetable-classifications vegetable-classifications.store › VegetableClassificationControl…
GET|HEAD        /api/vegetable-classifications/{vegetable_classification} vegetable-classifications.show › Vege…
PUT|PATCH       /api/vegetable-classifications/{vegetable_classification} vegetable-classifications.update › Ve…
DELETE          /api/vegetable-classifications/{vegetable_classification} vegetable-classifications.destroy › V…
GET|HEAD        /api/vegetables ................................... vegetables.index › VegetableController@index
POST            /api/vegetables ................................... vegetables.store › VegetableController@store
GET|HEAD        /api/vegetables/{vegetable} ......................... vegetables.show › VegetableController@show
PUT|PATCH       /api/vegetables/{vegetable} ..................... vegetables.update › VegetableController@update
DELETE          /api/vegetables/{vegetable} ................... vegetables.destroy › VegetableController@destroy
```
