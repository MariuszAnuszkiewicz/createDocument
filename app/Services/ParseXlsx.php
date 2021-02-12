<?php

namespace App\Services;

use SimpleXLSX;

class ParseXlsx
{
    private $simpleXLSX;

    public function __construct(SimpleXLSX $simpleXLSX)
    {
        $this->simpleXLSX = $simpleXLSX;
    }

    public function loadFile($folder)
    {
        $dir = public_path() . "/$folder/";
        $file = null;
        if ($handle = opendir($dir)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    if (preg_match("/.xlsx$/i", $entry)) {
                        $file .= $entry;
                    }
                }
            }
            closedir($handle);
        }
        if (null !== $file) {
            return $sourceFile = $dir . $file;
        }
    }

    public function readFile($file)
    {
        $allowsExtensions = ['xlsx'];
        $extensions = implode('|', $allowsExtensions);
        if ($file !== null) {
            if (preg_match('/^.*\.(' . $extensions . ')$/i', $file)) {
                if ($xlsx = $this->simpleXLSX->parse($file)) {
                    foreach ($xlsx->rows() as $key => $value) {
                        $lengthRows = $key;
                        $arrHeaders['headers'][] = $value;
                        $arrRows[] = $value;
                    }
                    foreach ($arrHeaders['headers'][0] as $index => $value) {
                        if (preg_match('/^DPO_Filter/', $value)) {
                            $rows['rows'][] = substr(strstr($value, ':'), strlen(':'), strlen(strstr($value, ':')));
                        }
                        if (preg_match('/^DOK/', $value)) {
                            $rows['rows'][] = substr(strstr($value, 'DOK_'), strlen('DOK_'), strlen(strstr($value, 'DOK_')));
                        }
                        if (preg_match('/^VERSDOK/', $value)) {
                            $rows['rows'][] = substr(strstr($value, 'VERSDOK_'), strlen('VERSDOK_'), strlen(strstr($value, 'VERSDOK_')));
                        }
                    }
                    for ($i = 1; $i <= $lengthRows; $i++) {
                        for ($j = 0; $j < $index + 1; $j++) {
                            $values[$rows['rows'][$j]][] = explode(", ", $arrRows[$i][$j]);
                        }
                    }
                }
            } else {
                return response()->json(['message' => 'File extension is bad.']);
            }
            return $values;
        }
    }
}
