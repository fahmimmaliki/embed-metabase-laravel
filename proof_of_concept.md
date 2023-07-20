# Proof of Concept Document: Embedding Metabase Question in Laravel

## Introduction

This proof of concept (POC) document demonstrates how to embed a Metabase question into a Laravel web application. Metabase is an open-source business intelligence and data visualization tool, and embedding Metabase questions allows you to display dynamic reports and visualizations directly within your Laravel application.

## Prerequisites

Before proceeding with the POC, ensure you have the following in place:

1. Laravel 8 or later installed on your system.
2. Composer, a PHP package manager, installed.
3. Metabase installed and running, with the necessary questions set up.

## Step 1: Set Up Laravel Environment

In your Laravel project, navigate to the `app/Http/Controllers` directory and create a new controller named `MetabaseController.php`. This controller will handle generating the Metabase token and passing the iframe URL to the view.

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class MetabaseController extends Controller
{
    public function generateToken()
    {
        // Your Metabase configurations
        $METABASE_SITE_URL = env('METABASE_SITE_URL');
        $METABASE_SECRET_KEY = env('METABASE_SECRET_KEY');

        $questionId = 1; // Replace 1 with the actual question ID as an integer

        // Generate the Metabase token
        $config = Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText($METABASE_SECRET_KEY));

        $now = new \DateTimeImmutable();
        $exp = $now->modify('+10 minutes');

        $params = new \stdClass(); // Use an empty stdClass object

        $token = $config->builder()
            ->issuedBy($METABASE_SITE_URL)
            ->permittedFor($METABASE_SITE_URL)
            ->identifiedBy(bin2hex(random_bytes(16)))
            ->withClaim('resource', ['question' => $questionId]) // Use the actual question ID as an integer
            ->withClaim('params', $params) // Use the object instead of the array
            ->issuedAt($now)
            ->expiresAt($exp) // Use the DateTimeImmutable object for expiration
            ->getToken($config->signer(), $config->signingKey());

        $iframeUrl = $METABASE_SITE_URL . "/embed/question/" . $token->toString() . "#bordered=true&titled=true";

        // Pass the iframe URL to the 'metabase' view
        return view('metabase', compact('iframeUrl'));
    }
}
```

## Step 2: Set Up Laravel Routes

In the `routes/web.php` file, define the route that will trigger the `generateToken()` method in the `MetabaseController`. This route will be used to access the embedded Metabase question.

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MetabaseController;

// Route to generate the Metabase token and display the embedded question
Route::get('/', [MetabaseController::class, 'generateToken']);
```

## Step 3: Create the View for Embedding

In the `resources/views` directory, create a new Blade view named `metabase.blade.php`. This view will contain the HTML and JavaScript to display the embedded Metabase question using an iframe.

```html
<!DOCTYPE html>
<html>
<head>
    <title>Metabase Embed</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        iframe {
            width: 100%;
            height: 100vh;
            border: 0;
        }

        /* Adjust the iframe height for smaller screens */
        @media screen and (max-width: 768px) {
            iframe {
                height: 80vh;
            }
        }

        /* Adjust the iframe height for even smaller screens */
        @media screen and (max-width: 576px) {
            iframe {
                height: 60vh;
            }
        }
    </style>
</head>
<body>
    <!-- Embed the Metabase question using the generated iframe URL -->
    <iframe src="{{ $iframeUrl }}"></iframe>
</body>
</html>
```

## Step 4: Register the Metabase Service Provider

In the `app/Providers` directory, open the `AppServiceProvider.php` file. Inside the `register()` method, bind the Metabase configuration using the `bind()` method.

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Configuration::class, function () {
            // Your Metabase configurations
            $signer = new Sha256();
            $key = InMemory::base64Encoded(env('METABASE_SECRET_KEY'));

            return Configuration

::forSymmetricSigner($signer, $key);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
```

## Conclusion

This proof of concept demonstrates the process of embedding a Metabase question into a Laravel web application. By following the steps outlined above, you can now embed dynamic Metabase reports and visualizations directly within your Laravel project. Remember to set up Metabase and create the necessary questions before embedding them into your application. Additionally, consider handling Metabase authentication and security measures to ensure data protection and authorized access to the embedded content. Happy embedding!
