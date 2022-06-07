<?php
function provinces() {
	$CI =& get_instance();
	$query  =  $CI->db->get('provinces');
	return $query->result();
}

function province($id) {
	$CI =& get_instance();
	$CI->db->where('id', $id);
	$query  =  $CI->db->get('provinces');
	return $query->row();
}

function categories() {
	$CI =& get_instance();
	$query  =  $CI->db->get('categories');
	return $query->result();
}

function merchantProfile($id) {
	$CI =& get_instance();
	$CI->db->where('id', $id);
	$query  =  $CI->db->get('merchants');
	return $query->row()->profile_picture;
}

function getAdminData($id)  
{  
	  $CI =& get_instance();
    $CI->db->where('id', $id);
    $query = $CI ->db->get('admin');
    return $query->row()->role; 
}

function get_merchant_data($id)  
{  
	  $CI =& get_instance();
    $CI->db->where('id', $id);
    $query = $CI ->db->get('merchants');
    return $query->row(); 
} 

function userStatus($status) {
	switch ($status) {
		case '2':
			$label = 'Banned';
			break;
		case '0':
			$label = 'Inactive';
			break;
		
		default:
			$label = 'Active';
			break;
	}
	return $label;
}

function dd($data) {
	echo "<pre>";
	print_r($data);
	exit;
}

function sendSMS($phone, $message) {
	$phone = ltrim($phone, '0');
	$phone = '+27'.$phone;

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'https://platform.clickatell.com/messages/http/send?apiKey=vL_cLMDKRD2vk5HWlR4dJw==&to='.$phone.'&content='.urlencode($message));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
	    echo 'Error:' . curl_error($ch);
	}
	curl_close($ch);
}