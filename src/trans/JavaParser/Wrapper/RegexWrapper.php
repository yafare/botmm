<?php


namespace trans\JavaCompiler\Wrapper;


use Spatie\Regex\Regex;

class RegexWrapper
{

    /**
     * @param $pattern
     * @param $subject
     * @return \Spatie\Regex\MatchResult
     */
    public static function match($pattern, $subject)
    {
        return Regex::match($pattern, $subject);
    }

    public static function matchAll($pattern, $subject) {
        return Regex::matchAll($pattern, $subject);
    }
    
    public static function replace($pattern, $replacement, $subject, $limit = -1) {
        return Regex::replace($pattern, $replacement, $subject, $limit);
    }

}