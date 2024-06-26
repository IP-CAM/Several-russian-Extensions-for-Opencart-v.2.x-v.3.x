<?php
class ModelExtensionModuleGentestimonials extends Model
{

	public function install()
	{
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "gentestimonial` (
			`testimonial_id` int(11) NOT NULL auto_increment, 
			`rating` int(1) NOT NULL default '5',
			`status` int(1) NOT NULL default '0', 
			`user` VARCHAR(255) COLLATE utf8_general_ci default NULL, 
			`userLink` VARCHAR(255) COLLATE utf8_general_ci default NULL,
			`description` TEXT COLLATE utf8_general_ci default NULL, 
			`date` date default NULL, 
			`sort_order` int(3) default NULL, 
			`positive` int(11) default '0', 
			`negative` int(11) default '0',
			`recomended_shop` int(1) default '1',
			`is_new` int(1) default '0',
			PRIMARY KEY (`testimonial_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "gentestimonial_answer` (
			`answer_id` int(11) NOT NULL auto_increment, 
			`testimonial_id` int(11) NOT NULL default '0', 			
			`status` int(1) NOT NULL default '0', 
			`user` VARCHAR(255) COLLATE utf8_general_ci default NULL, 
			`userLink` VARCHAR(255) COLLATE utf8_general_ci default NULL,
			`description` TEXT COLLATE utf8_general_ci default NULL, 
			`date` date default NULL, 
			`sort_order` int(3) default NULL, 
			PRIMARY KEY (`answer_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");

		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "gentestimonial_setting` (`testimonial_value_id` int(11) NOT NULL auto_increment,`value1` VARCHAR(255) COLLATE utf8_general_ci default NULL, `value2` VARCHAR(255) COLLATE utf8_general_ci default NULL, `template` VARCHAR(255) COLLATE utf8_general_ci default NULL, PRIMARY KEY (`testimonial_value_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

		$query3 = $this->db->query("SELECT * FROM `" . DB_PREFIX . "gentestimonial_setting` WHERE value1='26028713'");
		$num_rows3 = $query3->num_rows;
		if ($num_rows3 == 0) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "gentestimonial_setting` SET value1 = '26028713', value2 = '', template='1'");
		}

	}
	public function uninstall()
	{
		$this->db->query("DROP TABLE `" . DB_PREFIX . "gentestimonial`");
		$this->db->query("DROP TABLE `" . DB_PREFIX . "gentestimonial_setting`");
		$this->db->query("DROP TABLE `" . DB_PREFIX . "gentestimonial_answer`");
	}

	public function addTestimonial($data)
	{

		$this->db->query("UPDATE " . DB_PREFIX . "gentestimonial_setting SET value2 = '" . $this->db->escape($data['license']) . "' WHERE testimonial_value_id = '1'");

		$this->db->query("INSERT INTO " . DB_PREFIX . "gentestimonial SET 
			rating = '" . (int) $data['rating'] . "', 
			status = '" . (int) $data['status'] . "', 
			userLink = '" . $this->db->escape($data['userLink']) . "',
			description = '" . $this->db->escape($data['description']) . "',
			user = '" . $this->db->escape($data['user']) . "',  
			date = '" . $this->db->escape($data['date']) . "', 
			recomended_shop = '" . $this->db->escape($data['recomended_shop']) . "', 
			sort_order = '" . (int) $data['sort_order'] . "'");

		$this->cache->delete('gentestimonial');
	}

	public function editTestimonial($testimonial_id, $data)
	{
		//var_dump($data);
		$this->db->query("UPDATE " . DB_PREFIX . "gentestimonial SET 
		rating = '" . (int) $data['rating'] . "', 
		status = '" . (int) $data['status'] . "',
		userLink = '" . $this->db->escape($data['userLink']) . "', 
		sort_order = '" . (int) $data['sort_order'] . "',
		description = '" . $this->db->escape($data['description']) . "',
		user = '" . $this->db->escape($data['user']) . "', 
		recomended_shop = '" . $this->db->escape($data['recomended_shop']) . "', 
		date = '" . $this->db->escape($data['date']) . "' 
		WHERE testimonial_id = '" . (int) $testimonial_id . "'");
		$this->cache->delete('gentestimonial');
	}

	public function deleteTestimonial($testimonial_id)
	{
		$this->db->query("DELETE FROM " . DB_PREFIX . "gentestimonial WHERE testimonial_id = '" . (int) $testimonial_id . "'");

		$this->cache->delete('gentestimonial');
	}

	public function getTestimonialList($data = array())
	{
		if ($data) {
			// $sql = "SELECT * FROM " . DB_PREFIX . "gentestimonial n LEFT JOIN " . DB_PREFIX . "gentestimonial_description nd ON (n.testimonial_id = nd.testimonial_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			$sql = "SELECT * FROM " . DB_PREFIX . "gentestimonial ";

			$sort_data = array(
				'user',
				'date'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY user";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}

				$sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
			}

			$query = $this->db->query($sql);

			return $query->rows;
		}
	}

	public function getTestimonialsStory($testimonial_id)
	{

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gentestimonial WHERE testimonial_id = '" . (int) $testimonial_id . "'");

		return $query->row;
	}

	public function getTotalTestimonial()
	{

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "gentestimonial");

		return $query->row['total'];
	}

	public function setTestimonialsSetting($data)
	{

		$queryV = $this->db->query("SELECT value1,value2 FROM " . DB_PREFIX . "gentestimonial_setting WHERE `testimonial_value_id` = '1'");
		$value = $queryV->rows;
		$query = $this->db->query("UPDATE `oc_gentestimonial_setting` SET `testimonial_value_id`=1,`value1`='" . $value[0]['value1'] . "',`value2`='" . $value[0]['value1'] . "',`template`='" . $this->db->escape($data['template']) . "' WHERE `testimonial_value_id` = '1'");
	}

	public function getTestimonialsSetting()
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gentestimonial_setting ");

		return $query->row;
	}

	public function getValue()
	{

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gentestimonial_setting WHERE `testimonial_value_id`=1");

		return $query->row;
	}

	public function getValue2()
	{

		$query = $this->db->query("SELECT value2 FROM " . DB_PREFIX . "gentestimonial_setting WHERE `testimonial_value_id`=1");
		$a = $query->row;

		return $a['value2'];
	}

	public function copyTestimonial($testimonial_id)
	{

		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "gentestimonial WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		if ($query->num_rows) {
			$data = $query->row;


			$data['status'] = '0';

			$data['license'] = $this->getValue2();

			$this->addTestimonial($data);
		}
	}

	public function editStatusTestimonial($data)
	{
		$this->db->query("UPDATE `" . DB_PREFIX . "gentestimonial` SET `status`= '". (int)$data['status'] ."' WHERE `testimonial_id` = '". (int)$data['testimonial_id'] ."'");
	}

	public function getCountAnswer($testimonial_id){
		$query = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "gentestimonial_answer WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		return $query->row['total'];
	}
	public function getAnswerName($testimonial_id){
		$query = $this->db->query("SELECT `user` as userName, `date` as dateCreate FROM " . DB_PREFIX . "gentestimonial_answer WHERE testimonial_id = '" . (int)$testimonial_id . "' ORDER BY `date` DESC LIMIT 1");
		
		// $result=array();
		// if (isset($query->row['userName'])){
		// 	$result['userName']=$query->row['userName'];
		// }else{
		// 	$result['userName']='';
		// }
		return $query->row;
	}

	public function getAnswersByIdTestimonial($testimonial_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gentestimonial_answer WHERE testimonial_id = '" . (int)$testimonial_id . "' ORDER BY `date`");
		
		return $query->rows;
	}

	public function editStatusAnswer($data)
	{
		$this->db->query("UPDATE `" . DB_PREFIX . "gentestimonial_answer` SET `status`= '". (int)$data['status'] ."' WHERE `answer_id` = '". (int)$data['answer_id'] ."'");
	}

	public function addAnswer($testimonial_id,$data)
	{

		$this->db->query("INSERT INTO " . DB_PREFIX . "gentestimonial_answer SET 
			testimonial_id = '" . (int)$testimonial_id . "', 
			status = '" . (int)$data['status'] . "', 
			userLink = '" . $this->db->escape($data['userLink']) . "',
			description = '" . $this->db->escape($data['description']) . "',
			user = '" . $this->db->escape($data['user']) . "',  
			date = '" . $this->db->escape($data['date']) . "', 
			sort_order = '" . (int)$data['sort_order'] . "'");

		$this->cache->delete('gentestimonial');
	}

	public function editAnswer($testimonial_id, $answer_id, $data)
	{
		//var_dump($data);
		$this->db->query("UPDATE " . DB_PREFIX . "gentestimonial_answer SET 
		testimonial_id = '" . (int)$testimonial_id . "', 
		status = '" . (int) $data['status'] . "',
		userLink = '" . $this->db->escape($data['userLink']) . "', 
		sort_order = '" . (int) $data['sort_order'] . "',
		description = '" . $this->db->escape($data['description']) . "',
		user = '" . $this->db->escape($data['user']) . "', 
		date = '" . $this->db->escape($data['date']) . "' 
		WHERE answer_id = '" . (int) $answer_id . "'");

	}

	public function copyAnswer($answer_id) {
		
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "gentestimonial_answer WHERE answer_id = '" . (int)$answer_id . "'");

		if ($query->num_rows) {
			$data = $query->row;

			$data['status'] = '0';

			$this->addAnswer($data['testimonial_id'],$data);
		}
	}

	public function deleteAnswers($answer_id)
	{
		$this->db->query("DELETE FROM " . DB_PREFIX . "gentestimonial_answer WHERE answer_id = '" . (int) $answer_id . "'");

	}

	public function getAnswersStory($answer_id)
	{

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gentestimonial_answer WHERE answer_id = '" . (int) $answer_id . "'");

		return $query->row;
	}
	public function deletaStatusIsNew($testimonial_id)
	{
		$this->db->query("UPDATE " . DB_PREFIX . "gentestimonial SET is_new = '0' WHERE testimonial_id = '" . (int)$testimonial_id . "'");

	}

}
?>