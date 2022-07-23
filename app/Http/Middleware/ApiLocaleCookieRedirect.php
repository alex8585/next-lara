<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use Mcamara\LaravelLocalization\LanguageNegotiator;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationMiddlewareBase;

class ApiLocaleCookieRedirect extends LaravelLocalizationMiddlewareBase
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If the URL of the request is in exceptions.
        if ($this->shouldIgnore($request)) {
            return $next($request);
        }

        $params = explode('/', $request->path());
        $locale = $request->cookie('locale', false);

        if (\count($params) > 0 && app('laravellocalization')->checkLocaleInSupportedLocales($params[2])) {
            return $next($request)->withCookie(cookie()->forever('locale', $params[2]));
        }

        if (empty($locale) && app('laravellocalization')->hideUrlAndAcceptHeader()) {

            // When default locale is hidden and accept language header is true,
            // then compute browser language when no session has been set.
            // Once the session has been set, there is no need
            // to negotiate language from browser again.
            $negotiator = new LanguageNegotiator(
                app('laravellocalization')->getDefaultLocale(),
                app('laravellocalization')->getSupportedLocales(),
                $request
            );
            $locale = $negotiator->negotiateLanguage();
            Cookie::queue(Cookie::forever('locale', $locale));
        }

        if ($locale === false) {
            $locale = app('laravellocalization')->getCurrentLocale();
        }

        if (
            $locale &&
            app('laravellocalization')->checkLocaleInSupportedLocales($locale) &&
            ! (app('laravellocalization')->isHiddenDefault($locale))
        ) {

            /* $redirection = app('laravellocalization')->getLocalizedURL($locale); */
            $prefix =$request->route()->getPrefix() ;
            $newPrefix = $prefix . '/' . $locale;
            $redirection =  str_replace($prefix, $newPrefix, $request->url());
            $redirection .= '?' . http_build_query($request->query());
            $redirectResponse = new RedirectResponse($redirection, 302, ['Vary' => 'Accept-Language']);

            return $redirectResponse->withCookie(cookie()->forever('locale', $locale));
        }

        return $next($request);
    }
}
