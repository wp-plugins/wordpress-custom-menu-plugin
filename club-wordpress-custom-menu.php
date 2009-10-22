<?php
/*
Plugin Name: Club Wordpress Custom Menu
Plugin URI: http://www.clubwordpress.com/club-wordpress-custom-menu/
Description: Create and display a custom menu. Use <em>Manage->Custom Menu</em> to set options. Use <em>&lt;?php cwcm_output() ?&gt;</em> to output your custom menu.
Author: Dominic Foster
Version: 1.1.0
Author URI: http://www.clubwordpress.com/
*/

/*
Club Wordpress Custom Menu is a Wordpress Plugin that allows you to create and manage a custom menu.
Copyright (C) 2007 ClubWordpress.com

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

define('CWCM_TABLE', $table_prefix . 'custom_menu_items');

$action = !empty($_REQUEST['action']) ? $_REQUEST['action'] : '';
$linkID = !empty($_REQUEST['linkID']) ? $_REQUEST['linkID'] : '';

//admin menu
function cw_custom_menu_admin() {
	if (function_exists('add_options_page')) {
		add_management_page('cw-custom-menu', 'Custom Menu', 1, basename(__FILE__), 'cw_custom_menu_admin_panel');
  }
}

function cw_custom_menu_admin_panel() {

	global $wpdb, $table_prefix;
	$alt = 'alternate';
	$buttontext = "Add Menu Item &raquo;";

	//Get the action for the form
	if(!empty($_REQUEST['action'])) {
		$action = $_REQUEST['action'];
	}
	else {
		$action = "add";
	}

	//Get ID of Edit/Delete
	if(!empty($_REQUEST['lnkID'])) { $lnkID = $_REQUEST['lnkID'];	}

	//First time run - allow to build new table
	$tableExists = false;

	$tables = $wpdb->get_results("show tables;");

	foreach ( $tables as $table )
	{
		foreach ( $table as $value )
		{
			if ( $value == CWCM_TABLE )
			{
				$tableExists=true;
				break;
			}
		}
	}

	//if the menu items table does not exist, then create it
	if ( !$tableExists )
	{
		$sql = "CREATE TABLE " . CWCM_TABLE . " (
					cwcm_item_ID INT(11) NOT NULL AUTO_INCREMENT,
					cwcm_item_text TEXT NOT NULL,
					cwcm_item_url TEXT,
					cwcm_item_visible  ENUM( 'yes', 'no' ) NOT NULL ,
					PRIMARY KEY ( cwcm_item_ID )
				)";
		$wpdb->get_results($sql);

		//add a default item
		$sql = "INSERT INTO " . CWCM_TABLE . " (cwcm_item_text, cwcm_item_url, cwcm_item_visible)
						VALUES ('Home', '/', 1)";
		$wpdb->get_results($sql);

	}

	//perform Add/Edit/Delete
	switch ($action) {
		case 'add':
			//check that we have the necessary variables
			if(!empty($_REQUEST['linkText'])) {
					$linkText = $_REQUEST['linkText'];
					$linkUrl = $_REQUEST['linkUrl'];
					$linkVisible = $_REQUEST['linkVisible'];

				//echo $stkname . $stkdesc . $stkvis;
				$sql = "INSERT INTO " . CWCM_TABLE . " (cwcm_item_text, cwcm_item_url, cwcm_item_visible)
								VALUES ('" . $linkText . "', '" . $linkUrl . "', '" . $linkVisible . "')";
				$wpdb->get_results($sql);
			}
			break;
		case 'edit':
			if(empty($_REQUEST['save'])) {
				if(!empty($_REQUEST['lnkID'])) {
					$sql = "SELECT * FROM " . CWCM_TABLE . " WHERE cwcm_item_ID=" . $_REQUEST['lnkID'];
					$linkedit = $wpdb->get_results($sql);
					$linkedit = $linkedit[0];
					$buttontext = "Save Menu Item &raquo;";
					$save = "&amp;save=yes";
				}
			} else {
				//check that we have the necessary variables
				if(!empty($_REQUEST['linkText'])) {
					$linkText = $_REQUEST['linkText'];
					$linkUrl = $_REQUEST['linkUrl'];
					$linkVisible = $_REQUEST['linkVisible'];

					$sql = "UPDATE " . CWCM_TABLE . "
									SET
									cwcm_item_text='" . $linkText . "',
									cwcm_item_url='" . $linkUrl . "',
									cwcm_item_visible='" . $linkVisible . "'
									WHERE cwcm_item_ID=" . $_REQUEST['linkID'];
					$wpdb->get_results($sql);
					$action = "add";
				}
			}
			break;
		case 'delete':
			$sql = "DELETE FROM " . CWCM_TABLE . " WHERE cwcm_item_ID=" . $_REQUEST['lnkID'];
			$wpdb->get_results($sql);

			$action = 'add';

			break;
	}

	?>

	<div class="wrap">

		<h2>Menu Items (<a href="#addmenuitem">Add New</a>)</h2>

		<table class="widefat">
			<thead>
				<tr>
					<th scope="col"><div style="text-align: center">Link Text</div></th>
					<th scope="col">Link URL</th>
					<th scope="col">Visible</th>
					<th colspan="3" style="text-align: center">Action</th>
				</tr>
			</thead>

			<tbody>

			<?php
			$links = $wpdb->get_results("SELECT * FROM " . CWCM_TABLE);

			foreach ( $links as $link ) {
				$class = ('alternate' == $class) ? '' : 'alternate';
			?>

				<tr id='post-7' class='<?php echo $class; ?>'>
					<th scope="row" style="text-align: center"><?php echo $link->cwcm_item_text; ?></th>
					<td><?php echo $link->cwcm_item_url; ?></td>
					<td><?php echo $link->cwcm_item_visible; ?></td>
					<td><a href="edit.php?page=club-wordpress-custom-menu&amp;action=edit&amp;lnkID=<?php echo $link->cwcm_item_ID; ?>#addmenuitem" class="delete"><?php echo __('Edit'); ?></a></td>
					<td><a href="edit.php?page=club-wordpress-custom-menu&amp;action=delete&amp;lnkID=<?php echo $link->cwcm_item_ID; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this menu item?')"><?php echo __('Delete'); ?></a></td>
				</tr>

			<?php

				if ($alt = 'alternate') { $alt = ''; } elseif ($alt = '') { $alt = 'alternate'; }

			}
			?>

			</tbody>
		</table>

	</div>

	<div class="wrap">

		<h2>Add Menu Item</h2>

		<form name="addmenuitem" id="addmenuitem" method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?page=club-wordpress-custom-menu.php' . $save ?>">
			<input type="hidden" name="action" value="<?php echo $action ?>" />
			<input type="hidden" name="linkID" value="<?php echo $lnkID ?>" />

			<table class="editform" width="100%" cellspacing="2" cellpadding="5">
				<tr>
					<th width="33%" scope="row" valign="top"><label for="stkName"><?php _e('Link Text:') ?></label></th>
					<td width="67%">
					<input name="linkText" id="linkText" type="text" value="<?php echo attribute_escape($linkedit->cwcm_item_text); ?>" size="40" /></td>
				</tr>
				<tr>
					<th width="33%" scope="row" valign="top"><label for="stkName"><?php _e('Link URL:') ?></label></th>
					<td width="67%">
					<input name="linkUrl" id="linkUrl" type="text" value="<?php echo attribute_escape($linkedit->cwcm_item_url); ?>" size="40" /></td>
				</tr>
				<tr>
					<th scope="row" valign="top"><label for="lnkVisible"><?php _e('Visible:') ?></label></th>
					<td>
						<input type="radio" name="linkVisible" class="input" value="yes"
						<?php if ( empty($linkedit) || $linkedit->cwcm_item_visible=='yes' ) echo "checked" ?>/> Yes
						<br />
						<input type="radio" name="linkVisible" class="input" value="no"
						<?php if ( !empty($linkedit) && $linkedit->cwcm_item_visible=='no' ) echo "checked" ?>/> No
					</td>
				</tr>
			</table>

			<p class="submit"><input type="submit" name="submit" value="<?php echo $buttontext ?>" /></p>

		</form>

	</div>

	<?php
}


//hooks
add_action('admin_menu', 'cw_custom_menu_admin');

//function to output the custom menu to WP
function custommenu_output() {
	global $wpdb;
	$yahoo = new yahoo;

	$sql = "select * from " . CWCM_TABLE . " where linkVisible='yes'";

	$results = $wpdb->get_results($sql);

	?>
	<ul>
	<?php

	foreach( $results as $result ) {

	?>

		<li><a href='<?php echo $result->cwcm_item_url ?>' title='<?php echo $result->cwcm_item_text ?>'><?php echo $result->cwcm_item_text ?></a></li>

	<?php
	}

	?>

	</ul>
	<?php

}



?>