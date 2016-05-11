# Laravel Safe Routes
Adds an option to generate route URLs which are safe and seo friendly.

### Installation
Run `composer require jaybizzle/laravel-safe-routes`

Add `Jaybizzle\SafeRoutes\SafeRoutesServiceProvider::class,` to `config/app.php`


### Usage
`URL::saferoute('blog.article', [$blog->id, $blog->title])
