<?php
$zipConfig['savePath'] = 'C://TangRuiHua';          //保存路径
$zipConfig['saveName'] = 'auto';                    //保存文件名以md5形式命名
$zipConfig['subName'] = 'auto';                    //保存文件名以md5形式命名
$zipConfig['openType'] = ZipArchive::CREATE;        //ZipArchive::CREATE;ZipArchive::OVERWRITE 打开zip文件以ZIPArchive::OVERWRITE 方式
return $zipConfig;