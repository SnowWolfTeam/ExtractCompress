#文件解压缩

#### 异常：
* 异常错误码
```
    const FILE_NOT_EXIST = 0x1000;      //文件不存在
    const FILE_SUFFIX_ERROR = 0x1001;   //文件后缀不正确    
    const OPEN_FAILED = 0x1002;         //Zip打开方式错误
```
* 如何查看运行后的异常码和异常消息
```
    异常码: ExtractCompress::$exceptionCode 
    异常消息: ExtractCompress::$exceptionMsg 
```
* 支持的解压缩类型
```
1.Zip
```

* 配置文件
```
1.Zip配置文件 ZipConfig.php 内容为:
    $zipConfig['savePath'] = 'c://TangRuiHua';   //保存路径
    $zipConfig['saveName'] = 'md5';              //保存文件名以md5形式命名,还有uniqid，date,auto(以文件名命名)，默认是md5
    $zipConfig['subName'] = 'md5';                  //保存子文件夹名以md5形式命名,还有uniqid，date,auto(以文件名命名),''(表示不需要子文件夹名)，默认是md5   
    $zipConfig['openType'] = ZipArchive::CREATE; //zip扩展文件打开方式
```
###### 接口
####### Zip接口
* 1 . zipExtractTo($filePath,$setting = []) 解压文件
```
    $filePath = 需要解压的Zip文件路径
    $setting = 可选，解压需要的参数，参考配置文件，不输入则使用配置文件参数
    例子: $test->zipExtractTo(
            '/usr/test.zip',
            [
                'savePath' => 'c://TangRuiHua',
                'saveName' => 'md5',
                'subName' => 'md5',
                'openType' => ZipArchive::CREATE
             ],
    );
```
* 2 . zipCompress($filePath,$setting = [])  压缩文件
```
    $filePath = 需要压缩的文件或文件夹路径
    $setting = 可选，解压需要的参数，参考配置文件，不输入则使用配置文件参数
    例子: $test->zipExtractTo(
            '/usr/test',
            [
                'savePath' => 'c://TangRuiHua',
                'saveName' => 'md5',
                'subName' => 'md5',
                'openType' => ZipArchive::CREATE
             ],
    );
```
    