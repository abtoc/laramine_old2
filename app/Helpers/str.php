<?php

use Illuminate\Support\HtmlString;
use League\CommonMark\GithubFlavoredMarkdownConverter;

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