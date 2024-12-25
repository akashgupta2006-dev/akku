<?php

function CheckDuplicate_categories($conn, $url)
{
    $sql = "SELECT * FROM categories where SlugUrl = '$url'";
    if ($result = mysqli_query($conn, $sql)) {
        $rowcount = mysqli_num_rows($result);
        if ($rowcount > 0)
            return "Duplicate";
        else
            return false;
    }
    return false;
}

function getCategoriesDetailsID($conn, $ID)
{
    $slug = array();
    $sql = "Select * from categories where ID = $ID";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                extract($row);
                $slug = $row['SlugUrl'];
            }
        }
    } else {
        $error = mysqli_error($conn);
        echo $sql;
        echo $error;
        return $error;
    }
    return $slug;
}

function InsertCategories($conn,$data)
{
    $title = $data['name'];
    $specialUrl = str_replace(' ', '-', strtolower($title));
    $url = str_replace("&", "and", $specialUrl);
    $position = $data['position'];
    $seo_title = $data['seo_title'];
    $seo_description = $data['seo_description'];
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
    $file = 'review-img-10.png';
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
       $uploadDir = '../../assets/img/categories/';
       if (!is_dir($uploadDir)) {
           mkdir($uploadDir, 0777, true);
       }
       $image_data_array = array();
       $rand=rand('11111','99999');
       $image_name = $_FILES['file']['name'];
       $image_tmp = $_FILES['file']['tmp_name'];
       $image_size = $_FILES['file']['size'];
        $file_extension =strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
       // Move the uploaded image to the uploadirectory
        $file = $rand.'__categories.'.$file_extension;
       $image_path = $uploadDir . $file;
       $allowed_extensions = array("jpg", "jpeg", "png", "webp", "svg");
        if(!in_array($file_extension, $allowed_extensions)){
            $response['message'] = "Invalid file type. Only JPG, JPEG, Webp, SVG and PNG files are allowed.";
            return $response;
        }
        if ($_FILES["file"]["size"] > 1000000) {
            $response['message'] = "your Image size is Large (limit to under 1 MB)";
        } 
        move_uploaded_file($image_tmp, $image_path);
    }

    $duplicateUrl = CheckDuplicate_categories($conn, $url);
    if (!$duplicateUrl) {
       $holidays_query = "INSERT INTO categories (Name,SlugUrl,Position,SeoTitle,SeoDescription,Image,CreatedDate,CreatedTime)VALUES('$title','$url','$position','$seo_title','$seo_description','$file','$CreatedDate','$CreatedTime')";
        $response = _InsertTableRecords($conn, $holidays_query);
        $response['message'] = "Data added to the System";
    } else {
      $response['message'] = "Same title to already exist";
    }
    return $response;
}

function UpdateCategories($conn,$data)
{
    $id = $data['cid'];
    $title = $data['name'];
    $specialUrl = str_replace(' ', '-', strtolower($title));
    $url = str_replace("&", "and", $specialUrl);
    $position = $data['position'];
    $seo_title = $data['seo_title'];
    $seo_description = $data['seo_description'];
    $file = '';
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
        $uploadDir = '../../assets/img/categories/';
        if (!is_dir($uploadDir)) {
           mkdir($uploadDir, 0777, true);
        }
        $image_data_array = array();
        $image_name = $_FILES['file']['name'];
        $image_tmp = $_FILES['file']['tmp_name'];
        $image_size = $_FILES['file']['size'];
        $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $file = $id.'_categories.'.$file_extension;
        $image_path = $uploadDir . $file;
        $allowed_extensions = array("jpg", "jpeg", "png", "webp", "svg");
        if(!in_array($file_extension, $allowed_extensions)){
            $response['message'] = "Invalid file type. Only JPG, JPEG, Webp, SVG and PNG files are allowed.";
            return $response;
        }
        if ($_FILES["file"]["size"] > 1000000) {
            $response['message'] = "your Image size is Large (limit to under 1 MB)";
           return $response;
        } else {
            $update_param = "Image = '$file' where ID ='$id'";
            $response = _UpdateTableRecords($conn,'categories', $update_param);
            move_uploaded_file($image_tmp, $image_path);
            $response['message'] = "image Updated to the System";
        }
    }
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
    $oldUrl = getCategoriesDetailsID($conn, $id);
    $duplicateUrl = CheckDuplicate_categories($conn, $url);
    if ($url != $oldUrl) {
        if (!$duplicateUrl) {
            $update_param = "Name = '$title',Position = '$position',SeoTitle = '$seo_title',SeoDescription = '$seo_description', SlugUrl='$url',CreatedDate='$CreatedDate' where ID = '$id'";
            $response = _UpdateTableRecords($conn,'categories', $update_param);
            $response['message'] = "data Updated to the System";
        } else {
            $response['message'] = "same title to already exist";
        }
    } else {
        $update_param = "Name = '$title',position = '$position',SeoTitle = '$seo_title',SeoDescription = '$seo_description', SlugUrl='$url',CreatedDate='$CreatedDate' where ID = '$id'";
            $response = _UpdateTableRecords($conn,'categories', $update_param);
        $response['message'] = "data Updated to the System";
    }
    return $response;
}


