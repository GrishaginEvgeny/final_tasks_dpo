<?php
//функция очищает входящий файл от комментов
function removeComments($file_content){
    while (str_contains($file_content, "/*") && str_contains($file_content, "*/")) {
        $begin_of_file = strpos($file_content, "/*");
        $end_of_file = strpos($file_content, "*/");
        $file_content = substr_replace($file_content, "", $begin_of_file, $end_of_file - $begin_of_file + 2);
    }
    return $file_content;
}

function divideHeaderAndContent($tag){
    // делим стиль на заголовок и содержание
    $header = explode('{', $tag)[0];
    $header = str_replace(", ", ",", $header);
    $header = trim ($header, " ");
    $header = str_replace("\n", "", $header);

    $content = explode('{', $tag)[1];
    $content = str_replace("\n", "", $content);
    $content = str_replace(" ", "", $content);
    $content = explode(";", $content);
    $divided_content=[];
    foreach ($content as $value){
        $divided_content[explode(":", $value)[0]] = explode(":", $value)[1];
    }

    $result = [];
    if ($content == "}") {
        return null;
    }
    $result["header"] = $header;
    $result["content"] = $divided_content;
    return $result;
}

function marginOrPaddingNormalize($content){
   $replacement = "";
    if((array_key_exists('margin-top',$content) && array_key_exists('margin-bottom',$content)) ||
        (array_key_exists('padding-top',$content) && array_key_exists('padding-bottom',$content)))
    {
        if(array_key_exists('padding-top',$content)){
            if(array_key_exists('padding-top',$content) && array_key_exists('padding-bottom',$content)
                && array_key_exists('padding-left',$content) && array_key_exists('padding-right',$content))
            {
                if($content['padding-top'] == $content['padding-bottom']
                    && $content['padding-top'] == $content['padding-left'] && $content['padding-top'] == $content['padding-right'])
                {
                    $replacement = "padding:" . $content['padding-top'] . " px;";
                }
                elseif($content['padding-left'] == $content['padding-right'])
                {
                    $replacement = "padding:" . $content['padding-top'] . "px " . $content['padding-left'] . "px " . $content['padding-bottom'] . "px;";
                }
                else {
                    $replacement = "padding:" . $content['padding-top'] . "px " . $content['padding-right'] . "px " . $content['padding-bottom'] .
                        "px " . $content['padding-left'] . "px;";
                }
            }
        }
        else
        {

        }
    }
}

function getMyAnswer($file_path)
{
    $fileContent = file_get_contents("test\\".$file_path, FILE_IGNORE_NEW_LINES);
    $fileContent = removeComments($fileContent);
    $regex = '/((,|\s|[a-z0-9])+|#(.)*|\.([^,>{])*((,|>)*([^{])*))\{([^{}])*\}/';
    preg_match_all($regex, $fileContent, $matches);
    $tags = $matches[0];
    $fileContent = removeComments($fileContent);
    foreach ($tags as $tag){
        $divided_tag = divideHeaderAndContent($tag);
        if(!$divided_tag) continue;
        marginOrPaddingNormalize($divided_tag['content']);
    }
}

getMyAnswer("001.dat");

