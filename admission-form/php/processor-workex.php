<?php

include dirname( __FILE__ ).'/csrf_protection/csrf-token.php';
include dirname( __FILE__ ).'/csrf_protection/csrf-class.php';

if ( !isset( $_SESSION ) ) {
	$some_name = session_name( "VedicaAdmission" );
	session_start();
}

include dirname( __FILE__ ).'/config/config.php';
include dirname( __FILE__ ).'/config/functions.php';

$language = array( 'en' => 'en', 'pt' => 'pt' );

if ( isset( $_GET['lang'] ) and array_key_exists( $_GET['lang'], $language ) ) {
	include dirname( __FILE__ ).'/language/'.$language[$_GET['lang']].'.php';
} else {
	include dirname( __FILE__ ).'/language/en.php';
}

if ( !$_SESSION['userLogin'] && !$_SESSION['userName'] && !isset( $_SESSION['userName'] ) ) {

	timeout();

} else {
	$time = time();

	if ( $time > $_SESSION['expire'] ) {
		session_destroy();
		timeout();
		exit( 0 );
	}
}

$_SESSION['start'] = time();
$_SESSION['expire'] = $_SESSION['start'] + ( 60*60 );

if ( strlen( trim( $_SESSION['userName'] ) ) == 0 ) {
	session_destroy();
	timeout();
	die();
}

$applicationid = strip_tags( trim_awesome( $_SESSION['userName'] ) );
$isworkex = strip_tags( trim_awesome( $_POST['isworkex'] ) );
$employementtype = strip_tags( trim_awesome( $_POST['employementtype'] ) );
$organizationname = strip_tags( trim_awesome( $_POST['organizationname'] ) );
$organizationtype = strip_tags( trim_awesome( $_POST['organizationtype'] ) );
$organizationtypeother = strip_tags( trim_awesome( $_POST['organizationtypeother'] ) );
$workstarted = strip_tags( trim_awesome( $_POST['workstarted'] ) );
$workcompleted = strip_tags( trim_awesome( $_POST['workcompleted'] ) );
$comapnyjoinedas = strip_tags( trim_awesome( $_POST['comapnyjoinedas'] ) );
$currentdesignation = strip_tags( trim_awesome( $_POST['currentdesignation'] ) );
$annualrenumeration = strip_tags( trim_awesome( $_POST['annualrenumeration'] ) );
$rolesandresponsibility = strip_tags( trim_awesome( $_POST['rolesandresponsibility'] ) );
$extraworkexcount = strip_tags( trim_awesome( $_POST['extraworkexcount'] ) );
$totalworkex = strip_tags( trim_awesome( $_POST['totalworkex'] ) );



$finalapplicationid = htmlspecialchars( $applicationid, ENT_QUOTES, 'UTF-8' );
$finalisworkex = htmlspecialchars( $isworkex, ENT_QUOTES, 'UTF-8' );
$finalemployementtype = htmlspecialchars( $employementtype, ENT_QUOTES, 'UTF-8' );
$finalorganizationname = htmlspecialchars( $organizationname, ENT_QUOTES, 'UTF-8' );
$finalorganizationtype = htmlspecialchars( $organizationtype, ENT_QUOTES, 'UTF-8' );
$finalorganizationtypeother = htmlspecialchars( $organizationtypeother, ENT_QUOTES, 'UTF-8' );
$finalworkstarted = htmlspecialchars( $workstarted, ENT_QUOTES, 'UTF-8' );
$finalworkcompleted = htmlspecialchars( $workcompleted, ENT_QUOTES, 'UTF-8' );
$finalcomapnyjoinedas = htmlspecialchars( $comapnyjoinedas, ENT_QUOTES, 'UTF-8' );
$finalcurrentdesignation = htmlspecialchars( $currentdesignation, ENT_QUOTES, 'UTF-8' );
$finalannualrenumeration = htmlspecialchars( $annualrenumeration, ENT_QUOTES, 'UTF-8' );
$finalrolesandresponsibility = htmlspecialchars( $rolesandresponsibility, ENT_QUOTES, 'UTF-8' );
$finalextraworkexcount = htmlspecialchars( $extraworkexcount, ENT_QUOTES, 'UTF-8' );
$finaltotalworkex = htmlspecialchars( $totalworkex, ENT_QUOTES, 'UTF-8' );



