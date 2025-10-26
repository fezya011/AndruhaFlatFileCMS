<?php

namespace App\Services;

class FileUploader
{
    public function handleUpload($file)
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'Ошибка загрузки файла: ' . $file['error']];
        }
        
        if ($file['size'] > MAX_FILE_SIZE) {
            return ['success' => false, 'error' => 'Файл слишком большой. Максимальный размер: 5MB'];
        }
        
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, ALLOWED_FILE_TYPES)) {
            return ['success' => false, 'error' => 'Недопустимый тип файла. Разрешены: JPG, PNG, GIF, PDF, DOC, DOCX'];
        }
        
        if (!is_dir(UPLOAD_PATH)) {
            mkdir(UPLOAD_PATH, 0755, true);
        }
        
        $filename = uniqid() . '_' . $this->sanitizeFileName($file['name']);
        $destination = UPLOAD_PATH . '/' . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return ['success' => true, 'filename' => $filename];
        }
        
        return ['success' => false, 'error' => 'Не удалось сохранить файл'];
    }
    
    private function sanitizeFileName($filename)
    {
        $filename = preg_replace('/[^a-zA-Z0-9\._-]/', '_', $filename);
        return substr($filename, 0, 100);
    }
}