
<table>
<?php 
	if ($users) {
		foreach ($users as $user) {
			if ($user->id != $currentUser->id) {
?>		
			<tr>
			<td> 
			<?php anchor("arcade/invite?login=" . $user->login,$user->fullName()) ?> 
			</td>
			</tr>

<?php 	
			}
		}
	}
?>

</table>