<?php
class Model{

    private $db;

    function __construct(){
        require_once("../database/database.php");
        $this->db = new PDO_DB;
    }

    function registerUser($firstname, $middlename, $lastname, $birthdate, $city, $street, $barangay, $education_level, $contact, $email, $username, $password, $user_type, $status, $rating, $current_location, $report_count,$date_registered){
        $query = $this->db->query("INSERT INTO user VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", array(0, $user_type, $username, $password, $firstname, $middlename, $lastname, $birthdate, $city, $street, $barangay, $education_level, $contact, $email, $status, $rating, $current_location, $report_count, $date_registered,0), "CREATE");
        return $query;
    }



    function getAllUsers(){
        $query = $this->db->query("SELECT * FROM user", array(), "SELECT");
        return $query;
    }

    function getUserByUsername($username){
        $query = $this->db->query("SELECT * FROM user where username = ?", array($username), "SELECT");

        return $query;
    }

    function usernameExists($username){
        $query = $this->db->query("SELECT * FROM user WHERE username = ?", array($username), "SELECT");
        return $query;
    }

    function loginUser($username, $password,$token){
        $query = $this->db->query("SELECT * FROM user where username = ? and password = ?", array($username, $password), "SELECT");
        if(!empty($query)){
            $query2 = $this->db->query("UPDATE user SET status = ? WHERE username = ? ", array('active', $username), "UPDATE");
            $this->db->query("UPDATE token SET username = ? WHERE token = ?" ,array($username,$token),"UPDATE");
        }

        return $query;
    }
    function updateToken($token){
        	$query= $this->db->query("SELECT * FROM token WHERE token = ?",array($token),"SELECT");
        	if(count($query)==0){
        		 $query2= $this->db->query("INSERT INTO token VALUES(?,?,?)",array(0, $token,''),"CREATE");
             return $query2;
        	}
          return $query;
    }

	function logoutUser($username){
        $query = $this->db->query("UPDATE user SET status = ? WHERE username = ?", array("logged out", $username), "UPDATE");
        $query = $this->db->query("UPDATE token SET username= ? WHERE username=?", array("", $username),"UPDATE");
        return $query;
    }


    function changePassword($username, $newPassword){
        $query = $this->db->query("UPDATE user SET password = ? WHERE username = ? ", array($newPassword, $username), "UPDATE");
        return $query;
    }

    function changeProfile($city, $steet, $barangay, $education_level, $contact, $email, $username){
        $query = $this->db->query("UPDATE user SET city = ?, street = ?, barangay = ?, education_level = ?, contact = ?, email = ? WHERE username = ? ", array($city, $steet, $barangay, $education_level, $contact, $email, $username), "UPDATE");
        return $query;

    }

function getAllErrand(){
        $query = $this->db->query("SELECT * FROM errand_category", array(), "SELECT");
        return $query;
    }