function CheckDuplicate_subcategories($conn, $url)
{
    $sql = "SELECT * FROM subcategories where SlugUrl = '$url'";
    if ($result = mysqli_query($conn, $sql)) {
        $rowcount = mysqli_num_rows($result);
        if ($rowcount > 0)
            return "Duplicate";
        else
            return false;
    }
    return false;
}

function getSubCategoriesDetailsID($conn, $ID)
{
    $slug = array();
    $sql = "Select * from subcategories where ID = $ID";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                extract($row);
                $slug = $row['SlugUrl'];
            }
        }
    } else {
        $error = mysqli_error($conn);
        echo $sql;
        echo $error;
        return $error;
    }
    return $slug;
}

function InsertSubCategories($conn,$data)
{
    $categories = $data['categories'];
    $title = $data['name'];
    $url = str_replace(' ', '-', strtolower($title));
    $position = $data['position'];
    $seo_title = $data['seo_title'];
    $seo_description = $data['seo_description'];
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
    $file = 'review-img-10.png';
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
       $uploadDir = '../../assets/img/subcategories/';
       if (!is_dir($uploadDir)) {
           mkdir($uploadDir, 0777, true);
       }
       $image_data_array = array();
       $rand=rand('11111','99999');
       $image_name = $_FILES['file']['name'];
       $image_tmp = $_FILES['file']['tmp_name'];
       $image_size = $_FILES['file']['size'];
        $file_extension =strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
       // Move the uploaded image to the uploadirectory
        $file = $rand.'__categories.'.$file_extension;
       $image_path = $uploadDir . $file;
       $allowed_extensions = array("jpg", "jpeg", "png", "webp", "svg");
        if(!in_array($file_extension, $allowed_extensions)){
            $response['message'] = "Invalid file type. Only JPG, JPEG, Webp, SVG and PNG files are allowed.";
            return $response;
        }
        if ($_FILES["file"]["size"] > 1000000) {
            $response['message'] = "your Image size is Large (limit to under 1 MB)";
        } 
        move_uploaded_file($image_tmp, $image_path);
    }

    $duplicateUrl = CheckDuplicate_subcategories($conn, $url);
    if (!$duplicateUrl) {
       $holidays_query = "INSERT INTO subcategories (Name,Categories,SlugUrl,Position,SeoTitle,SeoDescription,Image,CreatedDate,CreatedTime)VALUES('$title','$categories','$url','$position','$seo_title','$seo_description','$file','$CreatedDate','$CreatedTime')";
        $response = _InsertTableRecords($conn, $holidays_query);
        $response['message'] = "Data added to the System";
    } else {
      $response['message'] = "Same title to already exist";
    }
    return $response;
}

