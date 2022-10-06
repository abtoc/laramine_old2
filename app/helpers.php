<?php

use Illuminate\Support\HtmlString;
use League\CommonMark\GithubFlavoredMarkdownConverter;

if(!function_exists('route_query')) {
    /**
     * Generate the URL to a named route with query.
     *
     * @param  array|string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     */

    function route_query($name, $parameters = [], $absolute = true)
    {
        return route($name, array_merge($parameters, request()->query()), $absolute);
    }
 }

 if(!function_exists('to_route_query')) {
    /**
     * Create a new redirect response to a named route with query.
     *
     * @param  string  $route
     * @param  mixed  $parameters
     * @param  int  $status
     * @param  array  $headers
     * @return \Illuminate\Http\RedirectResponse
     */
    function to_route_query($route, $parameters = [], $status = 302, $headers = [])
    {
        return to_route($route, array_merge($parameters, request()->query()), $status, $headers);
    }
 }

if(!function_exists('markdown')) {
    /**
     * Converts GitHub flavored Markdown into HTML.
     *
     * @param  string  $string
     * @param  array  $options
     * @return \Illuminate\Support\HtmlString
     */
    function markdown($string, $options = []): HtmlString
    {
        $options = array_merge($options, [
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
        ]);
        $converter = new GithubFlavoredMarkdownConverter($options);
  
        return new HtmlString($converter->convert($string ?? ''));
    }
 }