<?php
namespace ExtractCompress;

use ExtractCompress\ExtractCompressType\ZipExtractCompress;

class ExtractCompress
{
    private $zipInstance = NULL;
    private $setting = NULL;

    //解压开始
    public function zipExtractTo($filePath, $setting = [])
    {
        $this->makeSetting($filePath, $setting, 1);
        if (empty($this->zipInstance))
            $this->zipInstance = new ZipExtractCompress();
        $result = $this->zipInstance->extractTo(
            $this->setting['filePath'],
            $this->setting['savePath'],
            $this->setting['openType']
        );
        return $result ? $this->setting['savePath'] : false;
    }

    //压缩结束
    public function zipCompress($filePath, $setting = [])
    {
        $this->makeSetting($filePath, $setting, 2);
        $this->setting['savePath'] .= '.zip';
        if (empty($this->zipInstance))
            $this->zipInstance = new ZipExtractCompress();
        $result = $this->zipInstance->compressTo(
            $this->setting['filePath'],
            $this->setting['savePath'],
            $this->setting['openType']
        );
        return $result ? $this->setting['savePath'] : false;
    }

    private function makeSetting($filePath, $setting, $type)
    {
        $configPath = __DIR__ . '/Config/ZipConfig.php';
        $config = is_file($filePath) ? include $configPath : [];
        $setting = array_merge($config, $setting);
        $this->setting['filePath'] = $setting['filePath'] = $filePath;
        !empty($setting['savePath']) or $setting['savePath'] = './';
        !empty($setting['openType']) or $setting['openType'] = \ZipArchive::CREATE;
        $setting['savePath'] .= $this->makePathName($setting['subName'], $type);
        if ($type == 2)
            $setting['savePath'] .= $this->makePathName($setting['saveName'], $type);
        $this->setting = $setting;
    }

    private function makePathName($type, $funcType)
    {
        $subString = DIRECTORY_SEPARATOR;
        if (empty($type) && $type !== 0 && $funcType == 1)
            return $subString;
        if (!empty($type)) {
            switch ($type) {
                case  'md5':
                    $subString .= md5(uniqid());
                    break;
                case 'uniqid':
                    $subString .= uniqid();
                    break;
                case 'date':
                    $subString .= date('Y-m-d His', time());
                    break;
                case 'auto':
                    $subString .= basename($this->setting['filePath'], '.' . substr(strrchr($this->setting['filePath'], '.'), 1));
                    break;
                default:
                    $subString .= md5(uniqid());
                    break;
            }
        }
        return $subString;
    }
}