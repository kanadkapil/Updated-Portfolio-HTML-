<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portfolio";

// Check if the hero ID is provided in the URL
if (isset($_GET['id'])) {
  $heroId = $_GET['id'];

  // Create a connection to the database
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check for connection errors
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Retrieve the existing hero information from the database
  $stmt = $conn->prepare("SELECT * FROM hero_info WHERE hero_id = ?");
  $stmt->bind_param("i", $heroId);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();



    // Retrieve form data and keep existing values if not provided
    $heroName = isset($_POST['heroName']) ? $_POST['heroName'] : $row['hero_name'];
    $heroJob = isset($_POST['heroJob']) ? $_POST['heroJob'] : $row['hero_job'];
    $heroCompany = isset($_POST['heroCompany']) ? $_POST['heroCompany'] : $row['hero_company'];
    $heroProfession = isset($_POST['heroProfession']) ? $_POST['heroProfession'] : $row['hero_profession'];
    $heroUniversity =  isset($_POST['heroUniversity']) ? $_POST['heroUniversity'] : $row['hero_university'];
    $heroUniversitySubject = isset($_POST['heroUniversitySubject']) ? $_POST['heroUniversitySubject'] : $row['hero_university_subject'];
    $heroUniversityYear =  isset($_POST['heroUniversityYear']) ? $_POST['heroUniversityYear'] : $row['hero_university_year'];

    $heroImage = isset($_FILES['heroImage']['name']) ? $_FILES['heroImage']['name'] : $row['hero_img'];
    $heroCV = isset($_FILES['heroCV']['name']) ? $_FILES['heroCV']['name'] : $row['hero_cv'];

    $heroLongDetails = isset($_POST['heroLongDetails']) ? $_POST['heroLongDetails'] : $row['hero_long_details'];
    $heroShortDetails = isset($_POST['heroShortDetails']) ? $_POST['heroShortDetails'] : $row['hero_short_details'];
    $heroAbout = isset($_POST['heroAbout']) ? $_POST['heroAbout'] : $row['hero_about'];
    $heroHobbies = isset($_POST['heroHobbies']) ? $_POST['heroHobbies'] : $row['hero_hobbies'];
    $heroSkills = isset($_POST['heroSkills']) ? $_POST['heroSkills'] : $row['hero_skills'];

    $heroLinkedin = isset($_POST['heroLinkedin']) ? $_POST['heroLinkedin'] : $row['hero_linkedin'];
    $heroFacebook = isset($_POST['heroFacebook']) ? $_POST['heroFacebook'] : $row['hero_facebook'];
    $heroMobile = isset($_POST['heroMobile']) ? $_POST['heroMobile'] : $row['hero_mobile'];
    $heroInsta = isset($_POST['heroInsta']) ? $_POST['heroInsta'] : $row['hero_insta'];
    $heroGithub = isset($_POST['heroGithub']) ? $_POST['heroGithub'] : $row['hero_github'];
    $heroGmail = isset($_POST['heroGmail']) ? $_POST['heroGmail'] : $row['hero_gmail'];

    if(empty($_FILES['heroImage']['name'])){
      $heroImage = $_POST ['heroImageOld'];
    }else{
      $heroImage = isset($_FILES['heroImage']['name']) ? $_FILES['heroImage']['name'] : $row['hero_img'];
    }
    // Prepare and bind the SQL statement
    // $stmt = $conn->prepare("UPDATE hero_info SET hero_name = ?, hero_job = ?, hero_profession = ?, hero_img = ?, hero_cv = ?, hero_long_details = ?, hero_short_details = ?, hero_about = ?, hero_hobbies = ?, hero_skills = ?, hero_linkedin = ?, hero_facebook = ?, hero_mobile = ?, hero_insta = ?, hero_gmail = ?, hero_university = ?, hero_university_subject = ?, hero_university_year = ?, hero_company = ?, hero_github = ?   WHERE hero_id = ?");
    // $stmt->bind_param("sssssssssssssssi", $heroName, $heroJob, $heroProfession, $heroImage, $heroCV, $heroLongDetails, $heroShortDetails, $heroAbout, $heroHobbies, $heroSkills, $heroLinkedin, $heroFacebook, $heroMobile, $heroInsta, $heroGmail, $heroUniversity, $heroUniversitySubject, $heroUniversityYear, $heroCompany, $heroGithub, $heroId);
    $stmt = $conn->prepare("UPDATE hero_info SET hero_name=?, hero_job=?, hero_profession=?, hero_img=?, hero_cv=?, hero_long_details=?, hero_short_details=?, hero_about=?, hero_hobbies=?, hero_skills=?, hero_linkedin=?, hero_facebook=?, hero_mobile=?, hero_insta=?, hero_gmail=?, hero_university=?, hero_university_subject=?, hero_university_year=?, hero_company=?, hero_github=? WHERE hero_id=?");
    $stmt->bind_param("ssssssssssssssssssssi", $heroName, $heroJob, $heroProfession, $heroImage, $heroCV, $heroLongDetails, $heroShortDetails, $heroAbout, $heroHobbies, $heroSkills, $heroLinkedin, $heroFacebook, $heroMobile, $heroInsta, $heroGmail, $heroUniversity, $heroUniversitySubject, $heroUniversityYear, $heroCompany, $heroGithub, $heroId);


    // Move uploaded files to a designated folder if new files are provided
    if (isset($_FILES['heroImage']['name']) && !empty($_FILES['heroImage']['name'])) {
      $targetDir = "uploads/";
      $targetImage = $targetDir . basename($heroImage);
      move_uploaded_file($_FILES['heroImage']['tmp_name'], $targetImage);
    }

    if (isset($_FILES['heroCV']['name']) && !empty($_FILES['heroCV']['name'])) {
      $targetDir = "uploads/";
      $targetCV = $targetDir . basename($heroCV);
      move_uploaded_file($_FILES['heroCV']['tmp_name'], $targetCV);
    }

    // Execute the SQL statement
    // if ($stmt->execute()) {
    //   echo "Hero information updated successfully.";
    // } else {
    //   echo "Error updating hero information: " . $stmt->error;
    // }

    // Execute the SQL statement
    if ($stmt->execute()) {
      echo "Hero information updated successfully.";
    } else {
      echo "Error updating hero information: " . $stmt->error;
    }

    // Close the prepared statement
    // $stmt->close();
    $stmt->close();
  } else {
    echo 'Hero not found.';
  }

  // Close the database connection
  $conn->close();
} else {
  echo 'Hero ID not provided.';
}
?>
