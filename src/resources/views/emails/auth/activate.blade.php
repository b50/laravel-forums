<!DOCTYPE html>
<html lang="en-GB">
<head>
	<meta charset="utf-8">
</head>
<body>
<h2>Activate your account</h2>

<div>
	To activate your account, please visit the following link {{ URL::linkRoute('activate-account', [
		$activationCode
	]) }}.
</div>
</body>
</html>