function UpdateSubCategories($conn,$data)
{
    $categories = $data['categories'];
    $id = $data['cid'];
    $title = $data['name'];
    $url = str_replace(' ', '-', strtolower($title));
    $position = $data['position'];
    $seo_title = $data['seo_title'];
    $seo_description = $data['seo_description'];
   
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
        $uploadDir = '../../assets/img/subcategories/';
        if (!is_dir($uploadDir)) {
           mkdir($uploadDir, 0777, true);
        }
        $image_data_array = array();
        $image_name = $_FILES['file']['name'];
        $image_tmp = $_FILES['file']['tmp_name'];
        $image_size = $_FILES['file']['size'];
        $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $file = $id.'_categories.'.$file_extension;
        $image_path = $uploadDir . $file;
        $allowed_extensions = array("jpg", "jpeg", "png", "webp", "svg");
        if(!in_array($file_extension, $allowed_extensions)){
            $response['message'] = "Invalid file type. Only JPG, JPEG, Webp, SVG and PNG files are allowed.";
            return $response;
        }
        if ($_FILES["file"]["size"] > 1000000) {
            $response['message'] = "your Image size is Large (limit to under 1 MB)";
           return $response;
        } else {
            $update_param = "Image = '$file' where ID ='$id'";
            $response = _UpdateTableRecords($conn,'subcategories', $update_param);
            move_uploaded_file($image_tmp, $image_path);
            $response['message'] = "image Updated to the System";
        }
    }
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
    $oldUrl = getSubCategoriesDetailsID($conn, $id);
    $duplicateUrl = CheckDuplicate_subcategories($conn, $url);
    if ($url != $oldUrl) {
        if (!$duplicateUrl) {
            $update_param = "Name = '$title',Categories = '$categories',Position = '$position',SeoTitle = '$seo_title',SeoDescription = '$seo_description', SlugUrl='$url',CreatedDate='$CreatedDate' where ID = '$id'";
            $response = _UpdateTableRecords($conn,'subcategories', $update_param);
            $response['message'] = "data Updated to the System";
        } else {
            $response['message'] = "same title to already exist";
        }
    } else {
        $update_param = "Name = '$title',Categories = '$categories',position = '$position',SeoTitle = '$seo_title',SeoDescription = '$seo_description', SlugUrl='$url',CreatedDate='$CreatedDate' where ID = '$id'";
            $response = _UpdateTableRecords($conn,'subcategories', $update_param);
        $response['message'] = "data Updated to the System";
    }
    return $response;
}


function InsertHomeBanner($conn,$data)
{
    $title_string = $data['name'];
    $title = str_replace("'", "''", $title_string);
    $url = str_replace(' ', '-', $title);
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
    $file = 'review-img-10.png';
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
       $uploadDir = '../../assets/img/home-banner/';
       if (!is_dir($uploadDir)) {
           mkdir($uploadDir, 0777, true);
       }
       $image_data_array = array();
       $rand=rand('11111','99999');
       $image_name = $_FILES['file']['name'];
       $image_tmp = $_FILES['file']['tmp_name'];
       $image_size = $_FILES['file']['size'];
        $file_extension =strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
       // Move the uploaded image to the uploadirectory
        $file = $rand.'_banner.'.$file_extension;
       $image_path = $uploadDir . $file;
       $allowed_extensions = array("jpg", "jpeg", "png", "webp", "svg");
        if(!in_array($file_extension, $allowed_extensions)) {
            $response['message'] = "Invalid file type. Only JPG, JPEG, Webp, SVG and PNG files are allowed.";
            return $response;
        }
        if ($_FILES["file"]["size"] > 1000000) {
            $response['message'] = "your Image size is Large (limit to under 1 MB)";
        } 
        move_uploaded_file($image_tmp, $image_path);
    }

    $holidays_query = "INSERT INTO home_banner (Name,SlugUrl,Image,CreatedDate,CreatedTime)VALUES('$title','$url','$file','$CreatedDate','$CreatedTime')";
    $response = _InsertTableRecords($conn, $holidays_query);
    $response['message'] = "Data added to the System";
    return $response;
}

function UpdateHomeBanner($conn,$data)
{

    $id = $data['cid'];
    $title_string = $data['name'];
    $title = str_replace("'", "''", $title_string);
    $url = str_replace(' ', '-', $title);
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
   
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
        $uploadDir = '../../assets/img/home-banner/';
        if (!is_dir($uploadDir)) {
           mkdir($uploadDir, 0777, true);
        }
        $image_data_array = array();
        $image_name = $_FILES['file']['name'];
        $image_tmp = $_FILES['file']['tmp_name'];
        $image_size = $_FILES['file']['size'];
        $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $file = $id.'_banner.'.$file_extension;
        $image_path = $uploadDir . $file;
        $allowed_extensions = array("jpg", "jpeg", "png", "webp", "svg");
        if(!in_array($file_extension, $allowed_extensions)) {
            $response['message'] = "Invalid file type. Only JPG, JPEG, Webp, SVG and PNG files are allowed.";
            return $response;
        }
        if ($_FILES["file"]["size"] > 1000000) {
            $response['message'] = "your Image size is Large (limit to under 1 MB)";
           return $response;
        } 
        $update_param = "Image = '$file' where ID ='$id'";
        $response = _UpdateTableRecords($conn,'home_banner', $update_param);
        move_uploaded_file($image_tmp, $image_path);
        $response['message'] = "image Updated to the System";
    }

    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
 
    $update_param = "Name = '$title', SlugUrl='$url',CreatedDate='$CreatedDate' where ID = '$id'";
    $response = _UpdateTableRecords($conn,'home_banner', $update_param);
    $response['message'] = "data Updated to the System";
    return $response;
}

