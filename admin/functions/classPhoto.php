<?php

class Photo extends Db_table
{
    protected static $db_table = "photos";
    protected static $db_table_fields = array('photo_title', 'photo_description', 'photo_filename', 'photo_type', 'photo_size');
    protected static $db_table_fields_type = 'ssssi';
    protected static $db_id = 'photo_id ';

    // Valore creados acorde a las columnas de la tabla photos
    public $photo_id;
    public $photo_title;
    public $photo_description;
    public $photo_filename;
    public $photo_type;
    public $photo_size;
}
