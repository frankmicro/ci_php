<?php
defined('BASEPATH') or exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Auth extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load these helper to create JWT tokens
        $this->load->helper(['jwt', 'authorization']);
    }

    public function token_get()
    {
        $tokenData = 'Hello World!';

        // Create a token
        $token = AUTHORIZATION::generateToken($tokenData);
        
        // Set HTTP status code
        $status = parent::HTTP_OK;
        // Prepare the response
        $response = ['status' => $status, 'token' => $token];
        // REST_Controller provide this method to send responses
        $this->response($response, $status);
    }

    public function login_post()
    {
        $username = $this->post('username');
        $password = $this->post('password');

        $query = $this->db->select('id, username, password')->where("username", $username)->from('user')->get()->result_array();

        if ($query) {
            if ($query[0]['password'] == sha1($password)) {
                // Create a token from the user data and send it as reponse
                $token = AUTHORIZATION::generateToken(['username' => $query[0]['username']]);
                // Prepare the response
                $status = parent::HTTP_OK;
                $response = ['status' => $status, 'token' => $token];

                $this->response($response, $status);
            } else {
                $this->response(['msg' => 'Invalid username or password!'], parent::HTTP_NOT_FOUND);
            }
        }
    }

    public function get_me_data_post()
    {
        // Call the verification method and store the return value in the variable
        $data = $this->verify_request();
        // Send the return data as reponse
        $status = parent::HTTP_OK;
        $response = ['status' => $status, 'data' => $data];
        $this->response($response, $status);
    }

    private function verify_request()
    {
        // Get all the headers
        $headers = $this->input->request_headers();

        // Extract the token
        $token = $headers['Authorization'];

        // Use try-catch
        // JWT library throws exception if the token is not valid
        try {
            // Validate the token
            // Successfull validation will return the decoded user data else returns false
            $data = AUTHORIZATION::validateToken($token);
            if ($data === false) {
                $status = parent::HTTP_UNAUTHORIZED;
                $response = ['status' => $status, 'msg' => 'Unauthorized Access!'];
                $this->response($response, $status);

                exit();
            } else {
                return $data;
            }
        } catch (Exception $e) {
            // Token is invalid
            // Send the unathorized access message
            $status = parent::HTTP_UNAUTHORIZED;
            $response = ['status' => $status, 'msg' => 'Unauthorized Access! '];
            $this->response($response, $status);
        }
    }
}