function InsertHomePageBanner($conn,$data)
{
    $title_string = $data['name'];
    $title = str_replace("'", "''", $title_string);
    $url = str_replace(' ', '-', $title);
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
    $file = 'review-img-10.png';
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
       $uploadDir = '../../assets/img/home-page-banner/';
       if (!is_dir($uploadDir)) {
           mkdir($uploadDir, 0777, true);
       }
        $image_data_array = array();
        $rand=rand('11111','99999');
        $image_name = $_FILES['file']['name'];
        $image_tmp = $_FILES['file']['tmp_name'];
        $image_size = $_FILES['file']['size'];
        $file_extension =strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        // Move the uploaded image to the uploadirectory
        $file = $rand.'_banner.'.$file_extension;
        $image_path = $uploadDir . $file;
        $allowed_extensions = array("jpg", "jpeg", "png", "webp", "svg");
        if(!in_array($file_extension, $allowed_extensions)) {
            $response['message'] = "Invalid file type. Only JPG, JPEG, Webp, SVG and PNG files are allowed.";
            return $response;
        }
        if ($_FILES["file"]["size"] > 1000000) {
            $response['message'] = "your Image size is Large (limit to under 1 MB)";
        } 
        move_uploaded_file($image_tmp, $image_path);
    }

    $holidays_query = "INSERT INTO home_page_banner (Name,SlugUrl,Image,CreatedDate,CreatedTime)VALUES('$title','$url','$file','$CreatedDate','$CreatedTime')";
    $response = _InsertTableRecords($conn, $holidays_query);
    $response['message'] = "Data added to the System";
    return $response;
}

function UpdateHomePageBanner($conn,$data)
{

    $id = $data['cid'];
    $title_string = $data['name'];
    $title = str_replace("'", "''", $title_string);
    $url = str_replace(' ', '-', $title);
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
   
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
        $uploadDir = '../../assets/img/home-page-banner/';
        if (!is_dir($uploadDir)) {
           mkdir($uploadDir, 0777, true);
        }
        $image_data_array = array();
        $image_name = $_FILES['file']['name'];
        $image_tmp = $_FILES['file']['tmp_name'];
        $image_size = $_FILES['file']['size'];
        $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $file = $id.'_banner.'.$file_extension;
        $image_path = $uploadDir . $file;
        $allowed_extensions = array("jpg", "jpeg", "png", "webp", "svg");
        if(!in_array($file_extension, $allowed_extensions)) {
            $response['message'] = "Invalid file type. Only JPG, JPEG, Webp, SVG and PNG files are allowed.";
            return $response;
        }
        if ($_FILES["file"]["size"] > 1000000) {
            $response['message'] = "your Image size is Large (limit to under 1 MB)";
           return $response;
        } 
        $update_param = "Image = '$file' where ID ='$id'";
        $response = _UpdateTableRecords($conn,'home_page_banner', $update_param);
        move_uploaded_file($image_tmp, $image_path);
        $response['message'] = "image Updated to the System";
    }

    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
 
    $update_param = "Name = '$title', SlugUrl='$url',CreatedDate='$CreatedDate' where ID = '$id'";
    $response = _UpdateTableRecords($conn,'home_page_banner', $update_param);
    $response['message'] = "data Updated to the System";
    return $response;
}

