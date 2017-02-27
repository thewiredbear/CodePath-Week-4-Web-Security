<?php

  //
  // COUNTRY QUERIES
  //

  // Find all countries, ordered by name
  function find_all_countries() {
    global $db;
    $sql = "SELECT * FROM countries ";
    $sql .= "ORDER BY name ASC;";
    $country_result = db_query($db, $sql);
    return $country_result;
  }

  // Find country by ID
  function find_country_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM countries ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "';";
    $country_result = db_query($db, $sql);
    return $country_result;
  }

  function validate_country($country, $errors=array()) {
    if (is_blank($country['name'])) {
      $errors[] = "Name cannot be blank.";
    } elseif (!has_length($country['name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Name must be between 2 and 255 characters.";
    }

    if (is_blank($country['code'])) {
      $errors[] = "Code cannot be blank.";
    } elseif (!has_length($country['code'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Code must be between 2 and 255 characters.";
    }

    return $errors;
  }

  // Add a new country to the table
  // Either returns true or an array of errors
  function insert_country($country) {
    global $db;

    $errors = validate_country($country);
    if (!empty($errors)) {
      return $errors;
    }

    $countryName = db_escape($db, $country['name']);
    $countryName = htmlspecialchars($countryName);
    $countryCode = db_escape($db, $country['code']);
    $countryCode = htmlspecialchars($countryCode);

    $sql = "INSERT INTO countries ";
    $sql .= "(name, code) ";
    $sql .= "VALUES (";
    $sql .= "?" . ",";
    $sql .= "?" . "";
    $sql .= ");";
    $sql = $db->prepare($sql);
    $sql->bind_param("ss",$countryName,$countryCode);
    // For INSERT statements, $result is just true/false
    $result = $sql->execute();
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a country record
  // Either returns true or an array of errors
  function update_country($country) {
    global $db;

    $errors = validate_country($country);
    if (!empty($errors)) {
      return $errors;
    }

    $countryName = db_escape($db, $country['name']);
    $countryName = htmlspecialchars($countryName);
    $countryCode = db_escape($db, $country['code']);
    $countryCode = htmlspecialchars($countryCode);
    $countryID = db_escape($db, $country['id']);
    $countryID = htmlspecialchars($countryID);

    $sql = "UPDATE countries SET ";
    $sql .= "name=?" . ", ";
    $sql .= "code=?" . " ";
    $sql .= "WHERE id=?" . " ";
    $sql .= "LIMIT 1";
    $sql = $db->prepare($sql);
    $sql->bind_param("sss",$countryName,$countryCode,$countryID);
    // For update_country statements, $result is just true/false
    $result = $sql->execute();
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  //
  // STATE QUERIES
  //

  // Find all states, ordered by name
  function find_all_states() {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "ORDER BY name ASC;";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  // Find all states, ordered by name
  function find_states_for_country_id($country_id=0) {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "WHERE country_id='" . db_escape($db, $country_id) . "' ";
    $sql .= "ORDER BY name ASC;";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  // Find state by ID
  function find_state_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "';";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  function validate_state($state, $errors=array()) {
    if (is_blank($state['name'])) {
      $errors[] = "Name cannot be blank.";
    } elseif (!has_length($state['name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Name must be between 2 and 255 characters.";
    }

    if (is_blank($state['code'])) {
      $errors[] = "Code cannot be blank.";
    } elseif (!has_length($state['code'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Code must be between 2 and 255 characters.";
    }

    if (is_blank($state['country_id'])) {
      $errors[] = "Country ID cannot be blank.";
    }

    return $errors;
  }

  // Add a new state to the table
  // Either returns true or an array of errors
  function insert_state($state) {
    global $db;

    $errors = validate_state($state);
    if (!empty($errors)) {
      return $errors;
    }

    $stateName = db_escape($db, $state['name']);
    $stateName = htmlspecialchars($stateName);
    $stateCode = db_escape($db, $state['code']);
    $stateCode = htmlspecialchars($stateCode);
    $stateID = db_escape($db, $state['country_id']);
    $stateID = htmlspecialchars($stateID);

    $sql = "INSERT INTO states ";
    $sql .= "(name, code, country_id) ";
    $sql .= "VALUES (";
    $sql .= "?" . ",";
    $sql .= "?" . ",";
    $sql .= "?" . "";
    $sql .= ")";
    $sql = $db->prepare($sql);
    $sql->bind_param("sss",$stateName,$stateCode,$stateID);
    // For INSERT statements, $result is just true/false
    $result = $sql->execute();
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a state record
  // Either returns true or an array of errors
  function update_state($state) {
    global $db;

    $errors = validate_state($state);
    if (!empty($errors)) {
      return $errors;
    }

    $stateName = db_escape($db, $state['name']);
    $stateName = htmlspecialchars($stateName);
    $stateCode = db_escape($db, $state['code']);
    $stateCode = htmlspecialchars($stateCode);
    $stateID = db_escape($db, $state['country_id']);
    $stateID = htmlspecialchars($stateID);
    $stateI = db_escape($db, $state['id']);
    $stateI = htmlspecialchars($stateI);

    $sql = "UPDATE states SET ";
    $sql .= "name=?" . ", ";
    $sql .= "code=?" . ", ";
    $sql .= "country_id=?" . " ";
    $sql .= "WHERE id=?" . " ";
    $sql .= "LIMIT 1";
    $sql = $db->prepare($sql);
    $sql->bind_param("ssss",$stateName,$stateCode,$stateID,$stateI);
    // For update_state statements, $result is just true/false
    $result = $sql->execute();
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  //
  // TERRITORY QUERIES
  //

  // Find all territories, ordered by state_id
  function find_all_territories() {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "ORDER BY state_id ASC, position ASC;";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  // Find all territories whose state_id (foreign key) matches this id
  function find_territories_for_state_id($state_id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "WHERE state_id='" . db_escape($db, $state_id) . "' ";
    $sql .= "ORDER BY position ASC;";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  // Find territory by ID
  function find_territory_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "';";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  function validate_territory($territory, $errors=array()) {
    if (is_blank($territory['name'])) {
      $errors[] = "Name cannot be blank.";
    } elseif (!has_length($territory['name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Name must be between 2 and 255 characters.";
    }

    if (is_blank($territory['state_id'])) {
      $errors[] = "State ID cannot be blank.";
    }

    if (is_blank($territory['position'])) {
      $errors[] = "Position cannot be blank.";
    }

    return $errors;
  }

  // Add a new territory to the table
  // Either returns true or an array of errors
  function insert_territory($territory) {
    global $db;

    $errors = validate_territory($territory);
    if (!empty($errors)) {
      return $errors;
    }

    $terrName = db_escape($db, $territory['name']);
    $terrName = htmlspecialchars($terrName);
    $terrSID = db_escape($db, $territory['state_id']);
    $terrSID = htmlspecialchars($terrSID);
    $terrPOS = db_escape($db, $territory['position']);
    $terrPOS = htmlspecialchars($terrPOS);

    $sql = "INSERT INTO territories ";
    $sql .= "(name, state_id, position) ";
    $sql .= "VALUES (";
    $sql .= "?" . ",";
    $sql .= "?" . ",";
    $sql .= "?" . "";
    $sql .= ")";
    $sql = $db->prepare($sql);
    $sql->bind_param("sss",$terrName,$terrSID,$terrPOS);
    // For INSERT statements, $result is just true/false
    $result = $sql->execute();
    if($result) {
      return true;
    } else {
      // The SQL INSERT territoryment failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a territory record
  // Either returns true or an array of errors
  function update_territory($territory) {
    global $db;

    $errors = validate_territory($territory);
    if (!empty($errors)) {
      return $errors;
    }

    $terrName = db_escape($db, $territory['name']);
    $terrName = htmlspecialchars($terrName);
    $terrSID = db_escape($db, $territory['state_id']);
    $terrSID = htmlspecialchars($terrSID);
    $terrPOS = db_escape($db, $territory['position']);
    $terrPOS = htmlspecialchars($terrPOS);
    $terrID = db_escape($db, $territory['id']);
    $terrID = htmlspecialchars($terrID);

    $sql = "UPDATE territories SET ";
    $sql .= "name=?" . ", ";
    $sql .= "state_id=?" . ", ";
    $sql .= "position=?" . " ";
    $sql .= "WHERE id=?" . " ";
    $sql .= "LIMIT 1";
    $sql = $db->prepare($sql);
    $sql->bind_param("ssss",$terrName,$terrSID,$terrPOS,$terrID);
    // For update_territory statements, $result is just true/false
    $result = $sql->execute();
    if($result) {
      return true;
    } else {
      // The SQL UPDATE territoryment failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  //
  // SALESPERSON QUERIES
  //

  // Find all salespeople, ordered last_name, first_name
  function find_all_salespeople() {
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  // To find salespeople, we need to use the join table.
  // We LEFT JOIN salespeople_territories and then find results
  // in the join table which have the same territory ID.
  function find_salespeople_for_territory_id($territory_id=0) {
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "LEFT JOIN salespeople_territories
              ON (salespeople_territories.salesperson_id = salespeople.id) ";
    $sql .= "WHERE salespeople_territories.territory_id='" . db_escape($db, $territory_id) . "' ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  // Find salesperson using id
  function find_salesperson_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1;";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  function validate_salesperson($salesperson, $errors=array()) {
    if (is_blank($salesperson['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($salesperson['first_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "First name must be between 2 and 255 characters.";
    }

    if (is_blank($salesperson['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($salesperson['last_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    }

    if (is_blank($salesperson['email'])) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_valid_email_format($salesperson['email'])) {
      $errors[] = "Email must be a valid format.";
    }

    if (is_blank($salesperson['phone'])) {
      $errors[] = "Phone cannot be blank.";
    } elseif (!has_length($salesperson['phone'], array('max' => 255))) {
      $errors[] = "Phone must be less than 255 characters.";
    } elseif (!has_valid_phone_format($salesperson['phone'])) {
      $errors[] = "Phone can only contain numbers, spaces, parentheses, and dashes.";
    }
    return $errors;
  }

  // Add a new salesperson to the table
  // Either returns true or an array of errors
  function insert_salesperson($salesperson) {
    global $db;

    $errors = validate_salesperson($salesperson);
    if (!empty($errors)) {
      return $errors;
    }

    $salesFN = db_escape($db, $salesperson['first_name']);
    $salesFN = htmlspecialchars($salesFN);
    $salesLN = db_escape($db, $salesperson['last_name']);
    $salesLN = htmlspecialchars($salesLN);
    $salesPH = db_escape($db, $salesperson['phone']);
    $salesPH = htmlspecialchars($salesPH);
    $salesEM = db_escape($db, $salesperson['email']);
    $salesEM = htmlspecialchars($salesEM);

    $sql = "INSERT INTO salespeople ";
    $sql .= "(first_name, last_name, phone, email) ";
    $sql .= "VALUES (";
    $sql .= "?" . ",";
    $sql .= "?" . ",";
    $sql .= "?" . ",";
    $sql .= "?" . "";
    $sql .= ")";
    $sql = $db->prepare($sql);
    $sql->bind_param("ssss",$salesFN,$salesLN,$salesPH,$salesEM);
    // For INSERT statements, $result is just true/false
    $result = $sql->execute();
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a salesperson record
  // Either returns true or an array of errors
  function update_salesperson($salesperson) {
    global $db;

    $errors = validate_salesperson($salesperson);
    if (!empty($errors)) {
      return $errors;
    }

    $salesFN = db_escape($db, $salesperson['first_name']);
    $salesFN = htmlspecialchars($salesFN);
    $salesLN = db_escape($db, $salesperson['last_name']);
    $salesLN = htmlspecialchars($salesLN);
    $salesPH = db_escape($db, $salesperson['phone']);
    $salesPH = htmlspecialchars($salesPH);
    $salesEM = db_escape($db, $salesperson['email']);
    $salesEM = htmlspecialchars($salesEM);
    $salesID = db_escape($db, $salesperson['id']);
    $salesID = htmlspecialchars($salesID);

    $sql = "UPDATE salespeople SET ";
    $sql .= "first_name=?" . ", ";
    $sql .= "last_name=?" . ", ";
    $sql .= "phone=?" . ", ";
    $sql .= "email=?" . " ";
    $sql .= "WHERE id=?" . " ";
    $sql .= "LIMIT 1";
    $sql = $db->prepare($sql);
    $sql->bind_param("sssss",$salesFN,$salesLN,$salesPH,$salesEM,$salesID);
    // For update_salesperson statements, $result is just true/false
    $result = $sql->execute();
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // To find territories, we need to use the join table.
  // We LEFT JOIN salespeople_territories and then find results
  // in the join table which have the same salesperson ID.
  function find_territories_by_salesperson_id($id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "LEFT JOIN salespeople_territories
              ON (territories.id = salespeople_territories.territory_id) ";
    $sql .= "WHERE salespeople_territories.salesperson_id='" . db_escape($db, $id) . "' ";
    $sql .= "ORDER BY territories.name ASC;";
    $territories_result = db_query($db, $sql);
    return $territories_result;
  }

  //
  // USER QUERIES
  //

  // Find all users, ordered last_name, first_name
  function find_all_users() {
    global $db;
    $sql = "SELECT * FROM users ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $users_result = db_query($db, $sql);
    return $users_result;
  }

  // Find user using id
  function find_user_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM users ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1;";
    $users_result = db_query($db, $sql);
    return $users_result;
  }

  // find_users_by_username('rockclimber67');
  function find_users_by_username($username='') {
    global $db;
    $sql = "SELECT * FROM users ";
    $sql .= "WHERE username = '" . h($username) . "';";
    $users_result = db_query($db, $sql);
    return $users_result;
  }

  function validate_user($user, $errors=array()) {
    if (is_blank($user['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($user['first_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "First name must be between 2 and 255 characters.";
    }

    if (is_blank($user['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($user['last_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    }

    if (is_blank($user['email'])) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_valid_email_format($user['email'])) {
      $errors[] = "Email must be a valid format.";
    }

    if (is_blank($user['username'])) {
      $errors[] = "Username cannot be blank.";
    } elseif (!has_length($user['username'], array('max' => 255))) {
      $errors[] = "Username must be less than 255 characters.";
    } elseif (!has_valid_username_format($user['username'])) {
      $errors[] = "Username can only contain letters, numbers, and underscores.";
    } elseif (!is_unique_username($user['username'], $user['id'])) {
      $errors[] = "Username not allowed. Try another.";
    }
    return $errors;
  }

  // Add a new user to the table
  // Either returns true or an array of errors
  function insert_user($user) {
    global $db;

    $errors = validate_user($user);
    if (!empty($errors)) {
      return $errors;
    }

    $userFN = db_escape($db, $user['first_name']);
    $userFN = htmlspecialchars($userFN);
    $userLN = db_escape($db, $user['last_name']);
    $userLN = htmlspecialchars($userLN);
    $userEM = db_escape($db, $user['email']);
    $userEM = htmlspecialchars($userEM);
    $userUS = db_escape($db, $user['username']);
    $userUS = htmlspecialchars($userUS);

    $created_at = date("Y-m-d H:i:s");
    $sql = "INSERT INTO users ";
    $sql .= "(first_name, last_name, email, username, created_at) ";
    $sql .= "VALUES (";
    $sql .= "?" . ",";
    $sql .= "?" . ",";
    $sql .= "?" . ",";
    $sql .= "?" . ",";
    $sql .= "'" . $created_at . "'";
    $sql .= ")";
    $sql = $db->prepare($sql);
    $sql->bind_param("ssss",$userFN,$userLN,$userEM,$userUS);
    // For INSERT statements, $result is just true/false
    $result = $sql->execute();
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a user record
  // Either returns true or an array of errors
  function update_user($user) {
    global $db;

    $errors = validate_user($user);
    if (!empty($errors)) {
      return $errors;
    }

    $userFN = db_escape($db, $user['first_name']);
    $userFN = htmlspecialchars($userFN);
    $userLN = db_escape($db, $user['last_name']);
    $userLN = htmlspecialchars($userLN);
    $userEM = db_escape($db, $user['email']);
    $userEM = htmlspecialchars($userEM);
    $userUS = db_escape($db, $user['username']);
    $userUS = htmlspecialchars($userUS);
    $userID = db_escape($db, $user['id']);
    $usrID = htmlspecialchars($userID);

    #$sql = "UPDATE users SET ";
    #$sql .= "first_name='?"  . "', ";
    #$sql .= "last_name='?"  . "', ";
    #$sql .= "email='?" . "', ";
    ##$sql .= "username='?"  . "' ";
    #$sql .= "WHERE id='?" . "' ";
    #$sql .= "LIMIT 1;";
    $sql = "UPDATE users SET first_name=?,last_name=?,email=?,username=? WHERE id=? LIMIT 1";
    $sql = $db->prepare($sql);
    $sql->bind_param('sssss',$userFN,$userLN,$userEM,$userUS,$userID);
    // For update_user statements, $result is just true/false
    $result = $sql->execute();
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Delete a user record
  // Either returns true or false
  function delete_user($user) {
    global $db;

    $sql = "DELETE FROM users ";
    $sql .= "WHERE id='" . db_escape($db, $user['id']) . "' ";
    $sql .= "LIMIT 1;";
    // For update_user statements, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL DELETE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }


?>
