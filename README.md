# Documentation

## Installation

---

`composer install`

`cp .env.example .env`

put your db settings into .env

`php artisan key:generate`

php artisan migrate`

## Upload csv data.

---

In this version the file is loaded from a static path (./storage/app/South_African_Mobile_Numbers.csv).



Run this artisan command `artisan phone-numbers:import`



This command use a LaravelExcel Import class, see [documentation](https://docs.laravel-excel.com/3.1/getting-started)

## API

For serve the application on the PHP development server, run this command `artisan serve` 

---

### Get all imported numbers

#### Request

`[GET] http://127.0.0.1:8000/api/phone-numbers`

#### Response

```json
[
    {
        "id": 1,
        "mobile": "6478342944",
        "status": "REJECTED",
        "status_description": null,
        "created_at": "2021-11-25T18:30:06.000000Z",
        "updated_at": "2021-11-25T18:30:06.000000Z"
    },
    {
        "id": 2,
        "mobile": "27718159078",
        "status": "IMPORTED",
        "status_description": null,
        "created_at": "2021-11-25T18:30:06.000000Z",
        "updated_at": "2021-11-25T18:30:06.000000Z"
    },
    {
        "id": 3,
        "mobile": "27730276061",
        "status": "CORRECTED_AND_IMPORTED",
        "status_description": "ADDED INTERNATIONAL PREFIX",
        "created_at": "2021-11-25T18:30:06.000000Z",
        "updated_at": "2021-11-25T18:30:06.000000Z"
    },
    ...
]
```

#### To filter the results use

You can filter based on these states: `imported` and `rejected`

`GET http://127.0.0.1:8000/api/people?filter={filter}`

## Get statistics

#### Request

`[GET] http://127.0.0.1:8000/api/phone-numbers/statistics`

#### Response

```json
{
    "imported": 1,
    "corrected": 1,
    "rejected": 1
}
```

## Test phone number

#### Request

`[GET] http://127.0.0.1:8000/api/phone-numbers/test{phone}`

#### Response

```json
{
    "phone": "INSERTED PHONE",
    "status": "[Phone Number is valid | Phone Number is invalid | The international prefix is missing, try with 27..."
}
```
