# Tokens

This package provides token generation and a middleware to validate incoming requests.

## Token generation

Generate a token by running the Artisan command:

```bash
php artisan generate-token
```

The command will output (or store, depending on the package configuration) the token required to authorize requests.

## Middleware usage

The package includes a middleware that validates the presence and validity of the token. Registered under `KeyGen.ValidateToken`, it can be used as follows:
```php
Route::middleware(['KeyGen.ValidateToken'])->group(function () {
    Route::get('/endpoint', function () {
        //  Only accessible to requests with a valid token
    });
});
```