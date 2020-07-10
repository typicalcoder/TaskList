/*
Copyright ForgeMC
VALIDATE PLUGIN
 */
let validatePatterns = {
	fio: /^([А-ЯA-Z]|[А-ЯA-Z][\x27а-яa-z]{1,}|[А-ЯA-Z][\x27а-яa-z]{1,}\-([А-ЯA-Z][\x27а-яa-z]{1,}|(оглы)|(кызы)))\040[А-ЯA-Z][\x27а-яa-z]{1,}(\040[А-ЯA-Z][\x27а-яa-z]{1,})?$/,
	name: /(^[A-Z]{1}[a-z]{1,14}$)|(^[А-Я]{1}[а-я]{1,14}$)/,
	email: /^[a-z0-9_.-]+@[a-z0-9-]+\.([a-z]{1,6}\.)?[a-z]{2,6}$/i,
	username: /^[A-Za-z0-9_-]{5,}$/,
	password: /(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/
};
validate = (obj, type) => {
	if (obj.val() !== '') {
		if (obj.val().search(validatePatterns[type]) === 0) {
			return obj.val();
		} else {
			return false;
		}
	} else {
		return false;
	}
}

fieldValid = ($obj) => {
	$obj.addClass("is-valid");
	$obj.removeClass("is-invalid");
}
fieldInvalid = ($obj) => {
	$obj.addClass("is-invalid");
	$obj.removeClass("is-valid");
}

checkValidity = (objects = [{name: "", name2: "", $obj: $(), $obj2: $(), type: ""}]) => {
	let msg = "";
	let valid = true;
	for(let obj of objects) {
		if(validatePatterns[obj.type] !== undefined) {
			if(validate(obj.$obj, obj.type)) fieldValid(obj.$obj);
			else {
				if(obj.name) msg += (msg !== "" ? "\n" : "") + "Поле \"" + obj.name + "\" заполнено не верно";
				fieldInvalid(obj.$obj);
				valid = false;
			}
		} else if(obj.type === "captcha") {
			if(obj.$obj.val() === undefined || obj.$obj.val().length === 0) {
				msg += (msg !== "" ? "<br>" : "")+"Подтвердите, что вы не робот (reCAPTCHA)";
				valid = false;
			}
		}  else if(obj.type === "compare") {
			if(obj.$obj.val() !== obj.$obj2.val()) {
				if(obj.name && obj.name2) msg += (msg !== "" ? "\n" : "") + "Поле \"" + obj.name + "\" и \"" + obj.name2 + "\" не совпадают";
				fieldInvalid(obj.$obj);
				valid = false;
			} else fieldValid(obj.$obj);
		} else {
			if(obj.$obj.val() !== undefined && obj.$obj.val().length > 0) fieldValid(obj.$obj);
			else {
				if(obj.name) msg += (msg !== "" ? "\n" : "")+"Поле \"" + obj.name + "\" заполнено не верно";
				fieldInvalid(obj.$obj);
				valid = false;
			}
		}
	}
	if(msg.length > 0) alert(msg);
	return valid;
}
/*
VALIDATE PLUGIN
 */


