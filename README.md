# Embedding Metabase Question in Laravel 10
![image](https://github.com/fahmimmaliki/embed-metabase-laravel/assets/49539975/a98d19b2-631a-45c9-af0b-92ba483b2d57)

This guide will help you quickly embed a Metabase question into your Laravel 10 application. Follow these simple steps to get started:

## Prerequisites

1. Make sure you have `composer` installed on your system.
2. Ensure you have Docker installed and running for easy use with Laravel Sail. (Alternative method without Docker is provided below)

## Steps

1. Clone the repository:

```bash
git clone https://github.com/fahmimmaliki/embed-metabase-laravel.git
```

2. Change directory to the repository:

```bash
cd embed-metabase-laravel
```

3. Install the required dependencies:

```bash
composer install
```

4. Copy the `.env.example` file to create the `.env` file:

```bash
cp .env.example .env
```

5. Update the `.env` file with your Metabase configurations:

```env
METABASE_SITE_URL=YOUR_METABASE_SITE_URL
METABASE_SECRET_KEY=YOUR_METABASE_SECRET_KEY
```

Replace `YOUR_METABASE_SITE_URL` and `YOUR_METABASE_SECRET_KEY` with your actual Metabase configurations.

6. Run the Laravel Sail containers: (Alternative method without Docker is provided below)

```bash
sail up
```

7. Open the `MetabaseController.php` file located in `app/Http/Controllers` and find the line with `$questionId = 1;`. Change the `1` to the ID of the Metabase question you want to embed.

8. Now your Laravel application is set up to embed the specified Metabase question. You can access it by navigating to:

```
http://localhost/
```

That's it! You should now see the embedded Metabase question in your Laravel application.

## Alternative Method (Without Docker)

If you're not using Docker, you can run your Laravel application using the built-in PHP development server. Navigate to your project directory and execute the following command:

```bash
php artisan serve
```

Your Laravel application will be accessible at `http://localhost:8000`.

## Code Related to Embedding

The code responsible for embedding the Metabase question can be found in the following files:

1. `MetabaseController.php` - Handles the generation of the Metabase token and passes the necessary data to the view for embedding.

2. `AppServiceProvider.php` - Registers the AppServiceProvider to make sure the Metabase secret key is available for the JWT token generation.

3. `metabase.blade.php` - The Blade view file responsible for displaying the embedded Metabase question using an iframe.

## Proof of Concept Document

For a detailed step-by-step guide on how to embed Metabase questions in Laravel using the provided code, please refer to the [Proof of Concept Document](./proof_of_concept.md).

## Conclusion

Congratulations! You have successfully integrated Metabase with your Laravel 10 application and embedded a specific Metabase question into your project. By following the straightforward steps outlined in this guide, you now have the power to visualize and analyze your data seamlessly within your Laravel application.

If you ever need to change the embedded Metabase question or add more features, you can easily do so by referring to the code and updating it as needed.

Remember to keep your Laravel and Metabase configurations up-to-date and maintain the security of your application.

Happy data analysis and visualization with Metabase and Laravel! Feel free to reach out if you have any questions or need further assistance. Happy coding!
