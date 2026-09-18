<?php

if (!function_exists('generateNumeric')) {
    function generateNumeric(int $length): string
    {
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= random_int(0, 9);
        }
        return $result;
    }
}



if (!function_exists('get_count_where')) {
    function get_count_where($model = null, $where = array())
    {
        $counter = $model::where($where)->count();
        return $counter;
    }
}


if (!function_exists('upload_image')) {
    function upload_image($folder, $image)
    {
        $extension = strtolower($image->extension());
        $filename = time() . rand(100, 999) . '.' . $extension;
        $image->getClientOrignalName = $filename;
        $image->move($folder, $filename);
        return $filename;
    }
}


/* get some cols for one row on table */
if (!function_exists('get_cols_where_row')) {
    function get_cols_where_row($model = null, $column_name = array(), $where = array())
    {
        $data = $model::select($column_name)->where($where)->first();
        return $data;
    }
}
