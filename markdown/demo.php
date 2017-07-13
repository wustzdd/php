<?php

spl_autoload_register(function($class){
	require preg_replace('{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
});

use \Michelf\Markdown;
use \Michelf\MarkdownExtra;

$text = "
> 这里是引用样式  [*click* ***here***](http://www.eyebuydirect.com){#id .class}   ![logo](https://res.ebdcdn.com/static/images/logo-normal.1441121331.png) 
# 一级标题
## 二级标题
### 三级标题 
#### 四级标题 
##### 五级标题 
###### 六级标题 
####无序列表
* 子列表1
* 子列表2
* 子列表3

####有序列表
1. 子列表1
2. 子列表2
3. 子列表3

 `public function marktest(){
        
    } `
    
";


$html = MarkdownExtra::defaultTransform($text);

echo $html;