function InsertListingDetailBanner($conn,$data)
{
    $title_string = $data['name'];
    $title = str_replace("'", "''", $title_string);
    $url = str_replace(' ', '-', $title);
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
    $file = 'review-img-10.png';
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
        $uploadDir = '../../assets/img/detail-page-banner/';
        if (!is_dir($uploadDir)) {
           mkdir($uploadDir, 0777, true);
        }
        $image_data_array = array();
        $rand=rand('11111','99999');
        $image_name = $_FILES['file']['name'];
        $image_tmp = $_FILES['file']['tmp_name'];
        $image_size = $_FILES['file']['size'];
        $file_extension =strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
       // Move the uploaded image to the uploadirectory
        $file = $rand.'_banner.'.$file_extension;
        $image_path = $uploadDir . $file;
        $allowed_extensions = array("jpg", "jpeg", "png", "webp", "svg");
        if(!in_array($file_extension, $allowed_extensions)) {
            $response['message'] = "Invalid file type. Only JPG, JPEG, Webp, SVG and PNG files are allowed.";
            return $response;
        }
        if ($_FILES["file"]["size"] > 1000000) {
            $response['message'] = "your Image size is Large (limit to under 1 MB)";
        }
        move_uploaded_file($image_tmp, $image_path);
    }

    $holidays_query = "INSERT INTO listing_detail_banner (Name,SlugUrl,Image,CreatedDate,CreatedTime)VALUES('$title','$url','$file','$CreatedDate','$CreatedTime')";
    $response = _InsertTableRecords($conn, $holidays_query);
    $response['message'] = "Data added to the System";
    return $response;
}

function UpdateListingDetailBanner($conn,$data)
{
    $id = $data['cid'];
    $title_string = $data['name'];
    $title = str_replace("'", "''", $title_string);
    $url = str_replace(' ', '-', $title);
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
   
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
        $uploadDir = '../../assets/img/detail-page-banner/';
        if (!is_dir($uploadDir)) {
           mkdir($uploadDir, 0777, true);
        }
        $image_data_array = array();
        $image_name = $_FILES['file']['name'];
        $image_tmp = $_FILES['file']['tmp_name'];
        $image_size = $_FILES['file']['size'];
        $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $file = $id.'_banner.'.$file_extension;
        $image_path = $uploadDir . $file;
        $allowed_extensions = array("jpg", "jpeg", "png", "webp", "svg");
        if(!in_array($file_extension, $allowed_extensions)) {
            $response['message'] = "Invalid file type. Only JPG, JPEG, Webp, SVG and PNG files are allowed.";
            return $response;
        }
        if ($_FILES["file"]["size"] > 1000000) {
            $response['message'] = "your Image size is Large (limit to under 1 MB)";
           return $response;
        } 
        $update_param = "Image = '$file' where ID ='$id'";
        $response = _UpdateTableRecords($conn,'listing_detail_banner', $update_param);
        move_uploaded_file($image_tmp, $image_path);
        $response['message'] = "image Updated to the System";
    }

    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
 
    $update_param = "Name = '$title', SlugUrl='$url',CreatedDate='$CreatedDate' where ID = '$id'";
    $response = _UpdateTableRecords($conn,'listing_detail_banner', $update_param);
    $response['message'] = "data Updated to the System";
    return $response;
}

function InsertListingFooterBanner($conn,$data)
{
    $title_string = $data['name'];
    $title = str_replace("'", "''", $title_string);
    $url = str_replace(' ', '-', $title);
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
    $file = 'review-img-10.png';
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
        $uploadDir = '../../assets/img/detail-footer-banner/';
        if (!is_dir($uploadDir)) {
           mkdir($uploadDir, 0777, true);
        }
        $image_data_array = array();
        $rand=rand('11111','99999');
        $image_name = $_FILES['file']['name'];
        $image_tmp = $_FILES['file']['tmp_name'];
        $image_size = $_FILES['file']['size'];
        $file_extension =strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
       // Move the uploaded image to the uploadirectory
        $file = $rand.'_banner.'.$file_extension;
        $image_path = $uploadDir . $file;
        $allowed_extensions = array("jpg", "jpeg", "png", "webp", "svg");
        if(!in_array($file_extension, $allowed_extensions)) {
            $response['message'] = "Invalid file type. Only JPG, JPEG, Webp, SVG and PNG files are allowed.";
            return $response;
        }
        if ($_FILES["file"]["size"] > 1000000) {
            $response['message'] = "your Image size is Large (limit to under 1 MB)";
        }
        move_uploaded_file($image_tmp, $image_path);
    }

    $holidays_query = "INSERT INTO listing_footer_banner (Name,SlugUrl,Image,CreatedDate,CreatedTime)VALUES('$title','$url','$file','$CreatedDate','$CreatedTime')";
    $response = _InsertTableRecords($conn, $holidays_query);
    $response['message'] = "Data added to the System";
    return $response;
}

