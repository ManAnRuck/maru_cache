<?php
$mypage = 'maru_cache';
$mypageName = 'Cache';

$REX['ADDON']['rxid'][$mypage] = '68413546';

$REX['ADDON']['page'][$mypage] = $mypage;

$I18N_events = new i18n($REX['LANG'], $REX['INCLUDE_PATH'].'/addons/'.$mypage.'/lang/');

$REX['ADDON']['name'][$mypage] = $mypageName;

$REX['ADDON']['perm'][$mypage] = $mypage.'[]';
$REX['PERM'][] = $mypage.'[]';

$REX['ADDON']['version'][$mypage] = "0.5";
$REX['ADDON']['author'][$mypage] = "Manuel Ruck";

$REX['ADDON']['dbpref'][$mypage] = $REX['TABLE_PREFIX'].$REX['ADDON']['rxid'][$mypage].'_';



require $REX['INCLUDE_PATH'].'/addons/'.$mypage.'/functions/functions.php';

if(!$REX['REDAXO']) {
	rex_register_extension('OUTPUT_FILTER','maruCacheCreateHtml');
	rex_register_extension('ART_INIT','maruCacheLoadHtml');
} else {
	rex_register_extension('ART_UPDATED','maruCacheDeleteHtmlOfUpdatedArticle');
	rex_register_extension('ART_ADDED','maruCacheDeleteHtmlOfUpdatedArticle');
	rex_register_extension('ART_DELETED','maruCacheDeleteHtmlOfUpdatedArticle');
	rex_register_extension('CLANG_ADDED','maruCacheDeleteHtmlOfUpdatedArticle');
	rex_register_extension('CLANG_UPDATED','maruCacheDeleteHtmlOfUpdatedArticle');
	rex_register_extension('CLANG_DELETED','maruCacheDeleteHtmlOfUpdatedArticle');
	rex_register_extension('CAT_UPDATED','maruCacheDeleteHtmlOfUpdatedArticle');
	rex_register_extension('CAT_ADDED','maruCacheDeleteHtmlOfUpdatedArticle');
	rex_register_extension('CAT_DELETED','maruCacheDeleteHtmlOfUpdatedArticle');
	rex_register_extension('ART_CONTENT_UPDATED','maruCacheDeleteHtmlOfUpdatedArticle');
	rex_register_extension('ART_META_UPDATED','maruCacheDeleteHtmlOfUpdatedArticle');
}
?>