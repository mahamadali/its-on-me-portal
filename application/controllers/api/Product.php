<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Product extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
       $this->load->helper('general');
       $this->load->model('User', 'user');
       $this->load->model('Merchant', 'merchant');
       $this->load->model('Products_model', 'product');
       $this->load->library('email');
    }

    /**
     * Get All categories Data from this method.
     *
     * @return Response
    */
    public function categories_post()
    {
        $input = $this->input->post();
        /*if(!isset($input['user_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing User ID'], REST_Controller::HTTP_OK);
        }
        $user = $this->user->findByColumn('id', $input['user_id']);
        if(empty($user)) {
            return $this->response(['status' => 'failed', 'message' => 'You do not have permission'], REST_Controller::HTTP_OK);
        }*/
        $response = $this->db->get('categories')->result_array();
        $this->response(['status' => 'success', 'data' => $response], REST_Controller::HTTP_OK);
    }

    public function merchantsBycategory_post()
    {
        $input = $this->input->post();
        /*if(!isset($input['user_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing User ID'], REST_Controller::HTTP_OK);
        }*/
        if(!isset($input['category_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing Category ID'], REST_Controller::HTTP_OK);
        }
       /* $user = $this->user->findByColumn('id', $input['user_id']);
        if(empty($user)) {
            return $this->response(['status' => 'failed', 'message' => 'You do not have permission'], REST_Controller::HTTP_OK);
        }*/
        if(empty($input['category_id']))
        {
            $merchants = $this->merchant->getDataByCategoryId();
        }
        else
        {
            $merchants = $this->merchant->getDataByCategoryId($input['category_id']);
        }
        return $this->response(['status' => 'success', 'data' => $merchants], REST_Controller::HTTP_OK);
    }

    public function productOffers_post() {
        $products = $this->product->fetchOffers();
        return $this->response(['status' => 'success', 'data' => $products], REST_Controller::HTTP_OK);
    }

    public function productGiftIdeas_post() {
        $products = $this->product->giftIdeas();
        return $this->response(['status' => 'success', 'data' => $products], REST_Controller::HTTP_OK);
    }
    public function searchByProvince_post() {
        $products = $this->product->searchByProvince($this->input->post('province'));
        return $this->response(['status' => 'success', 'data' => $products], REST_Controller::HTTP_OK);
    }
    public function searchByName_post() {
        $products = $this->product->searchByName($this->input->post('name'));
        return $this->response(['status' => 'success', 'data' => $products], REST_Controller::HTTP_OK);
    }
    public function searchByBrand_post() {
        $products = $this->product->searchByBrand($this->input->post('name'));
        return $this->response(['status' => 'success', 'data' => $products], REST_Controller::HTTP_OK);
    }

    public function brandCategories_post() {
        $input = $this->input->post();
        if(!isset($input['user_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing User ID'], REST_Controller::HTTP_OK);
        }
        if(!isset($input['brand_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing Brand ID'], REST_Controller::HTTP_OK);
        }
        $categories = $this->merchant->getCategoryDataByBrandId($input['brand_id']);
        return $this->response(['status' => 'success', 'data' => $categories], REST_Controller::HTTP_OK);
    }

     public function fetchBrandsByCat_post() {
        $input = $this->input->post();
        /*if(!isset($input['user_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing User ID'], REST_Controller::HTTP_OK);
        }*/
        if(!isset($input['brand_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing Brand ID'], REST_Controller::HTTP_OK);
        }
        if(!isset($input['category_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing Category ID'], REST_Controller::HTTP_OK);
        }
        $categories = $this->merchant->fetchBrandsByCat($input['brand_id'],$input['category_id']);
        return $this->response(['status' => 'success', 'data' => $categories], REST_Controller::HTTP_OK);
    }

    public function brandsTopOffers_post() {
        $input = $this->input->post();
        if(!isset($input['user_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing User ID'], REST_Controller::HTTP_OK);
        }
        if(!isset($input['brand_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing Brand ID'], REST_Controller::HTTP_OK);
        }
        $topOffers = $this->merchant->brandsTopOffers($input['brand_id']);
        return $this->response(['status' => 'success', 'data' => $topOffers], REST_Controller::HTTP_OK);
    } 


     public function searchProductByText_post() {
        $input = $this->input->post();
        if(!isset($input['user_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing User ID'], REST_Controller::HTTP_OK);
        }
        if(!isset($input['search_text'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing Search Text'], REST_Controller::HTTP_OK);
        }
        $productList = $this->merchant->searchProduct($input['search_text']);
        return $this->response(['status' => 'success', 'data' => $productList], REST_Controller::HTTP_OK);
    }

     public function searchBrandProductByText_post() {
        $input = $this->input->post();
        if(!isset($input['user_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing User ID'], REST_Controller::HTTP_OK);
        }
        if(!isset($input['brand_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing Brand ID'], REST_Controller::HTTP_OK);
        }
        if(!isset($input['search_text'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing Search Text'], REST_Controller::HTTP_OK);
        }
        $productList = $this->merchant->searchBrandProduct($input['search_text'],$input['brand_id']);
        return $this->response(['status' => 'success', 'data' => $productList], REST_Controller::HTTP_OK);
    }

     public function productDetails_post() {
        $input = $this->input->post();
        if(!isset($input['user_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing User ID'], REST_Controller::HTTP_OK);
        }
        if(!isset($input['brand_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing Brand ID'], REST_Controller::HTTP_OK);
        }
        if(!isset($input['product_id'])) {
         return $this->response(['status' => 'failed', 'message' => 'Missing Product ID'], REST_Controller::HTTP_OK);
        }
        $productDetail = $this->merchant->ProductDetails($input['product_id'],$input['brand_id']);
        return $this->response(['status' => 'success', 'data' => $productDetail], REST_Controller::HTTP_OK);
    }
 }