function UpdateListingFooterBanner($conn,$data)
{
    $id = $data['cid'];
    $title_string = $data['name'];
    $title = str_replace("'", "''", $title_string);
    $url = str_replace(' ', '-', $title);
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
   
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
        $uploadDir = '../../assets/img/detail-footer-banner/';
        if (!is_dir($uploadDir)) {
           mkdir($uploadDir, 0777, true);
        }
        $image_data_array = array();
        $image_name = $_FILES['file']['name'];
        $image_tmp = $_FILES['file']['tmp_name'];
        $image_size = $_FILES['file']['size'];
        $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $file = $id.'_banner.'.$file_extension;
        $image_path = $uploadDir . $file;
        $allowed_extensions = array("jpg", "jpeg", "png", "webp", "svg");
        if(!in_array($file_extension, $allowed_extensions)) {
            $response['message'] = "Invalid file type. Only JPG, JPEG, Webp, SVG and PNG files are allowed.";
            return $response;
        }
        if ($_FILES["file"]["size"] > 1000000) {
            $response['message'] = "your Image size is Large (limit to under 1 MB)";
           return $response;
        } 
        $update_param = "Image = '$file' where ID ='$id'";
        $response = _UpdateTableRecords($conn,'listing_footer_banner', $update_param);
        move_uploaded_file($image_tmp, $image_path);
        $response['message'] = "image Updated to the System";
    }

    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
 
    $update_param = "Name = '$title', SlugUrl='$url',CreatedDate='$CreatedDate' where ID = '$id'";
    $response = _UpdateTableRecords($conn,'listing_footer_banner', $update_param);
    $response['message'] = "data Updated to the System";
    return $response;
}


function InsertUserBanner($conn,$data)
{
    $categories = $data['categories'];
    $title_string = $data['name'];
    $title = str_replace("'", "''", $title_string);
    $url = str_replace(' ', '-', $title);
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
    $file = 'review-img-10.png';
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
       $uploadDir = '../../assets/img/user-banner/';
       if (!is_dir($uploadDir)) {
           mkdir($uploadDir, 0777, true);
       }
       $image_data_array = array();
       $rand=rand('11111','99999');
       $image_name = $_FILES['file']['name'];
       $image_tmp = $_FILES['file']['tmp_name'];
       $image_size = $_FILES['file']['size'];
        $file_extension =strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
       // Move the uploaded image to the uploadirectory
        $file = $rand.'__categories.'.$file_extension;
       $image_path = $uploadDir . $file;
       $allowed_extensions = array("jpg", "jpeg", "png", "webp", "svg");
        if(!in_array($file_extension, $allowed_extensions)) {
            $response['message'] = "Invalid file type. Only JPG, JPEG, Webp, SVG and PNG files are allowed.";
            return $response;
        }
        if ($_FILES["file"]["size"] > 1000000) {
            $response['message'] = "your Image size is Large (limit to under 1 MB)";
        } 
        move_uploaded_file($image_tmp, $image_path);
    }

    $holidays_query = "INSERT INTO user_home_banner (Name,Categories,SlugUrl,Image,CreatedDate,CreatedTime)VALUES('$title','$categories','$url','$file','$CreatedDate','$CreatedTime')";
    $response = _InsertTableRecords($conn, $holidays_query);
    $response['message'] = "Data added to the System";
    return $response;
}

function UpdateUserBanner($conn,$data)
{
    $categories = $data['categories'];
    $id = $data['cid'];
    $title_string = $data['name'];
    $title = str_replace("'", "''", $title_string);
    $url = str_replace(' ', '-', $title);
     $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
   
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
        $uploadDir = '../../assets/img/user-banner/';
        if (!is_dir($uploadDir)) {
           mkdir($uploadDir, 0777, true);
        }
        $image_data_array = array();
        $image_name = $_FILES['file']['name'];
        $image_tmp = $_FILES['file']['tmp_name'];
        $image_size = $_FILES['file']['size'];
        $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $file = $id.'_categories.'.$file_extension;
        $image_path = $uploadDir . $file;
        $allowed_extensions = array("jpg", "jpeg", "png", "webp", "svg");
        if(!in_array($file_extension, $allowed_extensions)) {
            $response['message'] = "Invalid file type. Only JPG, JPEG, Webp, SVG and PNG files are allowed.";
            return $response;
        }
        if ($_FILES["file"]["size"] > 1000000) {
            $response['message'] = "your Image size is Large (limit to under 1 MB)";
           return $response;
        } 
        $update_param = "Image = '$file' where ID ='$id'";
        $response = _UpdateTableRecords($conn,'user_home_banner', $update_param);
        move_uploaded_file($image_tmp, $image_path);
        $response['message'] = "image Updated to the System";
    }
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
 
    $update_param = "Name = '$title',Categories = '$categories', SlugUrl='$url',CreatedDate='$CreatedDate' where ID = '$id'";
    $response = _UpdateTableRecords($conn,'user_home_banner', $update_param);
    $response['message'] = "data Updated to the System";
    return $response;
}

