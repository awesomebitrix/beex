<?php
class beFilesystem {

    public function findPathsByPatternInDirRecursivly($dirPath, $pattern, $filterDirPaths = null) {

        if (!$dirPath) throw new Exception("dirPath is not specified");

        if (!$filterDirPaths) $filterDirPaths = array();
        if (!is_array($filterDirPaths)) $filterDirPaths = array($filterDirPaths);

        $dirPath = self::normalizePath($dirPath);

        $paths = ($dirPath && $pattern)? glob($dirPath.'/'.$pattern) : array();
        if (!$paths) $paths = array();

        foreach(glob($dirPath.'/*', GLOB_ONLYDIR) as $path) {
            if (!in_array(pathinfo($path, PATHINFO_BASENAME), $filterDirPaths)) {
                $paths = array_merge(
                        $paths,
                        self::findPathsByPatternInDirRecursivly($path, $pattern)
                );
            }
        }

        return $paths;
    }

    public function delete($path) {
        if (is_link($path) || is_file($path)) self::removeFile($path);
        elseif (is_dir($path)) self::removeDirRecursivly($path);
    }

    public function clearDir($path) {
        if ($path) {
            $path = self::normalizePath($path);
            $files = glob($path.'/*');
            foreach($files as $file) self::delete($file);
        }
    }

    public function removeDirRecursivly($path) {
        if ($path) {
            $path = self::normalizePath($path);
            $files = glob($path.'/*');
            foreach($files as $file) self::delete($file);
            self::removeDir($path);
        }
    }

    public function removeFile($path) {
//        var_dump('Удаление файла '.$path);
        if ($path) unlink($path);
    }

    public function removeDir($path) {
//        var_dump('Удаление директории '.$path);
        if ($path) rmdir($path);
    }

    public function normalizePath($path) {
        $path =  rtrim($path, '/');
        return $path;
    }

}

?>
