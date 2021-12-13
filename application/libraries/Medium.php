<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Medium {

        protected string $access_token;

        public function __construct($params)
        {
                $this->access_token = $params['access_token'];
        }

        public function get_profile()
        {
                return $this->getRequest('https://api.medium.com/v1/me');
        }

        public function get_publications()
        {
                $profile = $this->getRequest('https://api.medium.com/v1/me');
                $profile = json_decode($profile);
                $url = "https://api.medium.com/v1/users/" . $profile->data->id . "/publications";
                return $this->getRequest($url);
        }

        public function post_post($title,  $content, $contentFormat="html", $publishStatus="draft")
        {
                $profile = $this->getRequest('https://api.medium.com/v1/me');
                $profile = json_decode($profile);
                $url = "https://api.medium.com/v1/users/" . $profile->data->id . "/posts";
                $data = array(
                        'title' => $title,
                        'content' => $content,
                        'contentFormat' => $contentFormat,
                        'publishStatus' => $publishStatus
                );
                $data = json_encode($data);
                return $this->postRequest($url, $data);
        }

        private function getRequest($url, $timeout = 10)
        {
                $ssl = stripos($url,'https://') === 0 ? true : false;
                $curlObj = curl_init();
                $options = [
                        CURLOPT_URL => $url,
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_FOLLOWLOCATION => 1,
                        CURLOPT_AUTOREFERER => 1,
                        CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)',
                        CURLOPT_TIMEOUT => $timeout,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
                        CURLOPT_HTTPHEADER => [
                                'Content-Type: application/json',
                                'Accept: application/json',
                                'Accept-Charset: utf-8',
                                'Authorization: Bearer ' . $this->access_token
                        ],
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                ];
                if ($ssl) {
                        $options[CURLOPT_SSL_VERIFYHOST] = false;
                        $options[CURLOPT_SSL_VERIFYPEER] = false;
                }
                curl_setopt_array($curlObj, $options);
                $returnData = curl_exec($curlObj);
                if (curl_errno($curlObj)) {
                        //error message
                        $returnData = curl_error($curlObj);
                }
                curl_close($curlObj);
                return $returnData;
        }

        function postRequest($url, $data, $timeout = 10)
        {
                $curlObj = curl_init();
                $ssl = stripos($url,'https://') === 0 ? true : false;
                $options = [
                        CURLOPT_URL => $url,
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_POST => 1,
                        CURLOPT_POSTFIELDS => $data,
                        CURLOPT_FOLLOWLOCATION => 1,
                        CURLOPT_AUTOREFERER => 1,
                        CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)',
                        CURLOPT_TIMEOUT => $timeout,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
                        CURLOPT_HTTPHEADER => [
                                'Content-Type: application/json',
                                'Accept: application/json',
                                'Accept-Charset: utf-8',
                                'Authorization: Bearer ' . $this->access_token
                        ],
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4
                ];
                if ($ssl) {
                        $options[CURLOPT_SSL_VERIFYHOST] = false;
                        $options[CURLOPT_SSL_VERIFYPEER] = false;
                }
                curl_setopt_array($curlObj, $options);
                $returnData = curl_exec($curlObj);
                if (curl_errno($curlObj)) {
                        //error message
                        $returnData = curl_error($curlObj);
                }
                curl_close($curlObj);
                return $returnData;
        }
}