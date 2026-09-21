# Agent Guidance

## Project

- Laravel 12 application with Vite and Tailwind CSS.
- PHP sources use PSR-4 autoloading under `App\\`; views are Blade templates under `resources/views`.
- Public routes are loaded from `routes/web.php`; feature route files are included from there.

## Useful Checks

- `php artisan route:list`
- `php artisan test`
- `npm run build`

Run the narrowest relevant check after edits, then run the broader check when practical.

## Change Conventions

- Inspect the owning controller, model, route, and view before changing behavior.
- Keep route names stable when a Blade template or redirect may depend on them.
- Use existing Laravel controllers, middleware, validation, and views before adding abstractions.
- Do not commit generated assets, secrets, or environment files.
- Keep changes focused; do not rewrite unrelated code.

## Route Notes

- `routes/candidates.php` contains public candidate/project pages as well as candidate administration routes.
- `routes/projects.php` contains project administration and authenticated user project routes.
- Check route ordering when adding broad paths such as `/projects` or `/{slug}`.