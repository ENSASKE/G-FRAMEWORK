// base Javascript

function irA(path,confirmMessage) {
	var answer = confirm(confirmMessage);
	if (answer == 1)	{
		location.href = path;
	}
}