<?php

if(!function_exists('array_move')) {
    /**
     * Move array items.
     *
     * @param  array $array
     * @param  integer $old
     * @param  integer $new
     * @return array
     */
    function array_move(array &$array, int $old, int $new): array
    {
        if($old === $new)   return $array;

        $item = $array[$old];
        array_splice($array, $old, 1);
        array_splice($array, $new, 0, $item);

        return $array;
    }
}
