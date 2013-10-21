<?php
include $REX['INCLUDE_PATH'].'/layout/top.php';
$tree = array();
foreach (OOCategory::getRootCategories(false) as $categorie) {
	$tree[$categorie->getId()]['name'] = $categorie->getName();
	$tree[$categorie->getId()]['childs'] = addChildren($categorie);
}

$ignoreCategories = rex_post('ignoreCategories', "array", false);
if($ignoreCategories) {
	$sql = new rex_sql();
	$sql->debugsql = 0;
	$sql->setTable('rex_maru_cache');
	$sql->setWhere("`option`='ignoreCategories'");
	$sql->select("*");
	if($sql->getRow() != false) {
		$sql->reset();
		$sql->setTable('rex_maru_cache');
		$sql->setWhere("`option`='ignoreCategories'");
		$sql->setValue('value', implode("|", $ignoreCategories));
		$sql->update();
	} else {
		$sql->reset();
		$sql->setTable('rex_maru_cache');
		$sql->setValue('option', 'ignoreCategories');
		$sql->setValue('value', implode("|", $ignoreCategories));
		$sql->insert();
	}
} else {
	$sql = new rex_sql();
	$sql->debugsql = 0;
	$sql->setTable('rex_maru_cache');
	$sql->setWhere("`option`='ignoreCategories'");
	$sql->select("*");
	$ignoreCategories = explode("|", $sql->getValue("value"));
}


?>

<form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
<select name="ignoreCategories[]" multiple="multiple" size="50">
<?php
echo showMultipleSelectOptions($tree, $ignoreCategories);
?>
	</select>
	<input type="submit" value="Speichern" />

</form>
<?php
include $REX['INCLUDE_PATH'].'/layout/bottom.php';
function showMultipleSelectOptions($array, $selectedArray, $deep = 0, $out = "") {
	$spaces = '';
	for($i=0;$i<$deep;$i++) { $spaces .= '&nbsp;&nbsp;&nbsp;'; }
		$deep++;
	foreach ($array as $key => $value) {
		$selected = (in_array($key, $selectedArray))?' selected="selected"':'';
		$out .= '<option value="'.$key.'"'.$selected.'>'.$spaces.$value['name'].'</option>';

		if($value['childs'] !== null) {
			$out = showMultipleSelectOptions($value['childs'], $selectedArray, $deep, $out);
		}
	}
	return $out;
}
function addChildren($categorie)
{
	$childs = $categorie->getChildren();
	if (count($childs) !== 0) {
		$tree = array();
		foreach ($childs as $child) {
			$tree[$child->getId()]['name'] = $child->getName();
			$tree[$child->getId()]['childs'] = addChildren($child);
		}
		return $tree;
	} else {
		return Null;
	}
}
?>