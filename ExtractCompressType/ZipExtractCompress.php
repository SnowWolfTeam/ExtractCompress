<?php
namespace ExtractCompress\ExtractCompressType;

use ExtractCompress\Exception\ZipException;

class ZipExtractCompress
{
    private static $errType = [
        \ZipArchive::ER_EXISTS => "已经存在",
        \ZipArchive::ER_INCONS => "压缩文件不一致",
        \ZipArchive::ER_INVAL => "无效的参数",
        \ZipArchive::ER_MEMORY => "内存错误",
        \ZipArchive::ER_NOENT => "没有这样的文件",
        \ZipArchive::ER_NOZIP => "没有一个压缩文件",
        \ZipArchive::ER_OPEN => "不能打开文件",
        \ZipArchive::ER_READ => "读取错误",
        \ZipArchive::ER_SEEK => "查找错误"
    ];

    /**
     * 解压
     * @param $zipfilePath
     * @param $savePath
     * @param $openType
     * @return bool
     * @throws ZipException
     */
    public function extractTo($zipfilePath, $savePath, $openType)
    {
        $result = false;
        if (!is_file($zipfilePath))
            throw new ZipException('Zip文件不存在', ZipException::FILE_NOT_EXIST);
        $fileType = end(explode('.', $zipfilePath));
        if (empty($fileType) || $fileType != 'zip')
            throw new ZipException('文件后缀不正确', ZipException::FILE_SUFFIX_ERROR);
        else {
            $zip = new \ZipArchive();
            $res = $zip->open($zipfilePath, $openType);
            if (!empty(self::$errType[$res]))
                throw new ZipException(self::$errType[$res], ZipException::OPEN_FAILED);
            else if ($res === true) {
                $zip->extractTo($savePath);
                $zip->close();
                $result = true;
            }
        }
        return $result;
    }

    /**
     * 压缩
     * @param $filePath
     * @param $savePath
     * @param $openType
     * @return bool
     * @throws ZipException
     */
    public function compressTo($filePath, $savePath, $openType)
    {
        $result = false;
        if (!is_file($filePath) && !is_dir($filePath))
            throw new ZipException('要压缩的文件不存在', ZipException::FILE_NOT_EXIST);
        $fileType = end(explode('.', $savePath));
        if (empty($fileType) || $fileType != 'zip')
            throw new ZipException('保存路径后缀不正确', ZipException::FILE_SUFFIX_ERROR);
        else {
            $zip = new \ZipArchive();
            $dir = dirname($savePath);
            if (!is_dir($dir))
                mkdir($dir, 0775, true);
            $res = $zip->open($savePath, $openType);
            if (!$res && !empty(self::$errType[$res]))
                throw new ZipException(self::$errType[$res], ZipException::OPEN_FAILED);
            if (is_file($filePath))
                $result = $this->fileAdd($zip, $filePath);
            else if (is_dir($filePath))
                $result = $this->dirAdd($zip, $filePath);
        }
        return $result;
    }

    private function fileAdd(&$zip, $filePath)
    {
        if (DIRECTORY_SEPARATOR === '\\')
            $addFileResult = $zip->addFromString($filePath, file_get_contents(iconv('utf-8', 'gbk//ignore', $filePath)));
        else
            $addFileResult = $zip->addFromString($filePath, file_get_contents($filePath));
        $addFileResult = $zip->addFromString($filePath);
        $zip->close();
        return $addFileResult;
    }

    private function dirAdd(&$zip, $filePath)
    {
        $handle = opendir($filePath);
        $result = true;
        while (($file = readdir($handle)) !== false) {
            if ($file != '.' && $file != '..') {
                $cur_path = $filePath . DIRECTORY_SEPARATOR . $file;
                if (is_dir($cur_path)) {
                    $this->dirAdd($zip, $cur_path);
                } else {
                    if (DIRECTORY_SEPARATOR === '\\')
                        $zip->addFromString($cur_path, file_get_contents(iconv('utf-8', 'gbk//ignore', $cur_path)));
                    else
                        $zip->addFromString($cur_path, file_get_contents($cur_path));
                }
            }
        }
        closedir($handle);
        $zip->close;
        return true;
    }
}