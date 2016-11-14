<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sites_captcha
{
    protected $CI;

    protected $cap;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    /**
     * Get generated captcha
     * @return Object
     */
    public function getCaptcha()
    {
        return $this->cap;
    }

    protected function _delete_captcha()
    {
        $this->CI->load->helper(['captcha', 'file', 'date']);
        // Scan folder captcha
        $captcha_dirs = get_dir_file_info('./captcha/');
        // Delete each files that creation time (+30 minustes) smaller than now
        foreach ($captcha_dirs as $value) {
            $exp_date = strtotime('+2 minutes', $value['date']);
            $mime     = get_mime_by_extension('./captcha/' . $value['name']);
            if ($mime == 'image/jpeg' && $exp_date < mysql_to_unix(date('YmdHis'))) {
                unlink($value['server_path']);
            }
        }
    }

    /**
     * Create captcha based on Koppos Sites
     * @param  String $key
     * @return $this
     */
    public function captcha($key = 'sites_captcha')
    {
        $this->_delete_captcha();
        $vals = [
            'img_path'    => './captcha/',
            'img_url'     => base_url('captcha'),
            'font_path'   => './captcha/fonts/Roboto-Regular.ttf',
            'img_width'   => '150',
            'img_height'  => 50,
            'expiration'  => 5,
            'word_length' => 4,
            'font_size'   => 24,
            'img_id'      => 'Imageid',
            'pool'        => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',

            // White background and border, black text and red grid
            'colors'      => [
                'background' => array(224, 224, 224),
                'border'     => array(255, 255, 255),
                'text'       => array(255, 0, 0),
                'grid'       => array(224, 224, 224),
            ],
        ];

        $this->cap         = create_captcha($vals);
        $this->cap['word'] = md5($this->cap['word']);
       
        $this->CI->session->set_tempdata($key,$this->cap['word'], 600);

        return $this;
    }

    /**
     * Return captcha to JSON format
     * @return Void
     */
    public function json()
    {
        $this->CI->output
            ->set_content_type('application/json')
            ->set_output(json_encode($this->cap, JSON_NUMERIC_CHECK));
        return;
    }

    /**
     * Validating sites captcha
     * @param  string $input p
     * @param  string $key   Session key
     * @return bool
     */
    public function check_captcha($input, $key = 'sites_captcha')
    {
        if (md5($input) == $this->CI->session->tempdata($key)) {
            return true;
        }
        return false;
    }


}
