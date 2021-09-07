<?php 
$jrows = [
	'pages' => $pages,
	'page' => $page,
	'count' => $count,
	'q' => $q,
	'roles' => array(),
	'groups' => array(),
	'rows' => array()
];

?>
@foreach($roles as $role)
<?php
	$jrows['roles'][] = $role;
?>
@endforeach
@foreach($groups as $group)
<?php
	$jrows['groups'][] = $group;
?>
@endforeach
@foreach($rows as $row)
<?php
	$jrows['rows'][] = $row;
?>
@endforeach
<?php
	echo json_encode($jrows);
?>
