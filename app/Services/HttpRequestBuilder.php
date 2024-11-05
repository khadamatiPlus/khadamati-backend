<?php

namespace App\Services;

use \Exception;

final class HttpRequestBuilder
{

    /**
     * @var array $allowed_methods
     */
	private static array $allowed_methods =
	[

    ];

    /**
     * @return HttpRequestBuilder|null
     */
    public static function getInstance(): ?HttpRequestBuilder
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new self();
        }
        return $inst;
    }

    /**
     * Private ctor
     */
    private function __construct()
    {

    }

    /**
     * @param $method
     * @param array $args
     * @param array $files
     * @return array|mixed
     */
    public function postAction($method, $args = [], $files = [])
    {
        try {

            if (in_array($method, self::$allowed_methods)) {

                $headers = [
                    'content-type: multipart/form-data',
                ];
                if(sizeof($files) > 0){
                    $index = 0;
                    foreach ($files['files']['tmp_name'] as $file) {
                        if (function_exists('curl_file_create')) {
                            $file = curl_file_create($file);
                        } else {
                            $file = '@' . realpath($file);
                        }
                        $args["file_".$index] = $file;
                        $index = $index + 1;
                    }
                }
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, env('EXTERNAL_API_LINK').$method.'');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                $info = curl_getinfo($ch);
                $result = json_decode($result);
                curl_close($ch);

                return $result;

            } else {
                return array(
                    'status' => 'error',
                    'errors' => 'method ('.$method.') not allowed'
                );
            }

        } catch (Exception $exception) {
            report($exception);
            return array(
                'status' => 'error',
                'errors' => $exception->getMessage()
            );
        }
    }

    /**
     * @param $method
     * @param array $args
     * @return array|mixed
     */
    public function postJsonAction($method, $args = [])
    {
        try {

            if (in_array($method, self::$allowed_methods)) {

                $header = [
                    'Content-Type:application/json',
                ];

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, env('EXTERNAL_API_LINK').$method.'');


                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                if (!$result) {
                    return array(
                        'status' => 'error',
                        'errors' => prepare_single_validation_error(curl_error($ch))
                    );
                }

                $info = curl_getinfo($ch);
                $result = json_decode($result);
                curl_close($ch);

                return $result;

            } else {

                return array(
                    'status' => 'error',
                    'errors' => prepare_single_validation_error('method ('.$method.') not allowed')
                );
            }

        } catch (Exception $exception) {
            report($exception);
            return array(
                'status' => 'error',
                'errors' => prepare_single_validation_error($exception->getMessage())
            );
        }
    }
}

?>
