<?php

class Photo extends DbTable
{
    protected static $db_table = "photos";
    protected static $db_table_fields = array('photo_title', 'photo_description', 'photo_filename', 'photo_type', 'photo_size');
    protected static $db_table_fields_type = 'ssssi';
    protected static $db_id = 'photo_id ';

    // Valore creados acorde a las columnas de la tabla photos
    protected $photo_id;
    protected $photo_title;
    protected $photo_description;
    protected $photo_filename;
    protected $photo_type;
    protected $photo_size;

    protected $tmp_path;
    protected $upload_directory = "images";
    protected $errors = array();

    protected $upload_errors_array = array(
        UPLOAD_ERR_OK           => "There is no error",
        UPLOAD_ERR_INI_SIZE        => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
        UPLOAD_ERR_FORM_SIZE    => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
        UPLOAD_ERR_PARTIAL      => "The uploaded file was only partially uploaded.",
        UPLOAD_ERR_NO_FILE      => "No file was uploaded.",
        UPLOAD_ERR_NO_TMP_DIR   => "Missing a temporary folder.",
        UPLOAD_ERR_CANT_WRITE   => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION    => "A PHP extension stopped the file upload."
    );

    public function set_file($file)
    {
        if (empty($file) || !$file || !is_array($file)) {
            $this->errors[] = "There was no file uploaded here";
            return false;
        } elseif ($file['error'] !== 0) {
            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;
        } else {
            $this->photo_filename = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->photo_type = $file['type'];
            $this->photo_size = $file['size'];
        }
    }

    public function save()
    {
        if ($this->photo_id) {
            $this->update();
        } else {
            if (!empty($this->errors)) {
                return false;
            } elseif (empty($this->photo_filename) || empty($this->tmp_path)) {
                $this->errors[] = "The file was no available";
                return false;
            }

            $target_path = INCLUDES_PATH . "/admin/{$this->upload_directory}";

            if (file_exists($target_path)) {
                $this->errors[] = "The file {$this->photo_filename} already exists";
                return false;
            }

            if (move_uploaded_file($this->tmp_path, $target_path)) {
                if ($this->create()) {
                    unset($this->tmp_path);
                    return true;
                }
            } else {
                $this->errors[] = "The file directory does not have permission";
                return false;
            }
        }
    }
}
