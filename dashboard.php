<?php
session_start();
//<!--completed by anuragz.v@gmail.com-->  
// Borrowed and modified from https://www.twilio.com/docs/tutorials/twilio-client-browser-soft-phone and https://www.twilio.com/docs/tutorials/twilio-client-browser-conference-call and http://codepen.io/virelli/pen/mnhgd
include 'php/db.php';
require_once 'vendor/autoload.php';
if (!file_exists('config.php')) {
    echo 'Please ensure config.php exists and is configured properly';
    exit;
}
$config = require_once 'config.php';
$protocol = (isset($_SERVER['HTTPS'])) ? 'https' : 'http';
$url = "{$protocol}://{$_SERVER['HTTP_HOST']}";

$token = new Services_Twilio_Capability($config['accountSid'], $config['authToken']);
$token->allowClientOutgoing($config['appSid']);


if (isset($_GET['code']) && !empty($_GET['code'])) {
    $conferenceCode = $_GET['code'];
} else {
    header('Location: /index.php');
}

if (isset($_SESSION['rname'])) {
    $rname = $_SESSION['rname'];
    $codecheck = "SELECT `code` FROM `saaslabs` WHERE `rname` LIKE '$rname' ";
    global $con;
    if ($result = mysqli_query($con, $codecheck)) {
        while ($row = $result->fetch_assoc()) {
            $code = $row['code'];
            if ($code != $_GET['code']) {
                header('Location: /index.php');
            }
        }
    }
} else {
    header('Location: /index.php');
}


if (isset($_GET['getParticipants'])) {
    header('Content-Type: application/json');

    $client = new Services_Twilio($config['accountSid'], $config['authToken']);
    $participants = [];

    //@TODO: Cache lots
    $conferences = $client->account->conferences->getPage(0, 50, array('Status' => 'in-progress'));
    foreach ($conferences->getItems() as $conference) {
        if ($conference->friendly_name == 'mciof' . $_GET['getParticipants']) {
            foreach ($client->account->conferences->get($conference->sid)->participants as $participant) {
                $call = $client->account->calls->get($participant->call_sid);
                $duration = (new DateTime())->getTimestamp() - (new DateTime($call->start_time))->getTimestamp();
                $participants[] = [
                    'callSid' => $participant->call_sid,
                    'dateCreated' => $participant->date_created,
                    'dateUpdated' => $participant->date_updated,
                    'call' => [
                        'from' => $call->from,
                        'duration' => $duration,
                    ]
                ];
            }
        }
    }

    echo json_encode($participants, JSON_PRETTY_PRINT);
    exit;
}

$deviceToken = $token->generateToken();
?>
<!DOCTYPE HTML>
<html>

<head>
	<title>
		SaasLabs Conference
	</title>
	<meta name="viewport" content="width=device-width, maximum-scale=1, minimum-scale=1" />
	<link href='//fonts.googleapis.com/css?family=Lato:100,300' rel='stylesheet' type='text/css'>
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<link href="/css/app.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script type="text/javascript" src="//media.twiliocdn.com/sdk/js/client/v1.4/twilio.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
	<script type="text/javascript" src="/js/moment.js"></script>
	<script type="text/javascript" src="/js/moment-duration-format.js"></script>
	<script type="text/javascript" src="/js/app.js"></script>
</head>

<body>
	<input type="hidden" id="deviceToken" value="<?= $deviceToken ?>">
	<input type="hidden" id="conferenceCode" value="<?= $conferenceCode ?>">
	<div class="container">
		<h3>WELCOME TO THE CONFERENCE ROOM</h3>
		<div style='display:none' class="alert alert-warning" id="muted" role="alert"><strong>Muted</strong> Hey there, you're muted, nobody can hear you</div>

		<div id="left">
			<div id="status">Hold on..</div>
			<div id="wrapper">
				<div class="key" rel="1">1</div>
				<div class="key" rel="2">2<span>abc</span></div>
				<div class="key" rel="3">3<span>def</span></div>
				<div class="clear"></div>
				<div class="key" rel="4">4<span>ghi</span></div>
				<div class="key" rel="5">5<span>jkl</span></div>
				<div class="key" rel="6">6<span>mno</span></div>
				<div class="clear"></div>
				<div class="key" rel="7">7<span>pqrs</span></div>
				<div class="key" rel="8">8<span>tuv</span></div>
				<div class="key" rel="9">9<span>wxyz</span></div>
				<div class="clear"></div>
				<div class="key special" rel="*">*</div>
				<div class="key" rel="1">0<span>oper</span></div>
				<div class="key special" rel="#">#</div>
				<div class="clear"></div>
				<div class="key nb"></div>
				<div class="key phone" rel="connect" style="display: none"><i class="fa fa-phone"></i></div>
				<div class="key muteSwitch" rel="muteSwitch" style="display: none"><i class="fa fa-microphone-slash"></i></div>
				<div class="clear"></div>
			</div>
		</div>
		<div id="right">
			<div id="conferenceCode">Conference code: <?= $conferenceCode ?> <small><a href="/dashboard.php?code=<?= $conferenceCode ?>">Share</a></small></div>

			<?php
            if (isset($config['numbers']) && !empty($config['numbers'])) {
                echo "<div id='callbyphonewrapper'><h3>Call by phone</h3>";
                foreach ($config['numbers'] as $countryCode => $number) {
                    echo "<div class='callbyphone'><strong>{$countryCode}</strong>: <a href='tel:{$number}'>{$number}</a></div>";
                }
                echo "</div>";
            }
            ?>

			<h3 id="participantsHeader">Participants</h3>
			<div id="participants"></div>
		</div>
		<div class="clear">&nbsp;
		</div>
		<br /><br />
		<button type="button" onClick="logout();" class="btn btn-primary btn-lg">Leave Room..</button><br /><br />
		<small>(please hang the call before leaving the room, thankyou)</small>
	</div>
	<script>
		function logout() {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					window.location.href = "/index.php";
				}
			};
			xhttp.open("GET", "/php/logout.php", true);
			xhttp.send();
		}
	</script>
</body>

</html>