<?php

namespace App\Http\Livewire\Dashboard\Template\Traits;

trait FileConfigValidation
{
    /**
     *  Fungsi untuk mem-validasi template undangan
     *  melemparkan exception jika validasi error
     *
     *  @param array $array
     */
    protected function validateTemplateData(array $array)
    {
        foreach($array as $k => $value) {

            if(!array_key_exists('data_type', $value)) {
                throw new \Exception("<strong>[ConfigError]</strong> 'data_type' tidak di-temukan di salah satu property ");
            }

            if(!array_key_exists('name', $value)) {
                throw new \Exception("<strong>[ConfigError]</strong> 'name' tidak di-temukan di salah satu property ");
            }

            if($value['data_type'] === 'array') {
                $this->validate_array_type($value);
                continue;
            }

            if(!array_key_exists('value', $value)) {
                throw new \Exception("<strong>[ConfigError]</strong> 'value' tidak di-temukan di salah satu property ");
            }

            // validasi kecocokan data type dan value-nya
            $this->validate_data_types($value['value'], $value['data_type']);

            if($value['data_type'] === 'url') {
                continue;
            }

            if(!array_key_exists('min_size', $value)) {
                throw new \Exception("<strong>[ConfigError]</strong> 'min_size' tidak di-temukan di salah satu property ");
            }

            if(!array_key_exists('max_size', $value)) {
                throw new \Exception("<strong>[ConfigError]</strong> 'max_size' tidak di-temukan di salah satu property ");
            }


        }
    }

    /**
     *  Fungsi untuk validasi array di file konfig
     *
     *  @param array $array_type
     */
    protected function validate_array_type($array_type)
    {
        $array_keys = [];
        $array_types = [];

        foreach($array_type['value_types'] as $k => $v) {
            $array_keys[] = $k;
            $array_types[$k] = $v['data_type'];

            if($v['data_type'] === 'array') {
                throw new \Exception("<strong>[ConfigError]</strong> tidak bisa melakukan array bersarang/nested array");
            }
        }

        foreach($array_type['value'] as $k => $v) {

            foreach($v as $_k => $_v) {
                $result = array_search($_k, $array_keys);
                $value_type = $array_types[$_k];

                if($result === false) {
                    throw new \Exception("<strong>[ConfigError]</strong> Key '$_k' tidak di-temukan di dalam value_types dari array '". $array_type['name'] ."'");
                }

                $this->validate_data_types($_v, $value_type, ['string', 'url', 'image', 'video', 'numeric']);
            }

        }

    }

    /**
     *  Fungsi untuk validasi data type di file config
     *
     *  @param mixed $value
     *  @param Optional $allow_types
     */
    protected function validate_data_types($value, $type, $allowed_types = null)
    {
        $types = [
            'array', 'string', 'url', 'image', 'video', 'audio', 'numeric',
            'object', 'boolean',
        ];

        if(array_search($type, ['image', 'audio', 'video']) !== false) {
            return;
        }

        $actual_type = null;

        switch($value) {
            case is_array($value):
                $actual_type = 'array';
                break;
            case is_string($value):
                $actual_type = 'string';
                break;
            case is_numeric($value):
                $actual_type = 'numeric';
                break;
            case is_object($value):
                $actual_type = 'object';
                break;
            case is_bool($value):
                $actual_type = 'boolean';
                break;
            default:
                $actual_type = null;
        }

        if($actual_type === null) {
            throw new \Exception("Tipe data dari $value tidak ter-indentifikasi");
        }

        if(array_search($type, $allowed_types ?? $types) === false) {
            throw new \Exception("<strong>[ConfigError]</strong> tipe data '$type' tdk teridentifikasi");
        }


        if(strtolower($actual_type) !== strtolower($type)) {
            throw new \Exception("<strong>[ConfigError]</strong> tipe data konfig <strong>'$type'</strong> dan aktual tipe data <strong>'$actual_type'</strong> tidak sesuai!!");
        }

        return;


    }

    protected function array_is_list(array $arr)
    {
        if ($arr === []) {
            return true;
        }
        return array_keys($arr) === range(0, count($arr) - 1);
    }
}
