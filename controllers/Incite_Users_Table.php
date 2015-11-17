<?php

require_once("DB_Connect.php");
    /**
     * Verify the username and password combination. Use a prepare object to
     * sanitize user-submitted text. Fetch the number of times where the username
     * and password combination match (Should be exactly 1)
     * If a 1 is returned, then the username and password combination worked,
     * 0 means it did not work --> return false
     * Account must be active in order to login
     * @param type $email to verify the account with (username)
     * @param type $password to verify the account with
     * @return boolean true if login successful, false otherwise
     */
    function verifyUser($email, $password)
    {
        $count = 0;
        $hashedPassword = md5($password);
        //var_dump($email);
        $db = DB_Connect::connectDB();
        $stmt = $db->prepare("SELECT COUNT(*) FROM omeka_incite_users WHERE email = ? AND password = ? AND is_active = 1");
        $stmt->bind_param("ss", $email, $hashedPassword);
        $stmt->bind_result($count);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        $db->close();
        if ($count == 1)
        {
            
            return true;
        }
        else
        {
            return false;
        }
        
    }
    /**
     * Gets information about the user in an array
     * array format = [ID, FIRSTNAME, LASTNAME, PRIVILEGE_LEVEL, EXPERIENCE_LEVEL]
     * @param type $email requires an email to check against
     * @return array containing information requested
     */
    function getUserData($email)
    {
        $arr = Array();
        $db = DB_Connect::connectDB();
        $stmt = $db->prepare("SELECT id, first_name, last_name, privilege_level, experience_level FROM omeka_incite_users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->bind_result($id, $firstname, $lastname, $priv, $exp);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        $db->close();
        
        $arr[0] = $id;
        $arr[1] = $firstname;
        $arr[2] = $lastname;
        $arr[3] = $priv;
        $arr[4] = $exp;
        return $arr;
    }
    /**
     * Check if the user is active. If the user is inactive, return false else
     * return true. We check this by selecting the 'is_active' column in the
     * database
     * @param type $email of the user to check if active
     * @return boolean true if active, false otherwise
     */
    function isUserActive($email)
    {
        $db = DB_Connect::connectDB();
        $stmt = $db->prepare("SELECT is_active FROM omeka_incite_users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->bind_result($count);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        $db->close();
        if ($count == 1)
        {
            return true;
        }
        return false;
    }
    /**
     * Change a user's password
     * @param string $email associated with account
     * @param string $newPassword to set for the account
     * @return boolean true if it worked, false otherwise
     */
    function changePassword($email, $newPassword)
    {
        $db = DB_Connect::connectDB();
        $stmt = $db->prepare("UPDATE omeka_incite_users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", md5($newPassword), $email);
        if (!$stmt->execute())
        {
            var_dump($stmt->error);
            $stmt->close();
            $db->close();
            return false;
        }
        $stmt->close();
        $db->close();
        return true;
    }
    /**
     * Upgrade or Downgrade user's experience level
     * @param string $email associated with account
     * @param int $experienceLevel to change to 
     * @return boolean true if successful, false otherwise
     */
    function changeExperienceLevel($email, $experienceLevel)
    {
        $db = DB_Connect::connectDB();
        $stmt = $db->prepare("UPDATE omeka_incite_users SET experience_level = ? WHERE email = ?");
        $stmt->bind_param("ss", $experienceLevel, $email);
        if (!$stmt->execute())
        {
            var_dump($stmt->error);
            $stmt->close();
            $db->close();
            return false;
        }
        $stmt->close();
        $db->close();
        return true;
    }
    /*
     * REMOVE AND ADD TO API FOR GROUPS
    public function addGroupID($userID, $groupID, $privilege)
    {
        $count = 0;
        $db = parent::getDB();
        $stmt = $db->prepare("SELECT COUNT(*) FROM omeka_incite_group_members WHERE user_id = ? AND group_id = ?");
        $stmt->bind_param("ii", $userID, $groupID);
        $stmt->bind_result($count);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        $db->close();
        if ($count == 0)
        {
            $db = parent::getDB();
            $stmt = $db->prepare("INSERT INTO omeka_incite_group_members VALUES (AUTO_INCREMENT, ?, ?, ?)");
        $stmt->bind_param("iii", $userID, $groupID, $privilege);
        $stmt->execute();
        $stmt->close();
        $db->close();
        }
        else
        {
            var_dump("ERROR: You are already added");
        }        
    }
    public function removeGroupID($userID, $groupID)
    {
        
        
    }
     *
     */
    /**
     * Safe way to 'remove' an account by setting it's active status to '0'
     * @param string $email associated with the account to deactivate
     * @return boolean true if worked, false otherwise 
     */
    function deactivateAccount($email)
    {
        $db = DB_Connect::connectDB();
        $stmt = $db->prepare("UPDATE omeka_incite_users SET is_active = 0 WHERE email = ?");
        $stmt->bind_param("s", $email);
        if (!$stmt->execute())
        {
            var_dump($stmt->error);
            $stmt->close();
            $db->close();
            return false;
        }
        $stmt->close();
        $db->close();
        return true;
        
    }
    /**
     * If account is inactive, reactivate the account
     * @param string $email associated with the account to activate
     * @return boolean true if successful, false otherwise (could be account
     * does not exist)
     */
    function reactivateAccount($email)
    {
        $db = DB_Connect::connectDB();
        $stmt = $db->prepare("UPDATE omeka_incite_users SET is_active = 1 WHERE email = ?");
        $stmt->bind_param("s", $email);
        if (!$stmt->execute())
        {
            var_dump($stmt->error);
            $stmt->close();
            $db->close();
            return false;
        }
        $stmt->close();
        $db->close();
        return true;
    }
    /**
     * Create a new account. If the same email exists for another account, an
     * error will be thrown
     * @param string $email to create account
     * @param string $password desired password
     * @param string $firstName first name
     * @param string $lastName last name
     * @param string $privilege type of user
     * @param int $experienceLevel user experience level
     * @return string "Success" or "Failure"
     */
    function createAccount($email, $password, $firstName, $lastName, $privilege, $experienceLevel)
    {
        $count = 0;
        $db = DB_Connect::connectDB();
        $stmt = $db->prepare("SELECT COUNT(*) FROM omeka_incite_users WHERE UPPER(email) = UPPER(?)");
        $stmt->bind_param("s", $email);
        $stmt->bind_result($count);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        if ($count == 0)
        {
            $hashedPassword = md5($password);
            $stmt = $db->prepare("INSERT INTO omeka_incite_users VALUES (NULL, ?, ?, ?, ?, ?, ?, 1, CURRENT_TIMESTAMP)");
            $stmt->bind_param("ssssii", $firstName, $lastName, $email, $hashedPassword, $privilege, $experienceLevel);
            $stmt->execute();
            $stmt->close();
            return "Success";
        }
        else
        {
            return "Failure";
        }
    }
    /**
     * Create a new account. If the same email exists for another account, an
     * error will be thrown
     * @param int $id to set the account to; Usually done only for guest accounts
     * @param string $email to create account
     * @param string $password desired password
     * @param string $firstName first name
     * @param string $lastName last name
     * @param string $privilege type of user
     * @param int $experienceLevel user experience level
     * @return string "Success" or "Failure"
     */
    function createGuestAccount($id, $email, $password, $firstName, $lastName, $privilege, $experienceLevel)
    {
        $count = 0;
        $db = DB_Connect::connectDB();
        $stmt = $db->prepare("SELECT COUNT(*) FROM omeka_incite_users WHERE UPPER(email) = UPPER(?)");
        $stmt->bind_param("s", $email);
        $stmt->bind_result($count);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        if ($count == 0)
        {
            $hashedPassword = md5($password);
            $stmt = $db->prepare("INSERT INTO omeka_incite_users VALUES (NULL, ?, ?, ?, ?, ?, ?, 1, CURRENT_TIMESTAMP)");
            $stmt->bind_param("ssssii", $firstName, $lastName, $email, $hashedPassword, $privilege, $experienceLevel);
            $stmt->execute();
            $stmt->close();
            return "Success";
        }
        else
        {
            return "Failure";
        }
    }
    /**
     * Remove account from database
     * WARNING! This will have cascading errors if used improperly
     * @param type $userID to remove from the database
     */
    function removeAccount($userID)
    {
        $db = DB_Connect::connectDB();
        $stmt = $db->prepare("DELETE FROM omeka_incite_users WHERE id = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->close();
        $db->close();
    }
    /**
     * Generate an 11 digit random user id. Used only for making an 
     * anonymous cookie for unlogged-in users
     * @return int 11 digit random number
     */
    function generateRandomUserId()
    {
        $temp = "";
        for ($i = 0; $i < 11; $i++)
        {
            $temp .= rand(0, 9);
        }
        return (int)$temp;
    }
    
    function createGuestSession()
    {
        $id = generateRandomUserId();
        $username = "guest".$id; //guest12345678900
        $password = "";
        $firstName = "guest";
        $lastName = "guest";
        $priv = 0;
        $exp = 0;
        if (createGuestAccount($id, $username, $password, $firstName, $lastName, $priv, $exp) != "failure") {
                //destroy previous session and then map it to the new session ==> store in new table
                if (!isset($_SESSION)) {
                    session_start();
                }
                $_SESSION['Incite']['IS_LOGIN_VALID'] = false;
                $_SESSION['Incite']['Guest'] = true;
                $_SESSION['Incite']['USER_DATA'] = getUserData($username);
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
    }
    /**
     * If the guest account is never used (not referenced in any table), then we can safely delete it from the database
     * @param int $id to delete
     */
    function deleteUnusedGuestAccount($id)
    {
        
    }
?>