    function getErrandDocument(){
        $query = $this->db->query("SELECT * FROM errand_document", array(), "SELECT");
        return $query;
    }



function getRequirementsByDocument($doc){
        $query = $this->db->query("SELECT document_requirement FROM errand_document where errand_document = ?", array($doc), "SELECT");
        return $query;
    }





function postErrand($eseekerUsername, $erunnerUsername, $id, $location, $date_published, $date_start, $date_end, $status, $description, $totalFee, $bookingFee, $ratePerHour, $rating, $feedback){
        $query = $this->db->query("INSERT INTO errand_transaction VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", array(0, $eseekerUsername, $erunnerUsername, $id, $location, $date_published, $date_start, $date_end, $status, $description, $totalFee, $bookingFee, $ratePerHour, $rating, $feedback), "CREATE");
        return $query;
    }

function getErrandCategoryByErrandOption($option_id){
  $query = $this->db->query("SELECT errand_name, option_name FROM errand_category LEFT JOIN errand_option ON errand_category.errand_category_id = errand_option.errand_category_id WHERE option_id = ?", array($option_id), "SELECT");
  return $query;
}

function getErrandOptionByCategory($id){
    $query = $this->db->query("SELECT * FROM errand_option where errand_category_id = ?", array($id), "SELECT");
    return $query;
}
function getErrandOptionDescription($name){
    $query = $this->db->query("SELECT * FROM errand_option where option_name = ?", array($name), "SELECT");
    return $query;
}
function getPaymentDetails($id){
    $query = $this->db->query("SELECT booking_fee, rate_per_hour FROM errand_option where option_id = ?", array($id), "SELECT");
    return $query;
}
function onId($optionName){
    $query = $this->db->query("SELECT option_id FROM errand_option where option_name = ?", array($optionName), "SELECT");
    return $query;
}

function getUserErrandsByErrandId($errandId){
    $query = $this->db->query("SELECT option_name, errand_name, errand_transaction.* FROM errand_transaction LEFT JOIN errand_option ON errand_transaction.option_id = errand_option.option_id LEFT JOIN errand_category ON errand_option.errand_category_id = errand_category.errand_category_id WHERE errand_id = ?", array($errandId), "SELECT");
    return $query;
}

function getUserErrandsByUsername($username, $type){
    $query = $this->db->query("SELECT errand_id, option_name, date_published, status FROM errand_transaction LEFT JOIN errand_option ON errand_transaction.option_id = errand_option.option_id WHERE {$type}_username = ? AND errand_transaction.status != ?", array($username, 'cancelled'), "SELECT");
    return $query;
}

// function getUserErrandsByUsername($username, $type){
//     if($type=='eseeker'){
//       $query = $this->db->query("SELECT option_name, user.*, errand_transaction.* FROM errand_transaction LEFT JOIN errand_option ON errand_transaction.option_id = errand_option.option_id LEFT JOIN user ON errand_transaction.eseeker_username = user.username WHERE eseeker_username = ?", array($username), "SELECT");
//     }
//     else{
//       $query = $this->db->query("SELECT option_name, user.*, errand_transaction.* FROM errand_transaction LEFT JOIN errand_option ON errand_transaction.option_id = errand_option.option_id LEFT JOIN user ON errand_transaction.erunner_username = user.username WHERE erunner_username = ?", array($username), "SELECT");
//     }
//     return $query;
// }




function getErrandById($id){
    $query = $this->db->query("SELECT * FROM errand_transaction WHERE status = ? and errand_id = ?", array('pending', $id), "SELECT");
    return $query;
}

function checkErrand($id){
    $query = $this->db->query("SELECT * FROM errand_transaction WHERE status = ? and errand_id = ?", array('waiting for accept', $id), "SELECT");
    return $query;
}

function checkErunnerCurrentErrand($username){
    $query = $this->db->query("SELECT * FROM errand_transaction WHERE erunner_username = ? AND status = ? OR erunner_username = ? OR status = ?", array($username, 'on-going', $username, 'waiting for accept'), "SELECT");
    return $query;
}

function checkErunerStatus($username){
    $query = $this->db->query("SELECT * FROM user WHERE username = ? AND status != ?", array($username, 'active'), "SELECT");
    return $query;
}

function getAvailableErunner($id){
        $query = $this->db->query("SELECT * FROM user LEFT JOIN services_offered ON user.username = services_offered.erunner_username WHERE type = ? AND user.status = ? AND services_offered.option_id = ? AND services_offered.status = ?", array('erunner', 'active', $id, 'offered'), "SELECT");
        return $query;
    }
function toNofification($notifyTo, $description, $date, $errandId){
    $query = $this->db->query("INSERT INTO notification VALUES (?,?,?,?,?)", array(0, $notifyTo, $description, $date, $errandId), "CREATE");
    return $query;
}

function updateMatchErrand($username, $errandId){
    $query = $this->db->query("UPDATE errand_transaction SET erunner_username = ?, status = ? WHERE errand_id = ?", array($username, 'waiting for accept', $errandId), "UPDATE");
    return $query;
}

function getTokenByUsername($username){
        $query = $this->db->query("SELECT token FROM token WHERE username = ?", array($username), "SELECT");
        return $query;
    }
function updateErunnerStatus($username){
            $query = $this->db->query("UPDATE user SET status = ? WHERE username = ?", array('unavailable', $username), "UPDATE");
            return $query;
        }

function getAllErrandOption(){
  $query = $this->db->query("SELECT * FROM errand_option", array(), "SELECT");
  return $query;
}

function onStatus(){
        $query = $this->db->query("SELECT errand_option.option_id AS optionid, errand_option.*, services_offered.* FROM errand_option LEFT JOIN services_offered ON errand_option.option_id = services_offered.option_id", array(), "SELECT");
        return $query;
    }
    function getOptionId($optionName){
            $query = $this->db->query("SELECT option_id FROM errand_option where option_name = ?", array($optionName), "SELECT");
            return $query;
        }

function getUserById($id){
  $query = $this->db->query("SELECT * FROM user WHERE user_id = ?", array($id), "SELECT");
  return $query;
}



function getOptionStatus($username){
        $query = $this->db->query("SELECT errand_option.option_id AS option_id, option_name, erunner_username, status FROM services_offered LEFT JOIN errand_option ON errand_option.option_id = services_offered.option_id WHERE erunner_username = ? ORDER BY errand_option.errand_category_id", array($username), "SELECT");
        return $query;
    }
    function onCreateServicesOffered($username, $option_id){
            $query = $this->db->query("INSERT INTO services_offered VALUES (?,?,?,?)", array(0, $username, $option_id, 'unoffered'), "CREATE");
            return $query;
        }
        function unofferServiceByUsername($username, $option_id){
                $query = $this->db->query("UPDATE services_offered SET status = ? WHERE erunner_username = ? and option_id = ?", array('unoffered', $username, $option_id), "UPDATE");
                return $query;
            }

            function offerServiceByUsername($username, $option_id){
                $query = $this->db->query("UPDATE services_offered SET status = ? WHERE erunner_username = ? and option_id = ?", array('offered', $username, $option_id), "UPDATE");
                return $query;
            }

            function cancelErrand($errand_id){
                $query = $this->db->query("UPDATE errand_transaction SET status = ? WHERE errand_id = ?", array('cancelled', $errand_id), "UPDATE");
                return $query;
            }

            function updateErrandStatus($errand_id, $status){
                if($status == 'pending'){
                    $query = $this->db->query("UPDATE errand_transaction SET status = ?, erunner_username = ? WHERE errand_id = ?", array($status, "", $errand_id), "UPDATE");
                    return $query;
                }
                else{
                    $query = $this->db->query("UPDATE errand_transaction SET status = ? WHERE errand_id = ?", array($status, $errand_id), "UPDATE");
                    return $query;
                }


}
function updateErrandStatusCompleted($errand_id, $total_fee, $status, $date_end){
        $query = $this->db->query("UPDATE errand_transaction SET status = ?, date_end = ?, total_fee =? WHERE errand_id = ?", array($status, $date_end, $total_fee, $errand_id), "UPDATE");
        return $query;
    }
}


?>
