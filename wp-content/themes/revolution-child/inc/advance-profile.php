<?php

/*
 * User Advance Profile and Faqs related to customer oral health and tooth sensitivity
 */

function create_advance_profile_sbr($data_customer = array()) {
    if (is_empty($data_customer)) {
        $data_customer = $_POST;
    }
    global $wpdb;
    $table_name = 'user_profile_advance';
    $res = array();
    $user_id = isset($data_customer['user_id']) ? $data_customer['user_id'] : '';
    $tooth_sensivity = isset($data_customer['tooth_sensivity']) ? $data_customer['tooth_sensivity'] : '';
    $eat_drink_habits = isset($data_customer['eat_drink_habits']) ? $data_customer['eat_drink_habits'] : '';
    $dental_work = isset($data_customer['dental_work']) ? $data_customer['dental_work'] : '';
    $missing_teeth = isset($data_customer['missing_teeth']) ? $data_customer['missing_teeth'] : '';
    $uploaded_photoes = isset($data_customer['uploaded_photoes']) ? $data_customer['uploaded_photoes'] : '';
    if ($user_id == '') {
        $res['status'] = 'error';
        $res['errors'][] = 'user id is required';
    }
    if ($tooth_sensivity == '') {
        $res['status'] = 'error';
        $res['errors'][] = 'tooth sensivity is required';
    }
    if ($eat_drink_habits == '') {
        $res['status'] = 'error';
        $res['errors'][] = 'eat/drink habits is required';
    }
    if ($dental_work == '') {
        $res['status'] = 'error';
        $res['errors'][] = 'dental work is required';
    }
    if ($missing_teeth == '') {
        $res['status'] = 'error';
        $res['errors'][] = 'missing teeth is requored';
    }
    if (count($res) > 0) {
        //
    } else {
        $inserted = $wpdb->insert($table_name, array(
            'user_id' => $user_id,
            'tooth_sensivity' => $tooth_sensivity,
            'eat_drink_habits' => $eat_drink_habits,
            'dental_work' => $dental_work,
            'missing_teeth' => $missing_teeth,
            'uploaded_photoes' => $uploaded_photoes,
        ));
        if ($inserted) {
            $res['status'] = 'success';
            $res['message'] = 'recoded added successfully';
        } else {
            $res['status'] = 'error';
            $res['message'] = $wpdb->last_error;
        }
    }
    echo json_encode($res);
    die();
}
/**
 * Update an existing advance profile for a user related to oral health and tooth sensitivity.
 *
 * @param array $data_customer An array of customer data.
 */
function update_advance_profile_sbr($data_customer = array()) {
    if (is_empty($data_customer)) {
        $data_customer = $_POST;
    }
    global $wpdb;
    $table_name = 'user_profile_advance';
    $res = array();
    $profile_id = isset($data_customer['profile_id']) ? $data_customer['profile_id'] : '';
    $user_id = isset($data_customer['user_id']) ? $data_customer['user_id'] : '';
    $tooth_sensivity = isset($data_customer['tooth_sensivity']) ? $data_customer['tooth_sensivity'] : '';
    $eat_drink_habits = isset($data_customer['eat_drink_habits']) ? $data_customer['eat_drink_habits'] : '';
    $dental_work = isset($data_customer['dental_work']) ? $data_customer['dental_work'] : '';
    $missing_teeth = isset($data_customer['missing_teeth']) ? $data_customer['missing_teeth'] : '';
    $uploaded_photoes = isset($data_customer['uploaded_photoes']) ? $data_customer['uploaded_photoes'] : '';
    if ($profile_id == '') {
        $res['status'] = 'error';
        $res['errors'][] = 'profile id is required';
    }
    if ($user_id == '') {
        $res['status'] = 'error';
        $res['errors'][] = 'user id is required';
    }
    if ($tooth_sensivity == '') {
        $res['status'] = 'error';
        $res['errors'][] = 'tooth sensivity is required';
    }
    if ($eat_drink_habits == '') {
        $res['status'] = 'error';
        $res['errors'][] = 'eat/drink habits is required';
    }
    if ($dental_work == '') {
        $res['status'] = 'error';
        $res['errors'][] = 'dental work is required';
    }
    if ($missing_teeth == '') {
        $res['status'] = 'error';
        $res['errors'][] = 'missing teeth is requored';
    }
    if (count($res) > 0) {
        //
    } else {
        $inserted = $wpdb->update($table_name, array(
            'user_id' => $user_id,
            'tooth_sensivity' => $tooth_sensivity,
            'eat_drink_habits' => $eat_drink_habits,
            'dental_work' => $dental_work,
            'missing_teeth' => $missing_teeth,
            'uploaded_photoes' => $uploaded_photoes,
                ), array('id' => $profile_id));
        if ($inserted) {
            $res['status'] = 'success';
            $res['message'] = 'recoded is updated successfully';
        } else {
            $res['status'] = 'error';
            $res['message'] = $wpdb->last_error;
        }
    }
    echo json_encode($res);
    die();
}

/**
 * Delete an existing advance profile for a user related to oral health and tooth sensitivity.
 *
 * @param array $data_customer An array of customer data.
 */
function delete_advance_profile_sbr($data_customer = array()) {
    if (is_empty($data_customer)) {
        $data_customer = $_POST;
    }
    global $wpdb;
    $table_name = 'user_profile_advance';
    $res = array();
    $profile_id = isset($data_customer['profile_id']) ? $data_customer['profile_id'] : '';
    
    if ($profile_id == '') {
        $res['status'] = 'error';
        $res['errors'][] = 'profile id is required';
    }
    
    if (count($res) > 0) {
        //
    } else {
        $deleted = $wpdb->delete( $table_name, array( 'id' => $profile_id ) );
        
        if ($deleted) {
            $res['status'] = 'success';
            $res['message'] = 'recoded is deleted successfully';
        } else {
            $res['status'] = 'error';
            $res['message'] = $wpdb->last_error;
        }
    }
    echo json_encode($res);
    die();
}

?>