function InsertCategoryBanner($conn,$data)
{
    $categories = $data['categories'];
    $title_string = $data['name'];
    $title = str_replace("'", "''", $title_string);
    $url = str_replace(' ', '-', $title);
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
    $file = 'review-img-10.png';
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
       $uploadDir = '../../assets/img/category-banner/';
       if (!is_dir($uploadDir)) {
           mkdir($uploadDir, 0777, true);
       }
       $image_data_array = array();
       $rand=rand('11111','99999');
       $image_name = $_FILES['file']['name'];
       $image_tmp = $_FILES['file']['tmp_name'];
       $image_size = $_FILES['file']['size'];
        $file_extension =strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
       // Move the uploaded image to the uploadirectory
        $file = $rand.'__categories.'.$file_extension;
       $image_path = $uploadDir . $file;
       $allowed_extensions = array("jpg", "jpeg", "png", "webp", "svg");
        if(!in_array($file_extension, $allowed_extensions)) {
            $response['message'] = "Invalid file type. Only JPG, JPEG, Webp, SVG and PNG files are allowed.";
            return $response;
        }
        if ($_FILES["file"]["size"] > 1000000) {
            $response['message'] = "your Image size is Large (limit to under 1 MB)";
        } 
        move_uploaded_file($image_tmp, $image_path);
    }

    $holidays_query = "INSERT INTO categories_banner (Name,Categories,SlugUrl,Image,CreatedDate,CreatedTime)VALUES('$title','$categories','$url','$file','$CreatedDate','$CreatedTime')";
    $response = _InsertTableRecords($conn, $holidays_query);
    $response['message'] = "Data added to the System";
    return $response;
}

function UpdateCategoryBanner($conn,$data)
{
    $categories = $data['categories'];
    $id = $data['cid'];
    $title_string = $data['name'];
    $title = str_replace("'", "''", $title_string);
    $url = str_replace(' ', '-', $title);
     $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
   
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
        $uploadDir = '../../assets/img/category-banner/';
        if (!is_dir($uploadDir)) {
           mkdir($uploadDir, 0777, true);
        }
        $image_data_array = array();
        $image_name = $_FILES['file']['name'];
        $image_tmp = $_FILES['file']['tmp_name'];
        $image_size = $_FILES['file']['size'];
        $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $file = $id.'_categories.'.$file_extension;
        $image_path = $uploadDir . $file;
        $allowed_extensions = array("jpg", "jpeg", "png", "webp", "svg");
        if(!in_array($file_extension, $allowed_extensions)) {
            $response['message'] = "Invalid file type. Only JPG, JPEG, Webp, SVG and PNG files are allowed.";
            return $response;
        }
        if ($_FILES["file"]["size"] > 1000000) {
            $response['message'] = "your Image size is Large (limit to under 1 MB)";
           return $response;
        } 
        $update_param = "Image = '$file' where ID ='$id'";
        $response = _UpdateTableRecords($conn,'categories_banner', $update_param);
        move_uploaded_file($image_tmp, $image_path);
        $response['message'] = "image Updated to the System";
    }
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
 
    $update_param = "Name = '$title',Categories = '$categories', SlugUrl='$url',CreatedDate='$CreatedDate' where ID = '$id'";
    $response = _UpdateTableRecords($conn,'categories_banner', $update_param);
    $response['message'] = "data Updated to the System";
    return $response;
}

