# takengo_api
Take n Go API

Created By
1. Franky Gabriel Sanjaya s3642810
2. Kendrick Kesley s3642811
3. Nadya Safira s3642868
4. Veronica Ong s3642807
5. Yulita Putri Hartoyo s3642813


## Query latitude and longitude on postgres

First, enable the extensions
```
CREATE EXTENSION cube;
CREATE EXTENSION earthdistance;
```
Query distance given 2 positions
```
SELECT earth_distance(ll_to_earth(-37.8230974, 144.9541606), ll_to_earth(lat, long)) from cars_locations;
```
Query records on a given radius
```
SELECT * FROM cars_locations WHERE earth_box(ll_to_earth(-37.8230974, 144.9541606), 10000) @> ll_to_earth(lat, long);
```
