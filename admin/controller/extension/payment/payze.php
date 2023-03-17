<?php
class ControllerExtensionPaymentPayze extends Controller {
	private $error = array();
	
	public function index() {
		$this->load->language('extension/payment/payze');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/payment/payze');
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('payze', $this->request->post);
														
			$this->session->data['success'] = $this->language->get('success_save');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_tab_general'] = $this->language->get('text_tab_general');
		$data['text_tab_order_status'] = $this->language->get('text_tab_order_status');
		$data['text_blocked_status'] = $this->language->get('text_blocked_status');
		$data['text_card_added_status'] = $this->language->get('text_card_added_status');
		$data['text_committed_status'] = $this->language->get('text_committed_status');
		$data['text_created_status'] = $this->language->get('text_created_status');
		$data['text_refunded_status'] = $this->language->get('text_refunded_status');		
		$data['text_refunded_partially_status'] = $this->language->get('text_refunded_partially_status');
		$data['text_rejected_status'] = $this->language->get('text_rejected_status');
		$data['text_timeout_status'] = $this->language->get('text_timeout_status');
		
		$data['entry_api_key'] = $this->language->get('entry_api_key');
		$data['entry_api_secret'] = $this->language->get('entry_api_secret');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_preauthorize'] = $this->language->get('entry_preauthorize');
		$data['entry_debug'] = $this->language->get('entry_debug');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$data['help_total'] = $this->language->get('help_total');
						
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
					
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extensions'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/payment/payze', 'token=' . $this->session->data['token'], true)
		);
						
		$data['action'] = $this->url->link('extension/payment/payze', 'token=' . $this->session->data['token'], true);
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);
		
		// Setting 		
		$_config = new Config();
		$_config->load('payze');
		
		$data['setting'] = $_config->get('payze_setting');
		
		if (isset($this->request->post['payze_setting'])) {
			$data['setting'] = array_replace_recursive((array)$data['setting'], (array)$this->request->post['payze_setting']);
		} else {
			$data['setting'] = array_replace_recursive((array)$data['setting'], (array)$this->config->get('payze_setting'));
		}
		
		if (isset($this->request->post['payze_api_key'])) {
			$data['api_key'] = $this->request->post['payze_api_key'];
		} else {
			$data['api_key'] = $this->config->get('payze_api_key');
		}
		
		if (isset($this->request->post['payze_api_secret'])) {
			$data['api_secret'] = $this->request->post['payze_api_secret'];
		} else {
			$data['api_secret'] = $this->config->get('payze_api_secret');
		}
		
		if (isset($this->request->post['payze_total'])) {
			$data['total'] = $this->request->post['payze_total'];
		} else {
			$data['total'] = $this->config->get('payze_total');
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['payze_geo_zone_id'])) {
			$data['geo_zone_id'] = $this->request->post['payze_geo_zone_id'];
		} else {
			$data['geo_zone_id'] = $this->config->get('payze_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['payze_status'])) {
			$data['status'] = $this->request->post['payze_status'];
		} else {
			$data['status'] = $this->config->get('payze_status');
		}
		
		if (isset($this->request->post['payze_sort_order'])) {
			$data['sort_order'] = $this->request->post['payze_sort_order'];
		} else {
			$data['sort_order'] = $this->config->get('payze_sort_order');
		}
				
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['api_key'])) {
			$data['error_api_key'] = $this->error['api_key'];
		} else {
			$data['error_api_key'] = '';
		}
		
		if (isset($this->error['api_secret'])) {
			$data['error_api_secret'] = $this->error['api_secret'];
		} else {
			$data['error_api_secret'] = '';
		}
					
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/payze/payze', $data));
	}
	
	public function install() {		
		$this->load->model('extension/payment/payze');
		
		$this->model_extension_payment_payze->install();
				
		$this->load->model('extension/event');
		
		$this->model_extension_event->deleteEvent('payze_order_add_order_history');
		$this->model_extension_event->deleteEvent('payze_order_delete_order');
		$this->model_extension_event->deleteEvent('payze_customer_delete_customer');
		
		$this->model_extension_event->addEvent('payze_order_add_history', 'catalog/model/checkout/order/addOrderHistory/before', 'extension/payment/payze/order_add_order_history_before');
		$this->model_extension_event->addEvent('payze_order_delete_order', 'catalog/model/checkout/order/deleteOrder/before', 'extension/payment/payze/order_delete_order_before');
		$this->model_extension_event->addEvent('payze_order_delete_order', 'admin/model/sale/order/deleteOrder/before', 'extension/payment/payze/order_delete_order_before');
		$this->model_extension_event->addEvent('payze_customer_delete_customer', 'admin/model/customer/customer/deleteCustomer/before', 'extension/payment/payze/customer_delete_customer_before');
	}
		
	public function uninstall() {
		$this->load->model('extension/payment/payze');
		
		$this->model_extension_payment_payze->uninstall();
		
		$this->load->model('extension/event');
		
		$this->model_extension_event->deleteEvent('payze_order_add_order_history');
		$this->model_extension_event->deleteEvent('payze_order_delete_order');
		$this->model_extension_event->deleteEvent('payze_customer_delete_customer');
	}
	
	public function order() {
		if ($this->config->get('payze_status') && !empty($this->request->get['order_id'])) {
			$this->load->language('extension/payment/payze');
			
			$this->load->model('extension/payment/payze');
						
			$order_id = $this->request->get['order_id'];
			
			$payze_order_info = $this->model_extension_payment_payze->getOrder($order_id);
				
			if ($payze_order_info) {
				$data['text_transaction_id'] = $this->language->get('text_transaction_id');
				
				$data['transaction_id'] = $payze_order_info['transaction_id'];
				
				return $this->load->view('extension/payment/payze/order', $data);
			}
		}
	}
	
	public function order_delete_order_before(&$route, &$data) {
		$this->load->model('extension/payment/payze');

		$order_id = $data[0];

		$this->model_extension_payment_payze->deleteOrder($order_id);
	}
	
	public function customer_delete_customer_before(&$route, &$data) {
		$this->load->model('extension/payment/payze');

		$customer_id = $data[0];

		$this->model_extension_payment_payze->deleteCustomerCards($customer_id);
	}
								
	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/payze')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$this->request->post['payze_api_key'] = trim($this->request->post['payze_api_key']);

		if (utf8_strlen($this->request->post['payze_api_key']) != 32) {
			$this->error['api_key'] = $this->language->get('error_api_key');
			$this->error['warning'] = $this->language->get('error_warning');
		} 
		
		$this->request->post['payze_api_secret'] = trim($this->request->post['payze_api_secret']);

		if (utf8_strlen($this->request->post['payze_api_secret']) != 32) {
			$this->error['api_secret'] = $this->language->get('error_api_secret');
			$this->error['warning'] = $this->language->get('error_warning');
		} 

		return !$this->error;
	}
}