<?php

function maruCacheCreateHtml($params) {
    global $REX;
    $indexHtmlPath = $REX['HTDOCS_PATH'] . "index.html";
    $artId = $REX['ARTICLE_ID'];
    $sql = new rex_sql();
    $sql->debugsql = 0;
    $sql->setTable('rex_maru_cache');
    $sql->setWhere("`option`='ignoreCategories'");
    $sql->select("*");
    $ignoreCategories = array();
    if ($sql->getRow()) {
        $ignoreCategories = explode("|", $sql->getValue("value"));
    }
    if (!in_array($artId, $ignoreCategories)) {
        if (empty($_POST) && rex_request("nocache", "string", false) != "bitte") {
            $clang = $REX['CUR_CLANG'];
            $cachePath = $REX['INCLUDE_PATH'] . "/generated/articles/";
            $urlQuery = preg_replace('/([^0-9a-zA-Z-])/', "", $_SERVER['QUERY_STRING']);
            $urlQuery .= "-" . md5($_SERVER['REQUEST_URI']);
            $cacheFile = "html-" . $artId . "-" . $clang . "-" . $urlQuery . ".html";
            if (!file_exists($cachePath . $cacheFile)) {
                $html = $params['subject'];
                file_put_contents($cachePath . $cacheFile, $html);
                if ($artId == $REX['START_ARTICLE_ID'] && $clang == 0) {
                    file_put_contents($indexHtmlPath, $html);
                }
            }
        }
    }
    return $params['subject'];
}

function maruCacheLoadHtml() {
    global $REX;
    $artId = $REX['ARTICLE_ID'];
    $sql = new rex_sql();
    $sql->debugsql = 0;
    $sql->setTable('rex_maru_cache');
    $sql->setWhere("`option`='ignoreCategories'");
    $sql->select("*");
    $ignoreCategories = array();
    if ($sql->getRow()) {
        $ignoreCategories = explode("|", $sql->getValue("value"));
    }
    if (!in_array($artId, $ignoreCategories)) {
        if (empty($_POST) && rex_request("nocache", "string", false) != "bitte") {
            $clang = $REX['CUR_CLANG'];
            $cachePath = $REX['INCLUDE_PATH'] . "/generated/articles/";
            $urlQuery = preg_replace('/([^0-9a-zA-Z-])/', "", $_SERVER['QUERY_STRING']);
            $urlQuery .= "-" . md5($_SERVER['REQUEST_URI']);
            $cacheFile = "html-" . $artId . "-" . $clang . "-" . $urlQuery . ".html";
            if (file_exists($cachePath . $cacheFile)) {
                if ((filemtime($cachePath . $cacheFile) + 86400) < time()) {
                    unlink($cachePath . $cacheFile);
                } else {
                    echo file_get_contents($cachePath . $cacheFile);
                    die();
                }
            }
        }
    }
}

function maruCacheDeleteHtmlOfUpdatedArticle($params) {
    global $REX;
    $cachePath = $REX['INCLUDE_PATH'] . "/generated/articles/";
    $cacheFiles = glob($cachePath . "*.html");
    foreach ($cacheFiles as $cacheFile) {
        unlink($cacheFile);
    }
    $indexHtmlPath = $REX['HTDOCS_PATH'] . "index.html";
    if (file_exists($indexHtmlPath)) {
        unlink($indexHtmlPath);
    }
}

?>
