<?php
class ModelPaymentPayze extends Model {
				
	public function log($data, $title = '') {
		$_config = new Config();
		$_config->load('payze');
		
		$config_setting = $_config->get('payze_setting');
		
		$setting = array_replace_recursive((array)$config_setting, (array)$this->config->get('payment_payze_setting'));
		
		if ($setting['general']['debug']) {
			$log = new Log('payze.log');
			
			if (is_string($data)) {
				$log->write('Payze debug (' . $title . '): ' . $data);
			} else {
				$log->write('Payze debug (' . $title . '): ' . json_encode($data));
			}
		}
	}
	
	public function deleteCustomerCards($customer_id) {
		$query = $this->db->query("DELETE FROM `" . DB_PREFIX . "payze_customer_card` WHERE `customer_id` = '" . (int)$customer_id . "'");
	}
	
	public function deleteOrder($order_id) {
		$query = $this->db->query("DELETE FROM `" . DB_PREFIX . "payze_order` WHERE `order_id` = '" . (int)$order_id . "'");
	}
	
	public function getOrder($order_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "payze_order` WHERE `order_id` = '" . (int)$order_id . "'");
		
		if ($query->num_rows) {
			return $query->row;
		} else {
			return array();
		}
	}
	
	public function install() {
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "payze_order` (`order_id` INT(11) NOT NULL, `transaction_id` VARCHAR(40) NOT NULL, PRIMARY KEY (`order_id`, `transaction_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "payze_customer_card` (`customer_id` INT(11) NOT NULL, `card_id` VARCHAR(40) NOT NULL, `card_brand` VARCHAR(40) NOT NULL, `card_mask` VARCHAR(40) NOT NULL, expiration_date VARCHAR(40) NOT NULL, PRIMARY KEY (`customer_id`, `card_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
	}
	
	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "payze_order`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "payze_customer_card`");
	}
}
