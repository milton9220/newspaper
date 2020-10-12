<?php


function getStatusMessage($statusCode=0){
    $status=[
        '0'=>'',
        '1' =>'Duplicate Username!! Please try another username',
        '2' =>'Some Fields Are Empty!!Please Check Again',
        '3' =>'User Created Successfully',
        '4' =>'User Deleted Successfully',
        '5' =>'Username OR Password Didn\'t match',
        '6' =>'Username Doesn\'t Exits!!',
        '7' =>'Category Name Added Successfully!!',
        '8' =>'Please Add Category Name!!',
        '9' =>'Category Name  Updated!!',
        '10' =>'Category Name  Deleted!!',
        '11' =>'Post Added Successfully!!',
        '12' =>'This File Extension is not allowed !!Please Choose JPEG Or PNG Or JPG File',
        '13' =>'File Size must be less than 2MB',
        '14' =>'Post Updated Successfully',
        '15' =>'Post Deleted Successfully'

        

        
    ];
    return $status[$statusCode];

}
