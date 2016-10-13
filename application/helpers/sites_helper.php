<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * HTTP method checker - Koppos7 sites helpers
 * @param  string $method  get|post|patch|delete
 * @param  string $message given message if method not matched
 * @return response
 */
function http_method_checker($method = "get", $message = "", $json = true)
{
    $CI      = &get_instance();
    $message = ($message == '') ? 'Method HTTP tidak di ijinkan!' : $message;
    if ($CI->input->method() != $method) {
        if ($json) {
            $unallowed = [
                'response' => false,
                'message'  => $message,
            ];
            $CI->output
                ->set_content_type('application/json')
                ->set_output(json_encode($unallowed, JSON_NUMERIC_CHECK));
        }

        return false;
    }
    return true;
}

/**
 * Convert given integer to String Month 'INDONESIAN'
 * @param  integer $int        Must be 1 - 12
 * @param  boolean $boolReturn bool return
 * @return string   String
 */
function intToMonth($int = 1, $boolReturn = false)
{
    if ($int < 1 || $int > 12) {
        return ($boolReturn) ? false : '';
    }
    $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    return $bulan[$int - 1];
}
/* End of file sites_helper.php */
/* Location: ./application/controllers/sites_helper.php */
