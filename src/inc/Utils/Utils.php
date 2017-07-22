<?php

namespace SeanJohn\Utils;

use SeanJohn\Utils\TemplateLoader as Loader;

class Utils
{

    public static function data2file($file, $data, $format = 'json') {
      $finalData;
      self::ensurePath(dirname($file));
      switch($format) {
        case 'php':
          $finalData = "<?php \n\n\t".var_export($data, true)."; \n\n ?>";
        break;
        case 'json':
        default:
          $finalData = json_encode($data, JSON_PRETTY_PRINT);
        break;
        // case 'xml':
        // break;
      }
      file_put_contents($file, $finalData);
    }

    public static function ensurePath($path) {
      if (!is_dir($path)) {
        mkdir($path, 0777, true);
      }
      return (is_dir($path) ? $path : false);
    }

    public static function truepath($path){
      // whether $path is unix or not
      $unipath=strlen($path)==0 || $path{0}!='/';
      // attempts to detect if path is relative in which case, add cwd
      if(strpos($path,':')===false && $unipath)
          $path=getcwd().DS.$path;
      // resolve path parts (single dot, double dot and double delimiters)
      $path = str_replace(array('/', '\\'), DS, $path);
      $parts = array_filter(explode(DS, $path), 'strlen');
      $absolutes = array();
      foreach ($parts as $part) {
          if ('.'  == $part) continue;
          if ('..' == $part) {
              array_pop($absolutes);
          } else {
              $absolutes[] = $part;
          }
      }
      $path=implode(DS, $absolutes);
      // resolve any symlinks
      if(file_exists($path) && linkinfo($path)>0)$path=readlink($path);
      // put initial separator that could have been lost
      $path=!$unipath ? '/'.$path : $path;
      return $path;
  }

    public static function recursive_include($type = 'include', $dir, $opts = array())
    {
        $def_opts = array(
            'max_depth' => 5,
            'dir_excludes' => array(),
            'file_excludes' => array(),
            'extensions' => array('php'),
        );

        self::recursive_iteration($type, $dir, array_merge($def_opts, (is_array($opts) ? $opts : array())), 0);
    }

    private static function recursive_iteration($type = 'include', $dir, $opts = array(), $depth)
    {
        if ($depth > $opts['max_depth']) {
            return;
        }

        if (is_dir($dir)) {
            // get all files in directory
            $scan = glob($dir.DS.'*');

            foreach ($scan as $path) {
                if (is_dir($path)) {
                    // if the path is a directory and it's not in the dir_excludes list, dig into the folder and repeat the process.
                    if (!in_array($path, $opts['dir_excludes']) && !in_array(basename($path), $opts['dir_excludes'])) {
                        self::recursive_iteration($type, $path, $opts, $depth + 1);
                    }
                } elseif (is_file($path)) {
                    // Get the extention from the filename.
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $fullname = basename($path);
                    $filebase = str_replace(".$ext", '', $fullname);

                    // If 'match_dirname' is true, only include the file if the filename has the same name as the folder that contains it.
                    // Else keep digging through and only check if filenames don't match the excludes and that extensions match the includes.
                    if (!in_array($path, $opts['file_excludes']) &&
                        !in_array($fullname, $opts['file_excludes']) &&
                        !in_array($filebase, $opts['file_excludes'])) {
                        if (in_array($ext, $opts['extensions'])) {
                            switch ($type) {
                                case 'include':
                                    include $path;
                                break;
                                case 'include_once':
                                    include_once $path;
                                break;
                                case 'require':
                                    require $path;
                                break;
                                case 'require_once':
                                    require_once $path;
                                break;
                            }
                        }
                    }
                }
            }
        }
    }

    public static function ensureArray($subject)
    {
        return is_array($subject) ? $subject : array();
    }

    public static function isAssoc($arr)
    {
        return array_keys(self::ensureArray($arr)) !== range(0, count($arr) - 1);
    }

    public static function array_flatten($array) { 
      if (!is_array($array)) { 
        return false; 
      } 
      $result = array(); 
      foreach ($array as $key => $value) { 
        if (is_array($value)) { 
          $result = array_merge($result, self::array_flatten($value)); 
        } else { 
          $result[$key] = $value; 
        } 
      } 
      return $result; 
    }
}
