<?php
namespace Service;

class Employ {
    
    /**
     * @param \Symfony\Component\HttpFoundation\File $file
     * @return boolean
     */
    public function saveCV($file) {
        if (is_null($file)) {
            return false;
        }
        
        if (strtolower($file->getExtension()) !== 'pdf') {
            return false;
        }
        
        $finfo = new \finfo(FILEINFO_MIME);
        if ($finfo->file($file) !== 'application/pdf; charset=binary') {
            return false;
        }
        
        $file->move(__DIR__ . '/../upload', $file->getClientOriginalName());
        
        return true;
    }
}