if ( $mysql == true ) {
	$sqlworkex = "INSERT INTO `vedica_admn_2017`.`users_work_experience_details` (`application_id`, `work_experience`, `employement_type`, `name_of_organization`, `organization_type`, `organization_type_other`, `started_work_date`, `completed_work_date`, `joined_as`, `current_designation`, `annual_renumeration`, `roles_and_responsibilty`, `extra_workex_count`, `total_work_experience`) VALUES (
				".mysql_real_escape_string_awesome( $finalapplicationid ).",
				".mysql_real_escape_string_awesome( $finalisworkex ).",
				".mysql_real_escape_string_awesome( $finalemployementtype ).",
				".mysql_real_escape_string_awesome( $finalorganizationname ).",
				".mysql_real_escape_string_awesome( $finalorganizationtype ).",
				".mysql_real_escape_string_awesome( $finalorganizationtypeother ).",
				".mysql_real_escape_string_awesome( $finalworkstarted ).",
				".mysql_real_escape_string_awesome( $finalworkcompleted ).",
				".mysql_real_escape_string_awesome( $finalcomapnyjoinedas ).",
				".mysql_real_escape_string_awesome( $finalcurrentdesignation ).",
				".mysql_real_escape_string_awesome( $finalannualrenumeration ).",
				".mysql_real_escape_string_awesome( $finalrolesandresponsibility ).",
				".mysql_real_escape_string_awesome( $finalextraworkexcount ).",
				".mysql_real_escape_string_awesome( $finaltotalworkex )."
			)
			ON DUPLICATE KEY
			UPDATE
			work_experience = VALUES(work_experience),
			employement_type = VALUES(employement_type),
			name_of_organization = VALUES(name_of_organization),
			organization_type = VALUES(organization_type),
			organization_type_other = VALUES(organization_type_other),
			started_work_date = VALUES(started_work_date),
			completed_work_date = VALUES(completed_work_date),
			joined_as = VALUES(joined_as),
			current_designation = VALUES(current_designation),
			annual_renumeration = VALUES(annual_renumeration),
			roles_and_responsibilty = VALUES(roles_and_responsibilty),
			extra_workex_count = VALUES(extra_workex_count),
			total_work_experience = VALUES(total_work_experience)
			;";

	$insertworkex = mysql_query( $sqlworkex );

	if ( ! $insertworkex ) {
		die( 'Could not enter data: ' . mysql_error() );
	}


	$sqlworkexextradelete = "DELETE FROM added_work_experience_details WHERE application_id ='" . $finalapplicationid ."'";

	$deleteworkexextra = mysql_query( $sqlworkexextradelete );
	if ( ! $deleteworkexextra ) {
		die( 'Could not enter data: ' . mysql_error() );
	}


	for ( $x=1; $x<=$finalextraworkexcount; $x++ ) {


		$iemployementtype = "employementtype{$x}";
		$iorganizationname = "organizationname{$x}";
		$iorganizationtype = "organizationtype{$x}";
		$iorganizationtypeother = "organizationtypeother{$x}";
		$iindustrytype = "industrytype{$x}";
		$iworkstarted = "workstarted{$x}";
		$iworkcompleted = "workcompleted{$x}";
		$icomapnyjoinedas = "comapnyjoinedas{$x}";
		$icurrentdesignation = "currentdesignation{$x}";
		$iannualrenumeration = "annualrenumeration{$x}";
		$irolesandresponsibility = "rolesandresponsibility{$x}";
		$iextraworkexcount = "extraworkexcount{$x}";
		$itotalworkex = "totalworkex{$x}";


		${'employementtype' . $x} = strip_tags( trim_awesome( $_POST[$iemployementtype] ) );
		${'organizationname' . $x} = strip_tags( trim_awesome( $_POST[$iorganizationname] ) );
		${'organizationtype' . $x} = strip_tags( trim_awesome( $_POST[$iorganizationtype] ) );
		${'organizationtypeother' . $x} = strip_tags( trim_awesome( $_POST[$iorganizationtypeother] ) );
		${'industrytype' . $x} = strip_tags( trim_awesome( $_POST[$iindustrytype] ) );
		${'workstarted' . $x} = strip_tags( trim_awesome( $_POST[$iworkstarted] ) );
		${'workcompleted' . $x} = strip_tags( trim_awesome( $_POST[$iworkcompleted] ) );
		${'comapnyjoinedas' . $x} = strip_tags( trim_awesome( $_POST[$icomapnyjoinedas] ) );
		${'currentdesignation' . $x} = strip_tags( trim_awesome( $_POST[$icurrentdesignation] ) );
		${'annualrenumeration' . $x} = strip_tags( trim_awesome( $_POST[$iannualrenumeration] ) );
		${'rolesandresponsibility' . $x} = strip_tags( trim_awesome( $_POST[$irolesandresponsibility] ) );
		${'extraworkexcount' . $x} = strip_tags( trim_awesome( $_POST[$iextraworkexcount] ) );
		${'totalworkex' . $x} = strip_tags( trim_awesome( $_POST[$itotalworkex] ) );

		${'finalemployementtype' . $x} = htmlspecialchars( ${'employementtype' . $x}, ENT_QUOTES, 'UTF-8' );
		${'finalorganizationname' . $x} = htmlspecialchars( ${'organizationname' . $x}, ENT_QUOTES, 'UTF-8' );
		${'finalorganizationtype' . $x} = htmlspecialchars( ${'organizationtype' . $x}, ENT_QUOTES, 'UTF-8' );
		${'finalorganizationtypeother' . $x} = htmlspecialchars( ${'organizationtypeother' . $x}, ENT_QUOTES, 'UTF-8' );
		${'finalindustrytype' . $x} = htmlspecialchars( ${'industrytype' . $x}, ENT_QUOTES, 'UTF-8' );
		${'finalworkstarted' . $x} = htmlspecialchars( ${'workstarted' . $x}, ENT_QUOTES, 'UTF-8' );
		${'finalworkcompleted' . $x} = htmlspecialchars( ${'workcompleted' . $x}, ENT_QUOTES, 'UTF-8' );
		${'finalcomapnyjoinedas' . $x} = htmlspecialchars( ${'comapnyjoinedas' . $x}, ENT_QUOTES, 'UTF-8' );
		${'finalcurrentdesignation' . $x} = htmlspecialchars( ${'currentdesignation' . $x}, ENT_QUOTES, 'UTF-8' );
		${'finalannualrenumeration' . $x} = htmlspecialchars( ${'annualrenumeration' . $x}, ENT_QUOTES, 'UTF-8' );
		${'finalrolesandresponsibility' . $x} = htmlspecialchars( ${'rolesandresponsibility' . $x}, ENT_QUOTES, 'UTF-8' );
		${'finalextraworkexcount' . $x} = htmlspecialchars( ${'extraworkexcount' . $x}, ENT_QUOTES, 'UTF-8' );
		${'finaltotalworkex' . $x} = htmlspecialchars( ${'totalworkex' . $x}, ENT_QUOTES, 'UTF-8' );


		$sqlworkexextra = "INSERT INTO `vedica_admn_2017`.`added_work_experience_details` (`application_id`, `employement_type`, `name_of_organization`, `organization_type`, `organization_type_other`, `started_work_date`, `completed_work_date`, `joined_as`, `current_designation`, `annual_renumeration`, `roles_and_responsibilty`) VALUES (
				".mysql_real_escape_string_awesome( $finalapplicationid ).",
				".mysql_real_escape_string_awesome( ${'finalemployementtype' . $x} ).",
				".mysql_real_escape_string_awesome( ${'finalorganizationname' . $x} ).",
				".mysql_real_escape_string_awesome( ${'finalorganizationtype' . $x} ).",
				".mysql_real_escape_string_awesome( ${'finalorganizationtypeother' . $x} ).",
				".mysql_real_escape_string_awesome( ${'finalworkstarted' . $x} ).",
				".mysql_real_escape_string_awesome( ${'finalworkcompleted' . $x} ).",
				".mysql_real_escape_string_awesome( ${'finalcomapnyjoinedas' . $x} ).",
				".mysql_real_escape_string_awesome( ${'finalcurrentdesignation' . $x} ).",
				".mysql_real_escape_string_awesome( ${'finalannualrenumeration' . $x} ).",
				".mysql_real_escape_string_awesome( ${'finalrolesandresponsibility' . $x} )."
				);";


		$insertworkexextra = mysql_query( $sqlworkexextra );
		if ( ! $insertworkexextra ) {
			die( 'Could not enter data: ' . mysql_error() );
		}

	}

} else {

}

?>
