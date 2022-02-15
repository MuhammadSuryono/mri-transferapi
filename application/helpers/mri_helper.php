<?php

	function check_access($roleid, $menu_id, $id)
	{
		$ci = get_instance();

		$ci->db->where('roleid', $roleid);
		$ci->db->where('menuid', $menu_id);
		$ci->db->where('submenuid', $id);
		$result = $ci->db->get('user_access_menu');

		if($result->num_rows() > 0){
			return "checked='checked'";
		}
	}

?>