function InsertFeatures($conn,$data)
{
    $title = $data['name'];
    $position = $data['position'];
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
    $holidays_query = "INSERT INTO features (Name,Position,CreatedDate,CreatedTime)VALUES('$title','$position','$CreatedDate','$CreatedTime')";
    $response = _InsertTableRecords($conn, $holidays_query);
    $response['message'] = "Data added to the System";
    return $response;
}

function UpdateFeatures($conn,$data)
{
    $id = $data['cid'];
    $title = $data['name'];
    $position = $data['position'];
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
    $update_param = "Name = '$title',position = '$position',CreatedDate='$CreatedDate' where ID = '$id'";
    $response = _UpdateTableRecords($conn,'features', $update_param);
    $response['message'] = "data Updated to the System";
    return $response;
}

function InsertWeakend($conn,$data)
{
    $title = $data['name'];
    $start_time = $data['start_time'];
    $end_time = $data['end_time'];
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
    $holidays_query = "INSERT INTO weakends (Name,StartTime,EndTime,CreatedDate,CreatedTime)VALUES('$title','$start_time','$end_time','$CreatedDate','$CreatedTime')";
    $response = _InsertTableRecords($conn, $holidays_query);
    $response['message'] = "Data added to the system";
    return $response;
}

function UpdateWeakend($conn,$data)
{
    $id = $data['cid'];
    $title = $data['name'];
    $start_time = $data['start_time'];
    $end_time = $data['end_time'];
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
    $update_param = "Name = '$title',StartTime = '$start_time',EndTime = '$end_time',CreatedDate='$CreatedDate' where ID = '$id'";
    $response = _UpdateTableRecords($conn,'weakends', $update_param);
    $response['message'] = "Data Updated to the system";
    return $response;
}

function InsertReferralAgent($conn,$data)
{
    $name = $data['name'];
    $email = $data['email'];
    $phone = $data['phone'];
    $user_name_space = 'AG'.strtoupper($name);
    $user_name = str_replace(' ', '', $user_name_space);
    $first_3_chars = substr($user_name, 0, 5);
    $random_number = rand(100000, 999999);
    $refer_code = $first_3_chars . $random_number;
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
    $holidays_query = "INSERT INTO referral_agent (Name,Email,Phone,ReferralCode,CreatedDate,CreatedTime)VALUES('$name','$email','$phone','$refer_code','$CreatedDate','$CreatedTime')";
    $response = _InsertTableRecords($conn, $holidays_query);
    $response['message'] = "Data added to the system";
    return $response;
}

function UpdateReferralAgent($conn,$data)
{
    $id = $data['cid'];
    $title = $data['name'];
    $email = $data['email'];
    $phone = $data['phone'];
    $CreatedDate = date('d M Y');
    $CreatedTime = date('H:i:s'); 
    $update_param = "Name = '$title',Email = '$email',Phone = '$phone',CreatedDate='$CreatedDate' where ID = '$id'";
    $response = _UpdateTableRecords($conn,'referral_agent', $update_param);
    $response['message'] = "Data Updated to the system";
    return $response;
}

function GetAllCategories($conn)
{
    $where = " where Status = 1 ORDER BY Position ASC";
    $response = _getTableRecords($conn,'categories', $where);
    return $response;
}

function GetCategoriesByID($conn,$ID)
{
    $where = " where ID = '$ID'";
    $spare_part_details = _getTableDetails($conn,'categories', $where);
    return $spare_part_details;
}

function GetUserByID($conn,$ID)
{
    $where = " where ID = '$ID'";
    $spare_part_details = _getTableDetails($conn,'users', $where);
    return $spare_part_details;
}

function GetHomeDeliveryDetailByID($conn,$ID)
{
    $where = "where ID = '$ID'";
    $spare_part_details = _getTableDetails($conn,'home_booking', $where);
    return $spare_part_details;
}

function GetListingByUserID($conn,$ID)
{
    $where = " where UserID = '$ID'";
    $spare_part_details = _getTableDetails($conn,'listing', $where);
    return $spare_part_details;
}

function GetApprovedListing($conn)
{
    $where = " where Status = 'Approved' ORDER BY `ID` ASC";
    $response = _getTableRecords($conn,'listing', $where);
    return $response;
}

function GetUsersByRefferalCode($conn,$referralCode)
{
    $where = "where ReferralID = '$referralCode' AND Password != ''";
    $response = _getTableRecords($conn,'users', $where);
    return $response;
}

?>